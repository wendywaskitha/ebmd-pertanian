<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ \App\Models\Setting::get('app_name', 'SIMASET') }}</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            overflow: hidden;
        }
        .login-wrapper {
            height: 100vh;
        }
        .login-sidebar {
            background-image: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.4)), url("{{ asset('login_sidebar_bg.png') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-form-container {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: white;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            border-color: #0d6efd;
            background-color: white;
        }
        .btn-primary {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
        .logo-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 1rem;
            border-radius: 1rem;
            display: inline-block;
            margin-bottom: 2rem;
        }
        @media (max-width: 991.98px) {
            .login-sidebar {
                display: none;
            }
            .login-form-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 login-wrapper">
        <!-- Left Column: Sidebar -->
        <div class="col-lg-6 login-sidebar d-none d-lg-flex">
            <div class="logo-box">
                @if($logo = \App\Models\Setting::get('app_logo'))
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" style="height: 60px;">
                @else
                    <i class="bi bi-box-seam text-white fs-1"></i>
                @endif
            </div>
            <h1 class="display-4 fw-bold mb-3">{{ \App\Models\Setting::get('app_name', 'SIMASET') }}</h1>
            <p class="fs-5 opacity-75 mb-5">Sistem Informasi Manajemen Aset Terintegrasi - {{ \App\Models\Setting::get('instansi_nama', 'Kabupaten Muna Barat') }}</p>
            
            <div class="mt-auto">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="bi bi-shield-check text-white"></i>
                    </div>
                    <span>Keamanan Data Terjamin</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Login Form -->
        <div class="col-lg-6 login-form-container">
            <div class="mx-auto w-100" style="max-width: 420px;">
                <div class="mb-5 d-lg-none">
                    <h2 class="fw-bold text-primary">{{ \App\Models\Setting::get('app_name', 'SIMASET') }}</h2>
                </div>
                
                <h2 class="fw-bold mb-2">Selamat Datang</h2>
                <p class="text-muted mb-4">Silakan masuk untuk mengelola aset instansi Anda.</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 small">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-muted">Alamat Email</label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input id="email" type="email" name="email" class="form-control ps-5 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                        </div>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold text-muted">Kata Sandi</label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="password" type="password" name="password" class="form-control ps-5 @error('password') is-invalid @enderror" required placeholder="Masukkan password">
                        </div>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4 form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label small text-muted">Ingat perangkat ini</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Masuk Ke Sistem <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-5 text-center">
                    <p class="small text-muted mb-0">{{ \App\Models\Setting::get('footer_text', '© 2026 Simaset Muna Barat') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
