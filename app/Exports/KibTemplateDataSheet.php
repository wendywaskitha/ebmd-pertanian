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
                break;
            case 'B':
                $headings[] = 'Merk';
                $headings[] = 'Tipe';
                $headings[] = 'Nomor Seri';
                $headings[] = 'Nomor Polisi';
                $headings[] = 'Tahun Pembelian';
                break;
            case 'C':
                $headings[] = 'Luas Bangunan (m2)';
                $headings[] = 'Alamat';
                break;
            case 'D':
                $headings[] = 'Panjang (m)';
                $headings[] = 'Kondisi KIB D';
                break;
            case 'E':
                $headings[] = 'Jenis';
                $headings[] = 'Keterangan';
                break;
            case 'F':
                $headings[] = 'Progress (%)';
                $headings[] = 'Nilai Kontrak';
                $headings[] = 'Vendor';
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
