<?php

namespace App\Imports;

use App\Models\Aset;
use App\Models\Lokasi;
use App\Models\KibA;
use App\Models\KibB;
use App\Models\KibC;
use App\Models\KibD;
use App\Models\KibE;
use App\Models\KibF;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KibImport implements ToCollection, WithHeadingRow
{
    protected $kibType;

    public function __construct(string $kibType)
    {
        $this->kibType = strtoupper($kibType);
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty($row['kode_aset']) && empty($row['nama_aset'])) {
                    continue;
                }

                // 1. Strict Location Lookup
                $namaLokasi = $row['nama_lokasi'] ?? null;
                if (!$namaLokasi) {
                    throw ValidationException::withMessages([
                        'import' => "Baris " . ($index + 2) . ": Nama Lokasi wajib diisi."
                    ]);
                }

                $lokasi = Lokasi::where('nama_lokasi', $namaLokasi)->first();
                if (!$lokasi) {
                    throw ValidationException::withMessages([
                        'import' => "Baris " . ($index + 2) . ": Lokasi '" . $namaLokasi . "' tidak ditemukan di database. Pastikan sama persis."
                    ]);
                }

                // Check condition valid values
                $kondisi = $row['kondisi'] ?? 'Baik';
                $validKondisi = ['Baik', 'Kurang Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'];
                if (!in_array($kondisi, $validKondisi)) {
                    throw ValidationException::withMessages([
                        'import' => "Baris " . ($index + 2) . ": Kondisi '" . $kondisi . "' tidak valid. Pilihan: Baik, Kurang Baik, Rusak Ringan, Rusak Berat, Hilang."
                    ]);
                }

                // 2. Create Aset
                $aset = Aset::create([
                    'kode_aset' => $row['kode_aset'],
                    'nama_aset' => $row['nama_aset'],
                    'kib_type' => $this->kibType,
                    'lokasi_id' => $lokasi->id,
                    'tahun_perolehan' => $row['tahun_perolehan'],
                    'nilai' => $row['nilai'],
                    'kondisi' => $kondisi,
                    'pengguna_aset' => $row['pengguna_aset'] ?? null,
                ]);

                // 3. Create KIB Specific Data
                switch ($this->kibType) {
                    case 'A':
                        KibA::create([
                            'aset_id' => $aset->id,
                            'luas' => $row['luas_m2'] ?? $row['luas'] ?? 0,
                            'status_tanah' => $row['status_tanah'] ?? 'Hak Milik',
                            'nomor_sertifikat' => $row['nomor_sertifikat'] ?? null,
                        ]);
                        break;
                    case 'B':
                        KibB::create([
                            'aset_id' => $aset->id,
                            'merk' => $row['merk'] ?? null,
                            'tipe' => $row['tipe'] ?? null,
                            'nomor_seri' => $row['nomor_seri'] ?? null,
                            'nomor_polisi' => $row['nomor_polisi'] ?? null,
                            'tahun_pembelian' => $row['tahun_pembelian'] ?? null,
                        ]);
                        break;
                    case 'C':
                        KibC::create([
                            'aset_id' => $aset->id,
                            'luas_bangunan' => $row['luas_bangunan_m2'] ?? $row['luas_bangunan'] ?? 0,
                            'alamat' => $row['alamat'] ?? null,
                        ]);
                        break;
                    case 'D':
                        KibD::create([
                            'aset_id' => $aset->id,
                            'panjang' => $row['panjang_m'] ?? $row['panjang'] ?? 0,
                            'kondisi_kib_d' => $row['kondisi_kib_d'] ?? null,
                        ]);
                        break;
                    case 'E':
                        KibE::create([
                            'aset_id' => $aset->id,
                            'jenis' => $row['jenis'] ?? 'Lainnya',
                            'keterangan' => $row['keterangan'] ?? null,
                        ]);
                        break;
                    case 'F':
                        KibF::create([
                            'aset_id' => $aset->id,
                            'progress' => $row['progress'] ?? $row['progress_percent'] ?? 0,
                            'nilai_kontrak' => $row['nilai_kontrak'] ?? 0,
                            'vendor' => $row['vendor'] ?? null,
                        ]);
                        break;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
