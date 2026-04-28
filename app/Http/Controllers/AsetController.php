<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Lokasi;
use App\Models\KibA;
use App\Models\KibB;
use App\Models\KibC;
use App\Models\KibD;
use App\Models\KibE;
use App\Models\KibF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asets = Aset::with('lokasi')->latest()->paginate(10);
        return view('aset.index', compact('asets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lokasis = Lokasi::all();
        return view('aset.create', compact('lokasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:asets',
            'nama_aset' => 'required',
            'kib_type' => 'required|in:A,B,C,D,E,F',
            'lokasi_id' => 'required|exists:lokasis,id',
            'tahun_perolehan' => 'required|numeric',
            'nilai' => 'required|numeric',
            'kondisi' => 'required|in:Baik,Kurang Baik,Rusak Ringan,Rusak Berat,Hilang',
            'foto' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('asets', 'public');
            }

            $aset = Aset::create($data);

            // Store KIB Details
            $this->storeKibDetails($aset, $request);

            DB::commit();
            return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan aset: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Aset $aset)
    {
        $aset->load(['lokasi', 'kibA', 'kibB', 'kibC', 'kibD', 'kibE', 'kibF']);
        return view('aset.show', compact('aset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aset $aset)
    {
        $lokasis = Lokasi::all();
        $aset->load(['kibA', 'kibB', 'kibC', 'kibD', 'kibE', 'kibF']);
        return view('aset.edit', compact('aset', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aset $aset)
    {
        $request->validate([
            'kode_aset' => 'required|unique:asets,kode_aset,' . $aset->id,
            'nama_aset' => 'required',
            'kib_type' => 'required|in:A,B,C,D,E,F',
            'lokasi_id' => 'required|exists:lokasis,id',
            'tahun_perolehan' => 'required|numeric',
            'nilai' => 'required|numeric',
            'kondisi' => 'required|in:Baik,Kurang Baik,Rusak Ringan,Rusak Berat,Hilang',
            'foto' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $oldKibType = $aset->kib_type;
            $newKibType = $request->kib_type;

            $data = $request->all();
            if ($request->hasFile('foto')) {
                if ($aset->foto) Storage::disk('public')->delete($aset->foto);
                $data['foto'] = $request->file('foto')->store('asets', 'public');
            }

            $aset->update($data);

            // If KIB type changed, delete old KIB data
            if ($oldKibType !== $newKibType) {
                $this->deleteKibDetails($aset, $oldKibType);
            }

            // Update or Create KIB Details
            $this->storeKibDetails($aset, $request);

            DB::commit();
            return redirect()->route('aset.index')->with('success', 'Aset berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui aset: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aset $aset)
    {
        if ($aset->foto) Storage::disk('public')->delete($aset->foto);
        $aset->delete();
        return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus');
    }

    /**
     * Print QR Code for a specific asset.
     */
    public function printQr(Aset $aset)
    {
        return view('aset.print-qr', compact('aset'));
    }

    /**
     * Helper to store KIB details.
     */
    private function storeKibDetails($aset, $request)
    {
        switch ($request->kib_type) {
            case 'A':
                $aset->kibA()->updateOrCreate(['aset_id' => $aset->id], $request->only(['luas', 'status_tanah', 'nomor_sertifikat']));
                break;
            case 'B':
                $aset->kibB()->updateOrCreate(['aset_id' => $aset->id], $request->only(['merk', 'tipe', 'nomor_seri', 'nomor_polisi', 'tahun_pembelian']));
                break;
            case 'C':
                $aset->kibC()->updateOrCreate(['aset_id' => $aset->id], $request->only(['luas_bangunan', 'alamat']));
                break;
            case 'D':
                $aset->kibD()->updateOrCreate(['aset_id' => $aset->id], $request->only(['panjang', 'kondisi_kib_d']));
                break;
            case 'E':
                $aset->kibE()->updateOrCreate(['aset_id' => $aset->id], $request->only(['jenis', 'keterangan']));
                break;
            case 'F':
                $aset->kibF()->updateOrCreate(['aset_id' => $aset->id], $request->only(['progress', 'nilai_kontrak', 'vendor']));
                break;
        }
    }

    /**
     * Helper to delete KIB details when type changes.
     */
    private function deleteKibDetails($aset, $type)
    {
        switch ($type) {
            case 'A': $aset->kibA()->delete(); break;
            case 'B': $aset->kibB()->delete(); break;
            case 'C': $aset->kibC()->delete(); break;
            case 'D': $aset->kibD()->delete(); break;
            case 'E': $aset->kibE()->delete(); break;
            case 'F': $aset->kibF()->delete(); break;
        }
    }
}
