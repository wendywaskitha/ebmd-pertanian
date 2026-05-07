<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibB extends Model
{
    protected $table = 'kib_bs';
    protected $fillable = ['aset_id', 'merk', 'tipe', 'ukuran', 'nomor_seri', 'nomor_rangka', 'nomor_polisi', 'nomor_bpkb', 'tahun_pembelian', 'asal_usul', 'ruang_penyimpanan'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
