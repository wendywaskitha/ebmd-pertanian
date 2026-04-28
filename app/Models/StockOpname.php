<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $fillable = ['aset_id', 'status', 'tanggal', 'keterangan'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
