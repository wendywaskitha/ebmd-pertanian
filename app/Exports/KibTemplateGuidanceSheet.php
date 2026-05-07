<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class KibTemplateGuidanceSheet implements FromCollection, WithHeadings, WithTitle, WithColumnWidths, WithStyles
{
    protected $kibType;

    public function __construct(string $kibType)
    {
        $this->kibType = $kibType;
    }

    public function title(): string
    {
        return 'Panduan Pengisian';
    }

    public function headings(): array
    {
        return [
            'Nama Kolom',
            'Format / Ketentuan',
            'Keterangan'
        ];
    }

    public function collection()
    {
        $guidelines = [
            ['Kode Aset', 'Teks (Wajib)', 'Kode unik aset (Misal: AST-001)'],
            ['Nama Aset', 'Teks (Wajib)', 'Nama barang/aset'],
            ['Nama Lokasi', 'Teks (Wajib)', 'Harus sama persis dengan Nama Lokasi yang ada di menu Kelola Lokasi'],
            ['Tahun Perolehan', 'Angka (Wajib)', 'Format: YYYY (Misal: 2024)'],
            ['Nilai', 'Angka (Wajib)', 'Nilai aset dalam rupiah tanpa titik/koma (Misal: 15000000)'],
            ['Kondisi', 'Teks (Wajib)', 'Hanya boleh diisi: Baik, Kurang Baik, Rusak Ringan, Rusak Berat, Hilang'],
            ['Pengguna Aset', 'Teks (Opsional)', 'Nama pegawai/unit pengguna aset'],
        ];

        switch ($this->kibType) {
            case 'A':
                $guidelines[] = ['Luas (m2)', 'Angka (Wajib)', 'Luas tanah dalam meter persegi (Misal: 500)'];
                $guidelines[] = ['Status Tanah', 'Teks (Wajib)', 'Misal: Hak Milik, HGB, dll'];
                $guidelines[] = ['Nomor Sertifikat', 'Teks (Opsional)', 'Nomor dokumen sertifikat tanah'];
                break;
            case 'B':
                $guidelines[] = ['Merk', 'Teks (Opsional)', 'Merk barang (Misal: Toyota, Honda)'];
                $guidelines[] = ['Tipe', 'Teks (Opsional)', 'Tipe barang (Misal: Avanza, Vario)'];
                $guidelines[] = ['Nomor Seri', 'Teks (Opsional)', 'Nomor rangka/mesin/seri pabrik'];
                $guidelines[] = ['Nomor Polisi', 'Teks (Opsional)', 'Nomor polisi kendaraan (Misal: B 1234 ABC)'];
                $guidelines[] = ['Tahun Pembelian', 'Angka (Opsional)', 'Format: YYYY (Misal: 2023)'];
                break;
            case 'C':
                $guidelines[] = ['Luas Bangunan (m2)', 'Angka (Wajib)', 'Luas gedung dalam meter persegi (Misal: 250)'];
                $guidelines[] = ['Alamat', 'Teks (Wajib)', 'Alamat lengkap bangunan'];
                break;
            case 'D':
                $guidelines[] = ['Panjang (m)', 'Angka (Wajib)', 'Panjang jalan/jaringan dalam meter (Misal: 1200)'];
                $guidelines[] = ['Kondisi KIB D', 'Teks (Opsional)', 'Kondisi khusus (Misal: Aspal, Beton)'];
                break;
            case 'E':
                $guidelines[] = ['Jenis', 'Teks (Wajib)', 'Jenis aset (Misal: Buku, Alat Kesenian)'];
                $guidelines[] = ['Keterangan', 'Teks (Opsional)', 'Keterangan tambahan'];
                break;
            case 'F':
                $guidelines[] = ['Progress (%)', 'Angka (Wajib)', 'Persentase pengerjaan 0-100 (Misal: 75)'];
                $guidelines[] = ['Nilai Kontrak', 'Angka (Wajib)', 'Total kontrak dalam rupiah (Misal: 50000000)'];
                $guidelines[] = ['Vendor', 'Teks (Opsional)', 'Nama kontraktor/pihak ketiga'];
                break;
        }

        return new Collection($guidelines);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 55,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1CC88A']
                ]
            ],
        ];
    }
}
