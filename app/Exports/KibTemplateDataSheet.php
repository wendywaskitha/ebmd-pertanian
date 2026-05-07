<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KibTemplateDataSheet implements WithHeadings, WithTitle, WithStyles
{
    protected $kibType;

    public function __construct(string $kibType)
    {
        $this->kibType = $kibType;
    }

    public function title(): string
    {
        return 'Data KIB ' . $this->kibType;
    }

    public function headings(): array
    {
        $headings = [
            'Kode Aset',
            'Nama Aset',
            'Nama Lokasi',
            'Tahun Perolehan',
            'Nilai',
            'Kondisi',
            'Pengguna Aset'
        ];

        switch ($this->kibType) {
            case 'A':
                $headings[] = 'Luas (m2)';
                $headings[] = 'Status Tanah';
                $headings[] = 'Nomor Sertifikat';
                $headings[] = 'Tanggal Sertifikat';
                $headings[] = 'Penggunaan';
                $headings[] = 'Keterangan';
                break;
            case 'B':
                $headings[] = 'Merk';
                $headings[] = 'Tipe';
                $headings[] = 'Ukuran';
                $headings[] = 'Nomor Seri';
                $headings[] = 'Nomor Rangka';
                $headings[] = 'Nomor Polisi';
                $headings[] = 'Nomor BPKB';
                $headings[] = 'Tahun Pembelian';
                $headings[] = 'Asal Usul';
                $headings[] = 'Ruang Penyimpanan';
                break;
            case 'C':
                $headings[] = 'Luas Bangunan (m2)';
                $headings[] = 'Bertingkat';
                $headings[] = 'Tanggal Kontrak';
                $headings[] = 'Nomor Kontrak';
                $headings[] = 'Alamat';
                $headings[] = 'Status Tanah';
                $headings[] = 'Kode Tanah';
                $headings[] = 'Asal Usul';
                break;
            case 'D':
                $headings[] = 'Konstruksi';
                $headings[] = 'Panjang (m)';
                $headings[] = 'Luas (m2)';
                $headings[] = 'Tanggal Kontrak';
                $headings[] = 'Nomor Kontrak';
                $headings[] = 'Status Tanah';
                $headings[] = 'Asal Usul';
                break;
            case 'E':
                $headings[] = 'Jenis';
                $headings[] = 'Keterangan';
                break;
            case 'F':
                $headings[] = 'Bertingkat';
                $headings[] = 'Tanggal Kontrak';
                $headings[] = 'Nilai Kontrak';
                $headings[] = 'Status Tanah';
                $headings[] = 'Asal Usul';
                $headings[] = 'Sisa Kontrak';
                break;
        }

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4E73DF']
                ]
            ],
        ];
    }
}
