<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_aset' => Aset::count(),
            'kondisi_baik' => Aset::where('kondisi', 'Baik')->count(),
            'kondisi_rusak' => Aset::where('kondisi', 'Rusak Berat')->count(),
            'total_nilai' => Aset::sum('nilai'),
        ];

        $kib_labels = ['A', 'B', 'C', 'D', 'E', 'F'];
        $kib_values = [];
        foreach ($kib_labels as $label) {
            $kib_values[] = Aset::where('kib_type', $label)->count();
        }

        $kondisi_labels = ['Baik', 'Kurang Baik', 'Rusak Berat'];
        $kondisi_values = [];
        foreach ($kondisi_labels as $label) {
            $kondisi_values[] = Aset::where('kondisi', $label)->count();
        }

        $recent_activities = StockOpname::with('aset')->latest()->take(5)->get();
        $recent_asets = Aset::latest()->take(5)->get();

        return view('dashboard', compact(
            'stats', 
            'kib_labels', 
            'kib_values', 
            'kondisi_labels', 
            'kondisi_values', 
            'recent_activities',
            'recent_asets'
        ));
    }
}
