<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KibF extends Model
{
    protected $table = 'kib_fs';
    protected $fillable = ['aset_id', 'bertingkat', 'tanggal_kontrak', 'nilai_kontrak', 'status_tanah', 'asal_usul', 'sisa_kontrak'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
