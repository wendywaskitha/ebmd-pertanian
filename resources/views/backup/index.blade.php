<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cadangkan & Pulihkan Database</h1>
    </div>

    <div class="row g-4">
        <!-- Backup Card -->
        <div class="col-md-6">
            <div class="card shadow h-100 border-start border-5 border-primary">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="bi bi-cloud-arrow-down-fill me-2"></i>Cadangkan Database (Backup)</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <p class="text-muted small">
                            Mengunduh seluruh isi basis data Anda (tabel, kueri pembuatan, dan record baris) ke dalam sebuah file berekstensi <code>.sql</code>.
                        </p>
                        <p class="text-muted small">
                            Lakukan pencadangan secara rutin sebelum memproses pembaruan sistem yang masif demi keamanan aset informasi Anda.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('backup.download') }}" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i> Unduh File SQL Cadangan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restore Card -->
        <div class="col-md-6">
            <div class="card shadow h-100 border-start border-5 border-danger">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-danger"><i class="bi bi-cloud-arrow-up-fill me-2"></i>Pulihkan Database (Restore)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        Mengembalikan kondisi basis data sistem ke keadaan sebelumnya berdasarkan file unggahan cadangan <code>.sql</code>.
                    </p>
                    <div class="alert alert-warning py-2 px-3 small border-0 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>PERHATIAN:</strong> Tindakan ini akan <strong>menghapus/menimpa</strong> seluruh data aktif Anda saat ini secara permanen!
                    </div>

                    <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="backup_file" class="form-label small fw-bold">Unggah File Backup (.sql)</label>
                            <input type="file" name="backup_file" id="backup_file" class="form-control form-control-sm @error('backup_file') is-invalid @enderror" accept=".sql" required>
                            @error('backup_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-2 mt-2" onclick="return confirm('Apakah Anda sangat yakin ingin MEMULIHKAN database? Seluruh data yang ada sekarang akan terhapus.')">
                            <i class="bi bi-file-earmark-arrow-up me-2"></i> Pulihkan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hapus Data per KIB -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-start border-5 border-warning">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-warning"><i class="bi bi-trash-fill me-2"></i>Hapus Isi Tabel Per KIB</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Pilih jenis KIB di bawah ini untuk menghapus seluruh data aset beserta dokumen lampirannya secara massal.
                    </p>
                    <div class="alert alert-danger py-2 px-3 small border-0 mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>PERINGATAN:</strong> Data yang sudah dihapus tidak dapat dikembalikan kecuali Anda memiliki salinan cadangan (Backup).
                    </div>

                    <form action="{{ route('backup.delete-kib') }}" method="POST" class="row g-3 align-items-end">
                        @csrf
                        <div class="col-md-8">
                            <label for="kib_type" class="form-label small fw-bold">Pilih KIB</label>
                            <select name="kib_type" id="kib_type" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Pilih Jenis KIB --</option>
                                <option value="A">KIB A (Tanah)</option>
                                <option value="B">KIB B (Peralatan dan Mesin)</option>
                                <option value="C">KIB C (Gedung dan Bangunan)</option>
                                <option value="D">KIB D (Jalan, Irigasi dan Jaringan)</option>
                                <option value="E">KIB E (Aset Tetap Lainnya)</option>
                                <option value="F">KIB F (Konstruksi Dalam Pengerjaan)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-warning w-100 py-2" onclick="return confirm('Apakah Anda yakin ingin MENGHAPUS SEMUA DATA untuk KIB yang dipilih?')">
                                <i class="bi bi-trash me-1"></i> Kosongkan Data KIB
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
