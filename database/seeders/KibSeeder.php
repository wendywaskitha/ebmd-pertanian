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
                    'nomor_sertifikat' => 'CERT-' . Str::random(10)
                ]);
                break;
            case 'B':
                KibB::create([
                    'aset_id' => $aset->id,
                    'merk' => 'Brand ' . Str::random(5),
                    'tipe' => 'Type ' . Str::random(5),
                    'nomor_seri' => 'SN-' . Str::random(10),
                    'nomor_polisi' => 'DT ' . rand(1000, 9999) . ' ' . strtoupper(Str::random(2)),
                    'tahun_pembelian' => rand(2015, 2024)
                ]);
                break;
            case 'C':
                KibC::create([
                    'aset_id' => $aset->id,
                    'luas_bangunan' => rand(50, 1000),
                    'alamat' => 'Jl. ' . Str::random(10) . ' No. ' . rand(1, 100)
                ]);
                break;
            case 'D':
                KibD::create([
                    'aset_id' => $aset->id,
                    'panjang' => rand(10, 1000),
                    'kondisi_kib_d' => 'Bagus'
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
                    'progress' => rand(0, 100),
                    'nilai_kontrak' => $aset->nilai * 1.2,
                    'vendor' => 'PT. ' . Str::random(8)
                ]);
                break;
        }
    }
}
