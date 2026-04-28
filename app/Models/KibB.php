<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibB extends Model
{
    protected $table = 'kib_bs';
    protected $fillable = ['aset_id', 'merk', 'tipe', 'nomor_seri', 'nomor_polisi', 'tahun_pembelian'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
