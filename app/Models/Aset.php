<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kib_type',
        'lokasi_id',
        'tahun_perolehan',
        'nilai',
        'kondisi',
        'qr_code',
        'latitude',
        'longitude',
        'foto',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function kibA() { return $this->hasOne(KibA::class, 'aset_id'); }
    public function kibB() { return $this->hasOne(KibB::class, 'aset_id'); }
    public function kibC() { return $this->hasOne(KibC::class, 'aset_id'); }
    public function kibD() { return $this->hasOne(KibD::class, 'aset_id'); }
    public function kibE() { return $this->hasOne(KibE::class, 'aset_id'); }
    public function kibF() { return $this->hasOne(KibF::class, 'aset_id'); }

    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class);
    }

    /**
     * Get the sub-table instance based on kib_type
     */
    public function getKibDetails()
    {
        switch ($this->kib_type) {
            case 'A': return $this->kibA;
            case 'B': return $this->kibB;
            case 'C': return $this->kibC;
            case 'D': return $this->kibD;
            case 'E': return $this->kibE;
            case 'F': return $this->kibF;
            default: return null;
        }
    }
}
