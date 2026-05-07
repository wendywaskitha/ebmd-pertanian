<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;

use App\Exports\KibTemplateExport;
use App\Imports\KibImport;
use Maatwebsite\Excel\Facades\Excel;

class KibController extends Controller
{
    public function index($type)
    {
        $validTypes = ['A', 'B', 'C', 'D', 'E', 'F'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $asets = Aset::with(['lokasi', 'kib' . $type])
            ->where('kib_type', $type)
            ->latest()
            ->paginate(10);
        return view('kib.index', compact('asets', 'type'));
    }

    public function printBulkQr($type)
    {
        $validTypes = ['A', 'B', 'C', 'D', 'E', 'F'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $asets = Aset::where('kib_type', $type)
            ->orderBy('kode_aset')
            ->get();

        return view('kib.print-bulk', compact('asets', 'type'));
    }

    public function downloadTemplate($type)
    {
        $validTypes = ['A', 'B', 'C', 'D', 'E', 'F'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        return Excel::download(new KibTemplateExport($type), 'Template_KIB_' . $type . '.xlsx');
    }

    public function import(Request $request, $type)
    {
        $validTypes = ['A', 'B', 'C', 'D', 'E', 'F'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new KibImport($type), $request->file('file'));
            return back()->with('success', 'Data KIB ' . $type . ' berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errorMsg = '';
             foreach ($failures as $failure) {
                 $errorMsg .= 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . '<br>';
             }
             return back()->with('error', 'Gagal mengimpor data:<br>' . $errorMsg);
        } catch (\Illuminate\Validation\ValidationException $e) {
             return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
             return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
