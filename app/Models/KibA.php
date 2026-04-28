<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibA extends Model
{
    protected $table = 'kib_as';
    protected $fillable = ['aset_id', 'luas', 'status_tanah', 'nomor_sertifikat'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
