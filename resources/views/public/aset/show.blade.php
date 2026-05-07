<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset - {{ $aset->nama_aset }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --accent: #1cc88a;
            --bg-gradient: linear-gradient(135deg, #f8f9fc 0%, #e2e8f0 100%);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            color: #2d3748;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }

        .hero-img {
            height: 300px;
            object-fit: cover;
            border-radius: 20px;
            width: 100%;
        }

        .badge-kib {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 50px;
        }

        .badge-kondisi {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 50px;
        }

        .data-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #718096;
            font-weight: 600;
        }

        .data-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a202c;
        }

        .attachment-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.5);
        }

        .attachment-item:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .footer-text {
            font-size: 0.85rem;
            color: #a0aec0;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="fw-800 text-dark mb-2">Sistem Informasi Aset</h1>
            <p class="text-muted">Informasi Detail Aset Publik</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Sidebar/Foto -->
            <div class="col-lg-4">
                <div class="glass-card p-3 mb-4">
                    @if($aset->foto)
                        <img src="{{ asset('storage/' . $aset->foto) }}" class="hero-img mb-3 shadow-sm" alt="{{ $aset->nama_aset }}">
                    @else
                        <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                            <i class="bi bi-image text-muted fs-1 mb-2"></i>
                            <span class="text-muted small">Tidak ada foto</span>
                        </div>
                    @endif
                    
                    <div class="text-center mt-3">
                        <span class="badge badge-kib text-white mb-2">KIB {{ $aset->kib_type }}</span>
                        <span class="badge badge-kondisi bg-{{ $aset->kondisi == 'Baik' ? 'success' : ($aset->kondisi == 'Kurang Baik' ? 'warning text-dark' : 'danger') }} ms-1">
                            Kondisi: {{ $aset->kondisi }}
                        </span>
                    </div>
                </div>

                <div class="glass-card p-3 text-center">
                    <div class="small text-muted mb-1">KODE ASET</div>
                    <div class="fs-4 fw-bold text-primary mb-0">{{ $aset->kode_aset }}</div>
                </div>
            </div>

            <!-- Main Info -->
            <div class="col-lg-7">
                <div class="glass-card p-4 h-100">
                    <h3 class="fw-600 text-dark mb-4 border-bottom pb-2">{{ $aset->nama_aset }}</h3>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="data-label">Lokasi</div>
                            <div class="data-value"><i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $aset->lokasi->nama_lokasi ?? '-' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="data-label">Pengguna/Penanggung Jawab</div>
                            <div class="data-value"><i class="bi bi-person-fill text-primary me-2"></i>{{ $aset->pengguna_aset ?? '-' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="data-label">Tahun Perolehan</div>
                            <div class="data-value"><i class="bi bi-calendar-event-fill text-warning me-2"></i>{{ $aset->tahun_perolehan }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="data-label">Nilai Aset</div>
                            <div class="data-value text-success fw-bold"><i class="bi bi-cash-stack me-2"></i>Rp {{ number_format($aset->nilai, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Atribut Khusus KIB -->
                    <h5 class="fw-600 text-dark mb-3 mt-4"><i class="bi bi-card-text me-2"></i>Spesifikasi Aset</h5>
                    <div class="p-3 rounded-4 bg-white bg-opacity-50 border mb-4">
                        <div class="row g-3">
                            @if($aset->kib_type == 'A' && $aset->kibA)
                                <div class="col-md-4"><div class="data-label">Luas</div><div class="data-value">{{ $aset->kibA->luas }} m2</div></div>
                                <div class="col-md-4"><div class="data-label">Status Tanah</div><div class="data-value">{{ $aset->kibA->status_tanah }}</div></div>
                                <div class="col-md-4"><div class="data-label">No. Sertifikat</div><div class="data-value">{{ $aset->kibA->nomor_sertifikat ?? '-' }}</div></div>
                            @elseif($aset->kib_type == 'B' && $aset->kibB)
                                <div class="col-md-4"><div class="data-label">Merk/Tipe</div><div class="data-value">{{ $aset->kibB->merk ?? '-' }} / {{ $aset->kibB->tipe ?? '-' }}</div></div>
                                <div class="col-md-4"><div class="data-label">No. Seri</div><div class="data-value">{{ $aset->kibB->nomor_seri ?? '-' }}</div></div>
                                <div class="col-md-4"><div class="data-label">No. Polisi</div><div class="data-value">{{ $aset->kibB->nomor_polisi ?? '-' }}</div></div>
                            @elseif($aset->kib_type == 'C' && $aset->kibC)
                                <div class="col-md-4"><div class="data-label">Luas Bangunan</div><div class="data-value">{{ $aset->kibC->luas_bangunan }} m2</div></div>
                                <div class="col-md-8"><div class="data-label">Alamat</div><div class="data-value">{{ $aset->kibC->alamat ?? '-' }}</div></div>
                            @elseif($aset->kib_type == 'D' && $aset->kibD)
                                <div class="col-md-6"><div class="data-label">Panjang</div><div class="data-value">{{ $aset->kibD->panjang }} m</div></div>
                                <div class="col-md-6"><div class="data-label">Kondisi Khusus</div><div class="data-value">{{ $aset->kibD->kondisi_kib_d ?? '-' }}</div></div>
                            @elseif($aset->kib_type == 'E' && $aset->kibE)
                                <div class="col-md-6"><div class="data-label">Jenis</div><div class="data-value">{{ $aset->kibE->jenis }}</div></div>
                                <div class="col-md-6"><div class="data-label">Keterangan</div><div class="data-value">{{ $aset->kibE->keterangan ?? '-' }}</div></div>
                            @elseif($aset->kib_type == 'F' && $aset->kibF)
                                <div class="col-md-4"><div class="data-label">Progress</div><div class="data-value">{{ $aset->kibF->progress }}%</div></div>
                                <div class="col-md-4"><div class="data-label">Nilai Kontrak</div><div class="data-value text-success">Rp {{ number_format($aset->kibF->nilai_kontrak, 0, ',', '.') }}</div></div>
                                <div class="col-md-4"><div class="data-label">Vendor</div><div class="data-value">{{ $aset->kibF->vendor ?? '-' }}</div></div>
                            @endif
                        </div>
                    </div>

                    <!-- Lampiran Dokumen -->
                    <h5 class="fw-600 text-dark mb-3 mt-4"><i class="bi bi-paperclip me-2"></i>Lampiran Dokumen</h5>
                    @if($aset->lampirans->count() > 0)
                        <div class="row g-2">
                            @foreach($aset->lampirans as $lampiran)
                                <div class="col-md-6">
                                    <div class="attachment-item p-3 border d-flex align-items-center justify-content-between">
                                        <div class="min-w-0 flex-grow-1 me-2">
                                            <div class="text-truncate fw-bold text-dark small">{{ $lampiran->nama_file }}</div>
                                            <span class="badge bg-secondary py-1 mt-1">{{ $lampiran->keterangan ?? 'Lampiran' }}</span>
                                        </div>
                                        <a href="{{ Storage::url($lampiran->path) }}" target="_blank" class="btn btn-sm btn-primary rounded-circle" title="Unduh">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted bg-white bg-opacity-25 rounded-4 border">
                            <i class="bi bi-paperclip fs-4 d-block mb-1"></i>
                            <small>Tidak ada dokumen lampiran publik.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="text-center mt-5 footer-text">
            &copy; {{ date('Y') }} Simaset. Semua Hak Dilindungi.
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
