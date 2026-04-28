<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aset - {{ \App\Models\Setting::get('instansi_nama') }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; position: relative; }
        .header .logo { position: absolute; left: 0; top: 0; width: 60px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 14px; }
        .header h3 { margin: 5px 0 0 0; font-size: 12px; }
        .header p { margin: 2px 0; font-size: 9px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 4px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; text-transform: uppercase; font-size: 9px; }
        
        .footer { margin-top: 15px; }
        .signature-box { float: right; width: 250px; text-align: center; margin-top: 20px; }
        .signature-box p { margin: 0; }
        .signature-space { height: 60px; }
        
        .condition-baik { color: green; font-weight: bold; }
        .condition-kurang { color: orange; font-weight: bold; }
        .condition-rusak { color: red; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo = \App\Models\Setting::get('app_logo'))
            <img src="{{ public_path('storage/' . $logo) }}" class="logo">
        @endif
        <h2>PEMERINTAH KABUPATEN MUNA BARAT</h2>
        <h2>{{ \App\Models\Setting::get('instansi_nama', 'PEMERINTAH KABUPATEN MUNA BARAT') }}</h2>
        <p>{{ \App\Models\Setting::get('instansi_alamat', 'Alamat belum diatur di pengaturan') }}</p>
        <p>Email: {{ \App\Models\Setting::get('instansi_email', '-') }} | Telp: {{ \App\Models\Setting::get('instansi_telp', '-') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Aset</th>
                <th>Nama Aset</th>
                <th>KIB</th>
                <th>Lokasi</th>
                <th>Tahun</th>
                
                @if($type == 'A')
                    <th>Luas</th>
                    <th>Status Tanah</th>
                @elseif($type == 'B')
                    <th>Merk/Tipe</th>
                    <th>No. Seri/Polisi</th>
                @elseif($type == 'C')
                    <th>Luas Bangunan</th>
                    <th>Alamat</th>
                @elseif($type == 'D')
                    <th>Panjang</th>
                @elseif($type == 'E')
                    <th>Jenis</th>
                @elseif($type == 'F')
                    <th>Progress</th>
                @endif

                <th>Nilai (Rp)</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asets as $index => $aset)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $aset->kode_aset }}</td>
                    <td>{{ $aset->nama_aset }}</td>
                    <td class="text-center">{{ $aset->kib_type }}</td>
                    <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                    <td class="text-center">{{ $aset->tahun_perolehan }}</td>
                    
                    @if($type == 'A')
                        <td class="text-center">{{ $aset->kibA->luas ?? '-' }} m2</td>
                        <td>{{ $aset->kibA->status_tanah ?? '-' }}</td>
                    @elseif($type == 'B')
                        <td>{{ $aset->kibB->merk ?? '-' }} / {{ $aset->kibB->tipe ?? '-' }}</td>
                        <td>{{ $aset->kibB->nomor_seri ?? '-' }} / {{ $aset->kibB->nomor_polisi ?? '-' }}</td>
                    @elseif($type == 'C')
                        <td class="text-center">{{ $aset->kibC->luas_bangunan ?? '-' }} m2</td>
                        <td>{{ $aset->kibC->alamat ?? '-' }}</td>
                    @elseif($type == 'D')
                        <td class="text-center">{{ $aset->kibD->panjang ?? '-' }} m</td>
                    @elseif($type == 'E')
                        <td>{{ $aset->kibE->jenis ?? '-' }}</td>
                    @elseif($type == 'F')
                        <td class="text-center">{{ $aset->kibF->progress ?? 0 }}%</td>
                    @endif

                    <td class="text-right">{{ number_format($aset->nilai, 0, ',', '.') }}</td>
                    <td class="text-center">
                        {{ $aset->kondisi }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer clearfix">
        <div class="signature-box">
            <p>{{ \App\Models\Setting::get('instansi_alamat_singkat', 'Muna Barat') }}, {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <p class="fw-bold">{{ \App\Models\Setting::get('kepala_jabatan', 'Kepala Instansi') }}</p>
            <div class="signature-space"></div>
            <p><strong><u>{{ \App\Models\Setting::get('kepala_nama', '..........................................') }}</u></strong></p>
            <p>{{ \App\Models\Setting::get('kepala_pangkat', 'Pangkat / Golongan') }}</p>
            <p>NIP. {{ \App\Models\Setting::get('kepala_nip', '..........................................') }}</p>
        </div>
    </div>
</body>
</html>
