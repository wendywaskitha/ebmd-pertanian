<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::get('app_name', 'SIMASET') }} - Landing Page</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3436;
            overflow-x: hidden;
        }
        .navbar {
            padding: 1.5rem 0;
            transition: all 0.3s;
        }
        .navbar.scrolled {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .hero-section {
            padding: 160px 0 100px;
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(248,249,250,0.8)), url("{{ asset('welcome_hero_bg.png') }}");
            background-size: cover;
            background-position: center;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }
        .feature-card {
            border: none;
            border-radius: 1.5rem;
            padding: 2.5rem;
            transition: all 0.3s;
            background: white;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        .btn-primary {
            padding: 0.8rem 2rem;
            border-radius: 0.8rem;
            font-weight: 600;
        }
        .footer {
            background: #1e272e;
            color: white;
            padding: 4rem 0 2rem;
        }
        .logo-img {
            height: 40px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-primary fs-4" href="#">
                @if($logo = \App\Models\Setting::get('app_logo'))
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="logo-img">
                @else
                    <i class="bi bi-box-seam me-2"></i>
                @endif
                {{ \App\Models\Setting::get('app_name', 'SIMASET') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-primary shadow-sm ms-lg-3" href="{{ url('/dashboard') }}">Ke Dashboard <i class="bi bi-arrow-right ms-1"></i></a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3 fw-bold">v1.0 Ready to Use</span>
                    <h1 class="display-3 fw-bold mb-4">Kelola Aset Instansi dengan <span class="text-primary">Mudah & Akurat</span></h1>
                    <p class="lead text-muted mb-5">Sistem Informasi Manajemen Aset Terintegrasi untuk efisiensi inventarisasi, pelacakan, dan pelaporan aset negara.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow">Mulai Sekarang <i class="bi bi-rocket-takeoff ms-2"></i></a>
                        <a href="#features" class="btn btn-outline-dark btn-lg">Pelajari Fitur</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="position-relative">
                        <img src="{{ asset('welcome_hero_bg.png') }}" class="img-fluid rounded-4 shadow-lg" alt="Dashboard Preview">
                        <div class="position-absolute top-100 start-0 translate-middle-y bg-white p-4 shadow rounded-4 ms-5 mt-n5 border d-inline-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                                <i class="bi bi-qr-code-scan fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs-5">QR Code Ready</div>
                                <div class="text-muted small">Inventarisasi instan via HP</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5">Solusi Manajemen Aset</h2>
                <p class="text-muted">Fitur lengkap untuk mendukung pengelolaan aset instansi pemerintah.</p>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="feature-card shadow-sm border border-light">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-database-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Manajemen KIB</h4>
                        <p class="text-muted">Pencatatan aset lengkap mulai dari KIB A hingga KIB F sesuai standar akuntansi pemerintah.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card shadow-sm border border-light">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-qr-code"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Labeling QR Code</h4>
                        <p class="text-muted">Cetak label QR Code untuk setiap aset untuk mempermudah identifikasi dan pelacakan fisik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card shadow-sm border border-light">
                        <div class="icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Laporan Otomatis</h4>
                        <p class="text-muted">Hasilkan laporan inventaris, mutasi, dan kondisi aset dalam format PDF atau Excel secara instan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-4">{{ \App\Models\Setting::get('app_name', 'SIMASET') }}</h4>
                    <p class="opacity-75">{{ \App\Models\Setting::get('instansi_nama', 'Sistem Informasi Manajemen Aset') }}</p>
                    <p class="small opacity-50 mb-0">{{ \App\Models\Setting::get('footer_text', '© 2026 SIMASET. All rights reserved.') }}</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4">Kontak Kami</h5>
                    <p class="opacity-75 small mb-2"><i class="bi bi-geo-alt me-2"></i> {{ \App\Models\Setting::get('instansi_alamat', '-') }}</p>
                    <p class="opacity-75 small mb-2"><i class="bi bi-envelope me-2"></i> {{ \App\Models\Setting::get('instansi_email', '-') }}</p>
                    <p class="opacity-75 small mb-0"><i class="bi bi-telephone me-2"></i> {{ \App\Models\Setting::get('instansi_tlp', '-') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <h5 class="fw-bold mb-4">Akses Cepat</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('login') }}" class="text-white text-decoration-none opacity-75 small">Masuk Petugas</a>
                        <a href="#features" class="text-white text-decoration-none opacity-75 small">Panduan Pengguna</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
