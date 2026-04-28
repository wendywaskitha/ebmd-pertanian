<?php

namespace App\Exports;

use App\Models\Aset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AsetExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Aset::with('lokasi');
        if ($this->request->filled('kib_type')) $query->where('kib_type', $this->request->kib_type);
        if ($this->request->filled('lokasi_id')) $query->where('lokasi_id', $this->request->lokasi_id);
        if ($this->request->filled('kondisi')) $query->where('kondisi', $this->request->kondisi);
        return $query;
    }

    public function headings(): array
    {
        $headers = ['Kode Aset', 'Nama Aset', 'KIB', 'Lokasi', 'Tahun Perolehan', 'Nilai', 'Kondisi'];
        
        if ($this->request->filled('kib_type')) {
            switch ($this->request->kib_type) {
                case 'A': $headers = array_merge($headers, ['Luas', 'Status Tanah', 'No. Sertifikat']); break;
                case 'B': $headers = array_merge($headers, ['Merk', 'Tipe', 'No. Seri', 'No. Polisi', 'Tahun Beli']); break;
                case 'C': $headers = array_merge($headers, ['Luas Bangunan', 'Alamat']); break;
                case 'D': $headers = array_merge($headers, ['Panjang', 'Kondisi Khusus']); break;
                case 'E': $headers = array_merge($headers, ['Jenis', 'Keterangan']); break;
                case 'F': $headers = array_merge($headers, ['Progress (%)', 'Nilai Kontrak', 'Vendor']); break;
            }
        }
        
        return $headers;
    }

    public function map($aset): array
    {
        $data = [
            $aset->kode_aset,
            $aset->nama_aset,
            'KIB ' . $aset->kib_type,
            $aset->lokasi->nama_lokasi ?? '-',
            $aset->tahun_perolehan,
            $aset->nilai,
            $aset->kondisi,
        ];

        if ($this->request->filled('kib_type')) {
            switch ($this->request->kib_type) {
                case 'A':
                    $data = array_merge($data, [$aset->kibA->luas ?? '', $aset->kibA->status_tanah ?? '', $aset->kibA->nomor_sertifikat ?? '']);
                    break;
                case 'B':
                    $data = array_merge($data, [$aset->kibB->merk ?? '', $aset->kibB->tipe ?? '', $aset->kibB->nomor_seri ?? '', $aset->kibB->nomor_polisi ?? '', $aset->kibB->tahun_pembelian ?? '']);
                    break;
                case 'C':
                    $data = array_merge($data, [$aset->kibC->luas_bangunan ?? '', $aset->kibC->alamat ?? '']);
                    break;
                case 'D':
                    $data = array_merge($data, [$aset->kibD->panjang ?? '', $aset->kibD->kondisi_kib_d ?? '']);
                    break;
                case 'E':
                    $data = array_merge($data, [$aset->kibE->jenis ?? '', $aset->kibE->keterangan ?? '']);
                    break;
                case 'F':
                    $data = array_merge($data, [($aset->kibF->progress ?? 0) . '%', $aset->kibF->nilai_kontrak ?? '', $aset->kibF->vendor ?? '']);
                    break;
            }
        }

        return $data;
    }
}
