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
                $guidelines[] = ['Tanggal Sertifikat', 'Tanggal (Opsional)', 'Format: YYYY-MM-DD (Misal: 2024-05-07)'];
                $guidelines[] = ['Penggunaan', 'Teks (Opsional)', 'Misal: Perkantoran, Sekolah, dll'];
                $guidelines[] = ['Keterangan', 'Teks (Opsional)', 'Keterangan tambahan tanah'];
                break;
            case 'B':
                $guidelines[] = ['Merk', 'Teks (Opsional)', 'Merk barang (Misal: Toyota, Honda)'];
                $guidelines[] = ['Tipe', 'Teks (Opsional)', 'Tipe barang (Misal: Avanza, Vario)'];
                $guidelines[] = ['Ukuran', 'Teks (Opsional)', 'Ukuran barang (Misal: 150cc, 2x3m)'];
                $guidelines[] = ['Nomor Seri', 'Teks (Opsional)', 'Nomor seri pabrik'];
                $guidelines[] = ['Nomor Rangka', 'Teks (Opsional)', 'Nomor rangka kendaraan/mesin'];
                $guidelines[] = ['Nomor Polisi', 'Teks (Opsional)', 'Nomor polisi kendaraan (Misal: B 1234 ABC)'];
                $guidelines[] = ['Nomor BPKB', 'Teks (Opsional)', 'Nomor dokumen BPKB'];
                $guidelines[] = ['Tahun Pembelian', 'Angka (Opsional)', 'Format: YYYY (Misal: 2023)'];
                $guidelines[] = ['Asal Usul', 'Teks (Opsional)', 'Asal usul perolehan (Misal: Pembelian, Hibah)'];
                $guidelines[] = ['Ruang Penyimpanan', 'Teks (Opsional)', 'Lokasi spesifik penyimpanan (Misal: Ruang Kerja A)'];
                break;
            case 'C':
                $guidelines[] = ['Luas Bangunan (m2)', 'Angka (Wajib)', 'Luas gedung dalam meter persegi (Misal: 250)'];
                $guidelines[] = ['Bertingkat', 'Teks (Wajib)', 'Pilihan: Ya, Tidak'];
                $guidelines[] = ['Tanggal Kontrak', 'Tanggal (Opsional)', 'Format: YYYY-MM-DD (Misal: 2024-05-07)'];
                $guidelines[] = ['Nomor Kontrak', 'Teks (Opsional)', 'Nomor dokumen kontrak pembangunan'];
                $guidelines[] = ['Alamat', 'Teks (Wajib)', 'Alamat lengkap bangunan'];
                $guidelines[] = ['Status Tanah', 'Teks (Opsional)', 'Opsi: Milik Sendiri, Tanah Milik Pemda, Tanah Milik Negara'];
                $guidelines[] = ['Kode Tanah', 'Teks (Opsional)', 'Kode identitas tanah'];
                $guidelines[] = ['Asal Usul', 'Teks (Opsional)', 'Asal perolehan (Misal: APBD, Hibah)'];
                break;
            case 'D':
                $guidelines[] = ['Konstruksi', 'Teks (Opsional)', 'Jenis konstruksi (Misal: Aspal, Beton)'];
                $guidelines[] = ['Panjang (m)', 'Angka (Wajib)', 'Panjang jalan/jaringan dalam meter (Misal: 1200)'];
                $guidelines[] = ['Luas (m2)', 'Angka (Opsional)', 'Luas tanah/jaringan (Misal: 5000)'];
                $guidelines[] = ['Tanggal Kontrak', 'Tanggal (Opsional)', 'Format: YYYY-MM-DD'];
                $guidelines[] = ['Nomor Kontrak', 'Teks (Opsional)', 'Nomor dokumen kontrak'];
                $guidelines[] = ['Status Tanah', 'Teks (Opsional)', 'Opsi: Milik Sendiri, Tanah Milik Pemda, Tanah Milik Negara'];
                $guidelines[] = ['Asal Usul', 'Teks (Opsional)', 'Asal perolehan'];
                break;
            case 'E':
                $guidelines[] = ['Jenis', 'Teks (Wajib)', 'Jenis aset (Misal: Buku, Alat Kesenian)'];
                $guidelines[] = ['Keterangan', 'Teks (Opsional)', 'Keterangan tambahan'];
                break;
            case 'F':
                $guidelines[] = ['Bertingkat', 'Teks (Wajib)', 'Pilihan: Ya, Tidak'];
                $guidelines[] = ['Tanggal Kontrak', 'Tanggal (Opsional)', 'Format: YYYY-MM-DD'];
                $guidelines[] = ['Nilai Kontrak', 'Angka (Wajib)', 'Nilai total kontrak'];
                $guidelines[] = ['Status Tanah', 'Teks (Opsional)', 'Opsi: Milik Sendiri, Tanah Milik Pemda, Tanah Milik Negara'];
                $guidelines[] = ['Asal Usul', 'Teks (Opsional)', 'Asal perolehan'];
                $guidelines[] = ['Sisa Kontrak', 'Angka (Opsional)', 'Sisa nilai kontrak'];
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
