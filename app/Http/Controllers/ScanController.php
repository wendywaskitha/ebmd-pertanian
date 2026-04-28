<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function lookup(Request $request)
    {
        $input = $request->code;
        $code = $input;

        // If the scan result contains "KODE: ", extract just the code
        if (preg_match('/KODE:\s*([^\n]+)/', $input, $matches)) {
            $code = trim($matches[1]);
        }

        $aset = Aset::with(['lokasi', 'kibA', 'kibB', 'kibC', 'kibD', 'kibE', 'kibF'])
                    ->where('kode_aset', $code)
                    ->first();

        if ($aset) {
            // Prepare dynamic KIB attributes
            $kib_data = [];
            if ($aset->kib_type == 'A' && $aset->kibA) {
                $kib_data = ['Luas' => $aset->kibA->luas . ' m2', 'Status' => $aset->kibA->status_tanah, 'Sertifikat' => $aset->kibA->nomor_sertifikat];
            } elseif ($aset->kib_type == 'B' && $aset->kibB) {
                $kib_data = ['Merk' => $aset->kibB->merk, 'Tipe' => $aset->kibB->tipe, 'No Seri' => $aset->kibB->nomor_seri, 'Thn Beli' => $aset->kibB->tahun_pembelian];
            } elseif ($aset->kib_type == 'C' && $aset->kibC) {
                $kib_data = ['Luas Bangunan' => $aset->kibC->luas_bangunan . ' m2', 'Alamat' => $aset->kibC->alamat];
            } elseif ($aset->kib_type == 'D' && $aset->kibD) {
                $kib_data = ['Panjang' => $aset->kibD->panjang . ' m', 'Kondisi' => $aset->kibD->kondisi_kib_d];
            } elseif ($aset->kib_type == 'E' && $aset->kibE) {
                $kib_data = ['Jenis' => $aset->kibE->jenis, 'Keterangan' => $aset->kibE->keterangan];
            } elseif ($aset->kib_type == 'F' && $aset->kibF) {
                $kib_data = ['Progress' => $aset->kibF->progress . '%', 'Kontrak' => number_format($aset->kibF->nilai_kontrak, 0, ',', '.'), 'Vendor' => $aset->kibF->vendor];
            }

            return response()->json([
                'success' => true, 
                'redirect' => route('aset.show', $aset),
                'aset' => [
                    'id' => $aset->id,
                    'kode' => $aset->kode_aset,
                    'nama' => $aset->nama_aset,
                    'kib' => $aset->kib_type,
                    'lokasi' => $aset->lokasi->nama_lokasi ?? '-',
                    'tahun' => $aset->tahun_perolehan,
                    'nilai' => number_format($aset->nilai, 0, ',', '.'),
                    'kondisi' => $aset->kondisi,
                    'foto' => $aset->foto ? asset('storage/' . $aset->foto) : null,
                    'kib_data' => $kib_data
                ]
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Aset tidak ditemukan']);
    }
}
