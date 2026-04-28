<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibF extends Model
{
    protected $table = 'kib_fs';
    protected $fillable = ['aset_id', 'progress', 'nilai_kontrak', 'vendor'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
