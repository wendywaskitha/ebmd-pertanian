<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibD extends Model
{
    protected $table = 'kib_ds';
    protected $fillable = ['aset_id', 'panjang', 'kondisi_kib_d'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
