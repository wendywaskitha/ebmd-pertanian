<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;

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
}
