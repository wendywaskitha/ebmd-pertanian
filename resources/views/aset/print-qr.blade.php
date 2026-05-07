<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code - {{ $aset->kode_aset }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: white;
        }
        .qr-card {
            border: 2px solid #000;
            padding: 20px;
            text-align: center;
            width: 300px;
        }
        .qr-image {
            margin-bottom: 10px;
        }
        .asset-name {
            font-weight: bold;
            font-size: 1.2rem;
            margin: 5px 0;
            text-transform: uppercase;
        }
        .asset-code {
            font-size: 1rem;
            letter-spacing: 2px;
        }
        .footer {
            margin-top: 10px;
            font-size: 0.7rem;
            border-top: 1px dashed #ccc;
            padding-top: 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                height: auto;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="qr-card">
        <div class="qr-image">
            {!! QrCode::size(200)->generate(route('public.aset.show', $aset->kode_aset)) !!}
        </div>
        <div class="asset-name">{{ $aset->nama_aset }}</div>
        <div class="asset-code">{{ $aset->kode_aset }}</div>
        <div class="footer">
            SIMASET - DINAS PERTANIAN MUNA BARAT
        </div>
        
        <div class="no-print" style="margin-top: 20px;">
            <button onclick="window.print()">Cetak Lagi</button>
            <button onclick="window.close()">Tutup</button>
        </div>
    </div>
</body>
</html>
