<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aset - {{ \App\Models\Setting::get('instansi_nama') }}</title>
    <style>
        body { font-family: sans-serif; font-size: 8.5px; color: #333; line-height: 1.2; }
        @page { margin: 1cm; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; position: relative; }
        .header .logo { position: absolute; left: 0; top: 0; width: 50px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 13px; }
        .header p { margin: 2px 0; font-size: 8px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 0.5px solid #000; padding: 4px 3px; word-wrap: break-word; overflow: hidden; }
        th { background-color: #f2f2f2; text-align: center; text-transform: uppercase; font-size: 8px; }
        
        /* Column Widths - No dibuat sekecil mungkin, Nama Aset dibuat fleksibel/lebar */
        .col-no { width: 20px !important; text-align: center; font-size: 7px; }
        .col-kode { width: auto; } 
        .col-nama { width: auto; } /* Kode & Nama Aset bagi rata sisa ruang */
        .col-kib { width: 35px; }
        .col-lokasi { width: 90px; }
        .col-pengguna { width: 80px; }
        .col-tahun { width: 40px; }
        .col-detail { width: 100px; }
        .col-nilai { width: 90px; }
        .col-kondisi { width: 60px; }
        
        .footer { margin-top: 20px; page-break-inside: avoid; }
        .signature-box { float: right; width: 200px; text-align: center; }
        .signature-space { height: 50px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo = \App\Models\Setting::get('app_logo'))
            <img src="{{ public_path('storage/' . $logo) }}" class="logo">
        @endif
        <h2>PEMERINTAH KABUPATEN MUNA BARAT</h2>
        <h2>{{ \App\Models\Setting::get('instansi_nama', 'DINAS PERTANIAN') }}</h2>
        <p>{{ \App\Models\Setting::get('instansi_alamat', 'Alamat belum diatur di pengaturan') }}</p>
        <p>Email: {{ \App\Models\Setting::get('instansi_email', '-') }} | Telp: {{ \App\Models\Setting::get('instansi_telp', '-') }}</p>
        <hr style="border: 1px solid #000; margin-top: 10px;">
        
        @php
            $kibName = match($type) {
                'A' => 'Tanah (KIB A)',
                'B' => 'Peralatan & Mesin (KIB B)',
                'C' => 'Gedung & Bangunan (KIB C)',
                'D' => 'Jalan, Irigasi & Jaringan (KIB D)',
                'E' => 'Aset Tetap Lainnya (KIB E)',
                'F' => 'Konstruksi Dalam Pengerjaan (KIB F)',
                default => 'Semua Kartu Inventaris Barang'
            };
        @endphp
        
        <h3 style="margin-top: 15px; text-transform: uppercase;">LAPORAN KARTU INVENTARIS BARANG - {{ $kibName }}</h3>
        <p style="font-weight: bold;">Periode : s/d {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-kode">Kode Aset</th>
                <th class="col-nama">Nama Aset</th>
                <th class="col-kib">KIB</th>
                <th class="col-lokasi">Lokasi</th>
                <th class="col-pengguna">Pengguna</th>
                <th class="col-tahun">Tahun</th>
                
                @if($type == 'A')
                    <th style="width: 50px;">Luas</th>
                    <th style="width: 60px;">Status</th>
                @elseif($type == 'B')
                    <th style="width: 55px;">Merk/Tipe</th>
                    <th style="width: 55px;">No. Seri/Polisi</th>
                @elseif($type == 'C')
                    <th style="width: 50px;">Luas Bang.</th>
                    <th style="width: 60px;">Alamat</th>
                @elseif($type == 'D')
                    <th class="col-detail">Panjang</th>
                @elseif($type == 'E')
                    <th class="col-detail">Jenis</th>
                @elseif($type == 'F')
                    <th class="col-detail">Progress</th>
                @endif

                <th class="col-nilai">Nilai (Rp)</th>
                <th class="col-kondisi">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $currentYear = null; 
                $subtotal = 0;
                $grandTotal = 0;
                
                // Calculate dynamic colspan for the label part of subtotal/total rows
                $baseCols = 7;
                $detailCols = 0;
                if (in_array($type, ['A', 'B', 'C'])) $detailCols = 2;
                elseif (in_array($type, ['D', 'E', 'F'])) $detailCols = 1;
                
                $labelColSpan = $baseCols + $detailCols;
            @endphp
            @foreach($asets as $index => $aset)
                @if($currentYear !== null && $currentYear !== $aset->tahun_perolehan)
                    <tr style="background-color: #f2f2f2;" class="fw-bold">
                        <td colspan="{{ $labelColSpan }}" class="text-right">SUB TOTAL TAHUN {{ $currentYear }}</td>
                        <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    @php $subtotal = 0; @endphp
                @endif

                <tr>
                    <td class="text-center col-no">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $aset->kode_aset }}</td>
                    <td>{{ $aset->nama_aset }}</td>
                    <td class="text-center">{{ $aset->kib_type }}</td>
                    <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                    <td class="small">{{ $aset->pengguna_aset ?? '-' }}</td>
                    <td class="text-center">{{ $aset->tahun_perolehan }}</td>
                    
                    @if($type == 'A')
                        <td class="text-center">{{ $aset->kibA->luas ?? '-' }} m2</td>
                        <td class="small">{{ $aset->kibA->status_tanah ?? '-' }}</td>
                    @elseif($type == 'B')
                        <td class="small">{{ $aset->kibB->merk ?? '-' }} / {{ $aset->kibB->tipe ?? '-' }}</td>
                        <td class="small">{{ $aset->kibB->nomor_seri ?? '-' }} / {{ $aset->kibB->nomor_polisi ?? '-' }}</td>
                    @elseif($type == 'C')
                        <td class="text-center">{{ $aset->kibC->luas_bangunan ?? '-' }} m2</td>
                        <td class="small">{{ $aset->kibC->alamat ?? '-' }}</td>
                    @elseif($type == 'D')
                        <td class="text-center">{{ $aset->kibD->panjang ?? '-' }} m</td>
                    @elseif($type == 'E')
                        <td class="small">{{ $aset->kibE->jenis ?? '-' }}</td>
                    @elseif($type == 'F')
                        <td class="text-center">{{ $aset->kibF?->progress ?? 0 }}%</td>
                    @endif

                    <td class="text-right">{{ number_format($aset->nilai, 0, ',', '.') }}</td>
                    <td class="text-center small">{{ $aset->kondisi }}</td>
                </tr>
                @php 
                    $currentYear = $aset->tahun_perolehan;
                    $subtotal += $aset->nilai;
                    $grandTotal += $aset->nilai;
                @endphp
            @endforeach

            @if($currentYear !== null)
                <tr style="background-color: #f2f2f2;" class="fw-bold">
                    <td colspan="{{ $labelColSpan }}" class="text-right">SUB TOTAL TAHUN {{ $currentYear }}</td>
                    <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @endif

            <tr style="background-color: #ddd;" class="fw-bold">
                <td colspan="{{ $labelColSpan }}" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right">{{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer clearfix">
        <div class="signature-wrapper">
            {{-- Sebelah Kiri: Kepala Instansi --}}
            <div class="signature-box" style="float: left;">
                <p>Mengetahui,</p>
                <p class="fw-bold">{{ \App\Models\Setting::get('kepala_jabatan', 'Kepala Instansi') }}</p>
                <div class="signature-space"></div>
                <p><strong><u>{{ \App\Models\Setting::get('kepala_nama', '..........................................') }}</u></strong></p>
                <p>{{ \App\Models\Setting::get('kepala_pangkat', 'Pangkat / Golongan') }}</p>
                <p>NIP. {{ \App\Models\Setting::get('kepala_nip', '..........................................') }}</p>
            </div>

            {{-- Sebelah Kanan: Pengurus Barang --}}
            <div class="signature-box" style="float: right;">
                <p>{{ \App\Models\Setting::get('instansi_alamat_singkat', 'Muna Barat') }}, {{ date('d F Y') }}</p>
                <p>Yang Melaporkan,</p>
                <p class="fw-bold">{{ \App\Models\Setting::get('pengurus_jabatan', 'Pengurus Barang') }}</p>
                <div class="signature-space"></div>
                <p><strong><u>{{ \App\Models\Setting::get('pengurus_nama', '..........................................') }}</u></strong></p>
                <p>{{ \App\Models\Setting::get('pengurus_pangkat', 'Pangkat / Golongan') }}</p>
                <p>NIP. {{ \App\Models\Setting::get('pengurus_nip', '..........................................') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
