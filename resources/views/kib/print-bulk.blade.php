<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Code Bulk - KIB {{ $type }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 10px;
            max-width: 210mm;
            margin: auto;
            background-color: white;
        }
        .qr-card {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            page-break-inside: avoid;
        }
        .qr-image {
            margin-bottom: 5px;
        }
        .qr-image svg {
            width: 120px !important;
            height: 120px !important;
        }
        .asset-name {
            font-weight: bold;
            font-size: 0.8rem;
            margin: 2px 0;
            text-transform: uppercase;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.2;
            height: 2.4em;
        }
        .asset-code {
            font-size: 0.7rem;
            font-family: monospace;
            color: #333;
        }
        .footer {
            margin-top: 5px;
            font-size: 0.5rem;
            border-top: 0.5px solid #eee;
            padding-top: 2px;
            width: 100%;
            color: #666;
        }
        
        .no-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn {
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            font-weight: bold;
        }
        .btn-primary { background: #0d6efd; color: white; }
        .btn-secondary { background: #6c757d; color: white; margin-left: 5px; }

        @media print {
            body { background-color: white; }
            .no-print { display: none; }
            .container { 
                padding: 0; 
                gap: 5mm;
                grid-template-columns: repeat(3, 1fr);
            }
            .qr-card {
                border: 0.2mm solid #000;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print">
        <button class="btn btn-primary" onclick="window.print()">Cetak</button>
        <button class="btn btn-secondary" onclick="window.close()">Tutup</button>
    </div>

    <div class="container">
        @foreach($asets as $aset)
            <div class="qr-card">
                <div class="qr-image">
                    @php
                        $qrText = "KODE: " . $aset->kode_aset . "\n" .
                                 "NAMA: " . $aset->nama_aset . "\n" .
                                 "TAHUN: " . $aset->tahun_perolehan . "\n" .
                                 "NILAI: Rp " . number_format($aset->nilai, 0, ',', '.');
                    @endphp
                    {!! QrCode::size(120)->generate($qrText) !!}
                </div>
                <div class="asset-name">{{ $aset->nama_aset }}</div>
                <div class="asset-code">{{ $aset->kode_aset }}</div>
                <div class="footer">
                    {{ \App\Models\Setting::get('app_name', 'SIMASET') }} - {{ \App\Models\Setting::get('instansi_nama', 'Muna Barat') }}
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
