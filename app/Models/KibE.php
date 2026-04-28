<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibE extends Model
{
    protected $table = 'kib_es';
    protected $fillable = ['aset_id', 'jenis', 'keterangan'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
