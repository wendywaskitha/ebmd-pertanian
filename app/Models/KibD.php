<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibD extends Model
{
    protected $table = 'kib_ds';
    protected $fillable = ['aset_id', 'konstruksi', 'panjang', 'luas', 'tanggal_kontrak', 'nomor_kontrak', 'status_tanah', 'asal_usul'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
