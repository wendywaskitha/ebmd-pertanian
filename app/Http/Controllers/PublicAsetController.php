<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;

class PublicAsetController extends Controller
{
    public function show($kode_aset)
    {
        $aset = Aset::where('kode_aset', $kode_aset)
            ->with(['lokasi', 'lampirans', 'kibA', 'kibB', 'kibC', 'kibD', 'kibE', 'kibF'])
            ->firstOrFail();

        return view('public.aset.show', compact('aset'));
    }
}
