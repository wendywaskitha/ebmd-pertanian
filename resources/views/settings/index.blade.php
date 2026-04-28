<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Aplikasi</h1>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <!-- Branding & Assets -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Branding & Visual</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold small">Nama Aplikasi</label>
                            <div class="col-sm-8">
                                <input type="text" name="app_name" class="form-control form-control-sm" value="{{ $settings['app_name'] }}">
                            </div>
                        </div>

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold small">Logo Aplikasi</label>
                            <div class="col-sm-8">
                                @if($settings['app_logo'])
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['app_logo']) }}" class="img-thumbnail" style="height: 60px;">
                                    </div>
                                @endif
                                <input type="file" name="app_logo" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold small">Favicon</label>
                            <div class="col-sm-8">
                                @if($settings['app_favicon'])
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['app_favicon']) }}" class="img-thumbnail" style="height: 32px; width: 32px;">
                                    </div>
                                @endif
                                <input type="file" name="app_favicon" class="form-control form-control-sm" accept="image/x-icon,image/png">
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold small">Teks Footer</label>
                            <div class="col-sm-8">
                                <input type="text" name="footer_text" class="form-control form-control-sm" value="{{ $settings['footer_text'] }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instansi Detail -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Instansi</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold small">Nama Instansi</label>
                            <div class="col-sm-8">
                                <input type="text" name="instansi_nama" class="form-control form-control-sm" value="{{ $settings['instansi_nama'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold small">Alamat Instansi</label>
                            <div class="col-sm-8">
                                <textarea name="instansi_alamat" class="form-control form-control-sm" rows="3">{{ $settings['instansi_alamat'] }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold small">Email Instansi</label>
                            <div class="col-sm-8">
                                <input type="email" name="instansi_email" class="form-control form-control-sm" value="{{ $settings['instansi_email'] }}">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label fw-bold small">Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" name="instansi_telp" class="form-control form-control-sm" value="{{ $settings['instansi_telp'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <!-- Penandatangan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pejabat Penandatangan</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Kepala / Pejabat</label>
                            <input type="text" name="kepala_nama" class="form-control form-control-sm" value="{{ $settings['kepala_nama'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Pangkat / Golongan</label>
                            <input type="text" name="kepala_pangkat" class="form-control form-control-sm" value="{{ $settings['kepala_pangkat'] }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold small">NIP</label>
                            <input type="text" name="kepala_nip" class="form-control form-control-sm" value="{{ $settings['kepala_nip'] }}">
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body text-center py-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="bi bi-save me-2"></i>Simpan Semua Perubahan
                        </button>
                        <p class="text-muted small mt-3 mb-0 italic">Perubahan akan langsung diterapkan pada layout aplikasi dan laporan PDF.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-bootstrap-layout>
