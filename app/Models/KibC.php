<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibC extends Model
{
    protected $table = 'kib_cs';
    protected $fillable = ['aset_id', 'luas_bangunan', 'bertingkat', 'tanggal_kontrak', 'nomor_kontrak', 'alamat', 'status_tanah', 'kode_tanah', 'asal_usul'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
