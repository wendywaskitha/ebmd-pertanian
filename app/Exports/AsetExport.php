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
        $headers = ['Kode Aset', 'Nama Aset', 'KIB', 'Lokasi', 'Pengguna', 'Tahun Perolehan', 'Nilai', 'Kondisi'];
        
        if ($this->request->filled('kib_type')) {
            switch ($this->request->kib_type) {
                case 'A': $headers = array_merge($headers, ['Luas', 'Status Tanah', 'No. Sertifikat', 'Tgl. Sertifikat', 'Penggunaan', 'Keterangan']); break;
                case 'B': $headers = array_merge($headers, ['Merk', 'Tipe', 'Ukuran', 'No. Seri', 'No. Rangka', 'No. Polisi', 'No. BPKB', 'Tahun Beli', 'Asal Usul', 'Ruang']); break;
                case 'C': $headers = array_merge($headers, ['Luas Bangunan', 'Bertingkat', 'Tgl. Kontrak', 'No. Kontrak', 'Alamat', 'Status Tanah', 'Kode Tanah', 'Asal Usul']); break;
                case 'D': $headers = array_merge($headers, ['Konstruksi', 'Panjang', 'Luas', 'Tgl. Kontrak', 'No. Kontrak', 'Status Tanah', 'Asal Usul']); break;
                case 'E': $headers = array_merge($headers, ['Jenis', 'Keterangan']); break;
                case 'F': $headers = array_merge($headers, ['Bertingkat', 'Tgl. Kontrak', 'Nilai Kontrak', 'Status Tanah', 'Asal Usul', 'Sisa Kontrak']); break;
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
            $aset->pengguna_aset ?? '-',
            $aset->tahun_perolehan,
            $aset->nilai,
            $aset->kondisi,
        ];

        if ($this->request->filled('kib_type')) {
            switch ($this->request->kib_type) {
                case 'A':
                    $data = array_merge($data, [
                        $aset->kibA->luas ?? '', 
                        $aset->kibA->status_tanah ?? '', 
                        $aset->kibA->nomor_sertifikat ?? '',
                        $aset->kibA->tanggal_sertifikat ?? '',
                        $aset->kibA->penggunaan ?? '',
                        $aset->kibA->keterangan ?? ''
                    ]);
                    break;
                case 'B':
                    $data = array_merge($data, [
                        $aset->kibB->merk ?? '', 
                        $aset->kibB->tipe ?? '', 
                        $aset->kibB->ukuran ?? '', 
                        $aset->kibB->nomor_seri ?? '', 
                        $aset->kibB->nomor_rangka ?? '', 
                        $aset->kibB->nomor_polisi ?? '', 
                        $aset->kibB->nomor_bpkb ?? '', 
                        $aset->kibB->tahun_pembelian ?? '',
                        $aset->kibB->asal_usul ?? '',
                        $aset->kibB->ruang_penyimpanan ?? ''
                    ]);
                    break;
                case 'C':
                    $data = array_merge($data, [
                        $aset->kibC->luas_bangunan ?? '', 
                        $aset->kibC->bertingkat ?? '', 
                        $aset->kibC->tanggal_kontrak ?? '', 
                        $aset->kibC->nomor_kontrak ?? '', 
                        $aset->kibC->alamat ?? '', 
                        $aset->kibC->status_tanah ?? '', 
                        $aset->kibC->kode_tanah ?? '', 
                        $aset->kibC->asal_usul ?? ''
                    ]);
                    break;
                case 'D':
                    $data = array_merge($data, [
                        $aset->kibD->konstruksi ?? '', 
                        $aset->kibD->panjang ?? '', 
                        $aset->kibD->luas ?? '', 
                        $aset->kibD->tanggal_kontrak ?? '', 
                        $aset->kibD->nomor_kontrak ?? '', 
                        $aset->kibD->status_tanah ?? '', 
                        $aset->kibD->asal_usul ?? ''
                    ]);
                    break;
                case 'E':
                    $data = array_merge($data, [$aset->kibE->jenis ?? '', $aset->kibE->keterangan ?? '']);
                    break;
                case 'F':
                    $data = array_merge($data, [
                        $aset->kibF->bertingkat ?? '', 
                        $aset->kibF->tanggal_kontrak ?? '', 
                        $aset->kibF->nilai_kontrak ?? '', 
                        $aset->kibF->status_tanah ?? '', 
                        $aset->kibF->asal_usul ?? '', 
                        $aset->kibF->sisa_kontrak ?? ''
                    ]);
                    break;
            }
        }

        return $data;
    }
}
