<?php

namespace Database\Seeders;

use App\Models\Aset;
use App\Models\Lokasi;
use App\Models\KibA;
use App\Models\KibB;
use App\Models\KibC;
use App\Models\KibD;
use App\Models\KibE;
use App\Models\KibF;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KibSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Lokasi if not exists
        $lokasiNames = ['Gudang Pusat', 'Kantor Utama', 'Lab Pertanian', 'Lahan Percobaan', 'Ruang Arsip'];
        $lokasiIds = [];
        
        foreach ($lokasiNames as $name) {
            $lokasi = Lokasi::firstOrCreate(['nama_lokasi' => $name], [
                'kecamatan_id' => '74.13.01', // Example ID
                'desa_id' => '74.13.01.2001', // Example ID
            ]);
            $lokasiIds[] = $lokasi->id;
        }

        $kondisiOptions = ['Baik', 'Kurang Baik', 'Rusak Berat'];
        $penggunaOptions = ['Budi Utomo', 'Siti Rahma', 'Agus Salim', 'Dewi Sartika', 'Ahmad Dahlan', 'H.R. Rasuna Said'];

        // 2. Seed each KIB type (A to F)
        foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $type) {
            for ($i = 1; $i <= 15; $i++) {
                $aset = Aset::create([
                    'kode_aset' => "KIB-{$type}-" . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'nama_aset' => $this->getAsetName($type, $i),
                    'kib_type' => $type,
                    'lokasi_id' => $lokasiIds[array_rand($lokasiIds)],
                    'tahun_perolehan' => rand(2015, 2024),
                    'nilai' => rand(1000000, 500000000),
                    'kondisi' => $kondisiOptions[array_rand($kondisiOptions)],
                    'pengguna_aset' => $penggunaOptions[array_rand($penggunaOptions)],
                ]);

                $this->createKibDetail($aset, $type);
            }
        }
    }

    private function getAsetName($type, $index)
    {
        $names = [
            'A' => ['Tanah Perkantoran', 'Lahan Sawah', 'Tanah Perkebunan', 'Tanah Kosong', 'Lahan Fasos'],
            'B' => ['Laptop ASUS', 'Printer Epson', 'Traktor Mini', 'Motor Operasional', 'AC Split'],
            'C' => ['Gedung Kantor', 'Gudang Pupuk', 'Rumah Dinas', 'Aula Pertemuan', 'Pos Jaga'],
            'D' => ['Jalan Desa', 'Saluran Irigasi', 'Jaringan Listrik', 'Pipa Air Bersih', 'Jembatan Kayu'],
            'E' => ['Buku Perpustakaan', 'Alat Musik', 'Koleksi Budaya', 'Hewan Ternak', 'Tanaman Hias'],
            'F' => ['Pembangunan Gedung B', 'Renovasi Jalan', 'Konstruksi Irigasi', 'Proyek Jembatan', 'Pembangunan Pagar'],
        ];

        return $names[$type][array_rand($names[$type])] . ' ' . $index;
    }

    private function createKibDetail($aset, $type)
    {
        switch ($type) {
            case 'A':
                KibA::create([
                    'aset_id' => $aset->id,
                    'luas' => rand(100, 5000),
                    'status_tanah' => 'Hak Milik',
                    'nomor_sertifikat' => 'CERT-' . Str::random(10),
                    'tanggal_sertifikat' => now()->subDays(rand(1, 3650))->format('Y-m-d'),
                    'penggunaan' => 'Lahan Pertanian',
                    'keterangan' => 'Seeder data'
                ]);
                break;
            case 'B':
                KibB::create([
                    'aset_id' => $aset->id,
                    'merk' => 'Brand ' . Str::random(5),
                    'tipe' => 'Type ' . Str::random(5),
                    'ukuran' => rand(10, 100) . ' cm',
                    'nomor_seri' => 'SN-' . Str::random(10),
                    'nomor_rangka' => 'RNK-' . Str::random(10),
                    'nomor_polisi' => 'DT ' . rand(1000, 9999) . ' ' . strtoupper(Str::random(2)),
                    'nomor_bpkb' => 'BPKB-' . Str::random(10),
                    'tahun_pembelian' => rand(2015, 2024),
                    'asal_usul' => 'APBD',
                    'ruang_penyimpanan' => 'Gudang Utama'
                ]);
                break;
            case 'C':
                KibC::create([
                    'aset_id' => $aset->id,
                    'luas_bangunan' => rand(50, 1000),
                    'bertingkat' => rand(0, 1) ? 'Ya' : 'Tidak',
                    'tanggal_kontrak' => now()->subDays(rand(1, 1000))->format('Y-m-d'),
                    'nomor_kontrak' => 'KONT-' . Str::random(8),
                    'alamat' => 'Jl. ' . Str::random(10) . ' No. ' . rand(1, 100),
                    'status_tanah' => 'Milik Sendiri',
                    'kode_tanah' => 'KT-' . rand(100, 999),
                    'asal_usul' => 'APBD'
                ]);
                break;
            case 'D':
                KibD::create([
                    'aset_id' => $aset->id,
                    'konstruksi' => 'Aspal',
                    'panjang' => rand(10, 1000),
                    'luas' => rand(100, 5000),
                    'tanggal_kontrak' => now()->subDays(rand(1, 1000))->format('Y-m-d'),
                    'nomor_kontrak' => 'KONT-D-' . Str::random(8),
                    'status_tanah' => 'Tanah Milik Pemda',
                    'asal_usul' => 'APBD'
                ]);
                break;
            case 'E':
                KibE::create([
                    'aset_id' => $aset->id,
                    'jenis' => 'Koleksi ' . Str::random(5),
                    'keterangan' => 'Keterangan seeder untuk aset E'
                ]);
                break;
            case 'F':
                KibF::create([
                    'aset_id' => $aset->id,
                    'bertingkat' => rand(0, 1) ? 'Ya' : 'Tidak',
                    'tanggal_kontrak' => now()->subDays(rand(1, 500))->format('Y-m-d'),
                    'nilai_kontrak' => $aset->nilai * 1.2,
                    'status_tanah' => 'Tanah Milik Negara',
                    'asal_usul' => 'APBN',
                    'sisa_kontrak' => $aset->nilai * 0.2
                ]);
                break;
        }
    }
}
