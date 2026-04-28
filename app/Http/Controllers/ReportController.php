<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Lokasi;
use App\Exports\AsetExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Aset::with('lokasi');

        if ($request->filled('kib_type')) {
            $query->where('kib_type', $request->kib_type);
        }
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $asets = $query->latest()->get();
        $lokasis = Lokasi::all();

        return view('report.index', compact('asets', 'lokasis'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new AsetExport($request), 'laporan-aset-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Aset::with('lokasi');
        
        if ($request->filled('kib_type')) {
            $query->where('kib_type', $request->kib_type);
            $query->with('kib' . $request->kib_type);
        }
        
        if ($request->filled('lokasi_id')) $query->where('lokasi_id', $request->lokasi_id);
        if ($request->filled('kondisi')) $query->where('kondisi', $request->kondisi);
        
        $asets = $query->get();
        $type = $request->kib_type;
        
        $pdf = Pdf::loadView('report.pdf', compact('asets', 'type'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-aset-' . date('Y-m-d') . '.pdf');
    }
}
