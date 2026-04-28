<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibC extends Model
{
    protected $table = 'kib_cs';
    protected $fillable = ['aset_id', 'luas_bangunan', 'alamat'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
