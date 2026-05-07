<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetLampiran extends Model
{
    protected $fillable = ['aset_id', 'nama_file', 'path', 'keterangan'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
