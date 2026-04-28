<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
            'status' => 'required|in:Baik,Kurang Baik,Rusak Ringan,Rusak Berat,Hilang',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $stockOpname = StockOpname::create($request->all());

        // Update current condition in Aset table
        $stockOpname->aset->update([
            'kondisi' => $request->status
        ]);

        return back()->with('success', 'Stock opname berhasil disimpan dan kondisi aset diperbarui');
    }
}
