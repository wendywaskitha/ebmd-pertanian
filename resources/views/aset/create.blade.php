<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Aset</h1>
        <a href="{{ route('aset.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-4">
            <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data" x-data="{ kib_type: '{{ request('kib_type', old('kib_type', 'A')) }}' }">
                @csrf
                
                <div class="row g-4 mb-4">
                    <!-- Basic Info -->
                    <div class="col-md-6 border-end">
                        <h5 class="mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Informasi Umum</h5>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kode Aset</label>
                            <input type="text" name="kode_aset" class="form-control form-control-sm @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset') }}" required>
                            @error('kode_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Aset</label>
                            <input type="text" name="nama_aset" class="form-control form-control-sm @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset') }}" required>
                            @error('nama_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jenis KIB</label>
                            @if(request('kib_type'))
                                <select class="form-select form-select-sm bg-light" disabled>
                                    <option value="A" {{ request('kib_type') == 'A' ? 'selected' : '' }}>KIB A (Tanah)</option>
                                    <option value="B" {{ request('kib_type') == 'B' ? 'selected' : '' }}>KIB B (Peralatan & Mesin)</option>
                                    <option value="C" {{ request('kib_type') == 'C' ? 'selected' : '' }}>KIB C (Gedung & Bangunan)</option>
                                    <option value="D" {{ request('kib_type') == 'D' ? 'selected' : '' }}>KIB D (Jalan, Irigasi, Jaringan)</option>
                                    <option value="E" {{ request('kib_type') == 'E' ? 'selected' : '' }}>KIB E (Aset Tetap Lainnya)</option>
                                    <option value="F" {{ request('kib_type') == 'F' ? 'selected' : '' }}>KIB F (Konstruksi Dalam Pengerjaan)</option>
                                </select>
                                <input type="hidden" name="kib_type" value="{{ request('kib_type') }}">
                            @else
                                <select name="kib_type" class="form-select form-select-sm" x-model="kib_type" required>
                                    <option value="A">KIB A (Tanah)</option>
                                    <option value="B">KIB B (Peralatan & Mesin)</option>
                                    <option value="C">KIB C (Gedung & Bangunan)</option>
                                    <option value="D">KIB D (Jalan, Irigasi, Jaringan)</option>
                                    <option value="E">KIB E (Aset Tetap Lainnya)</option>
                                    <option value="F">KIB F (Konstruksi Dalam Pengerjaan)</option>
                                </select>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Lokasi</label>
                            <select name="lokasi_id" class="form-select form-select-sm" required>
                                <option value="">Pilih Lokasi...</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ old('lokasi_id') == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Details & Photo -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary"><i class="bi bi-card-list me-2"></i>Detail & Kondisi</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Tahun Perolehan</label>
                                <input type="number" name="tahun_perolehan" class="form-control form-control-sm" value="{{ old('tahun_perolehan', date('Y')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Kondisi</label>
                                <select name="kondisi" class="form-select form-select-sm" required>
                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Kurang Baik" {{ old('kondisi') == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                    <option value="Hilang" {{ old('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nilai Aset (Rp)</label>
                            <input type="number" name="nilai" class="form-control form-control-sm" value="{{ old('nilai') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Foto Aset</label>
                            <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                        </div>
                    </div>
                </div>

                <!-- Dynamic KIB Fields (Inline Labels) -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4 border shadow-sm h-100">
                            <div class="card-header bg-light py-2">
                                <h6 class="fw-bold text-dark mb-0 small">
                                    <i class="bi bi-gear-wide-connected me-2"></i>Atribut Khusus 
                                    <span class="badge bg-primary ms-1" x-text="'KIB ' + kib_type"></span>
                                </h6>
                            </div>
                            <div class="card-body py-3">
                                <div class="row">
                                    <!-- KIB A -->
                                    <div x-show="kib_type === 'A'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Luas (m2)</label>
                                            <div class="col-sm-8"><input type="number" name="luas" class="form-control form-control-sm" value="{{ old('luas') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Status Tanah</label>
                                            <div class="col-sm-8"><input type="text" name="status_tanah" class="form-control form-control-sm" value="{{ old('status_tanah') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Sertifikat</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_sertifikat" class="form-control form-control-sm" value="{{ old('nomor_sertifikat') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB B -->
                                    <div x-show="kib_type === 'B'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Merk</label>
                                            <div class="col-sm-8"><input type="text" name="merk" class="form-control form-control-sm" value="{{ old('merk') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tipe</label>
                                            <div class="col-sm-8"><input type="text" name="tipe" class="form-control form-control-sm" value="{{ old('tipe') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Seri/Mesin</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_seri" class="form-control form-control-sm" value="{{ old('nomor_seri') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Polisi/Kendaraan</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_polisi" class="form-control form-control-sm" value="{{ old('nomor_polisi') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tahun Beli</label>
                                            <div class="col-sm-8"><input type="number" name="tahun_pembelian" class="form-control form-control-sm" value="{{ old('tahun_pembelian') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB C -->
                                    <div x-show="kib_type === 'C'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Luas Bangunan</label>
                                            <div class="col-sm-8"><input type="number" name="luas_bangunan" class="form-control form-control-sm" value="{{ old('luas_bangunan') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Alamat Lengkap</label>
                                            <div class="col-sm-8"><input type="text" name="alamat" class="form-control form-control-sm" value="{{ old('alamat') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB D -->
                                    <div x-show="kib_type === 'D'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Panjang (m)</label>
                                            <div class="col-sm-8"><input type="number" name="panjang" class="form-control form-control-sm" value="{{ old('panjang') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Kondisi Khusus</label>
                                            <div class="col-sm-8"><input type="text" name="kondisi_kib_d" class="form-control form-control-sm" value="{{ old('kondisi_kib_d') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB E -->
                                    <div x-show="kib_type === 'E'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Jenis</label>
                                            <div class="col-sm-8"><input type="text" name="jenis" class="form-control form-control-sm" value="{{ old('jenis') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Keterangan</label>
                                            <div class="col-sm-8"><input type="text" name="keterangan" class="form-control form-control-sm" value="{{ old('keterangan') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB F -->
                                    <div x-show="kib_type === 'F'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Progress (%)</label>
                                            <div class="col-sm-8"><input type="number" name="progress" class="form-control form-control-sm" value="{{ old('progress') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Nilai Kontrak</label>
                                            <div class="col-sm-8"><input type="number" name="nilai_kontrak" class="form-control form-control-sm" value="{{ old('nilai_kontrak') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Vendor</label>
                                            <div class="col-sm-8"><input type="text" name="vendor" class="form-control form-control-sm" value="{{ old('vendor') }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Guide Panel -->
                    <div class="col-lg-4">
                        <div class="card border-0 bg-light shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3"><i class="bi bi-card-checklist text-primary me-2"></i>Daftar Atribut Khusus</h6>
                                <div class="small text-muted">
                                    <div class="mb-2"><span class="badge bg-secondary">KIB A</span> Luas (m2), Status Tanah, No. Sertifikat</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB B</span> Merk, Tipe, No. Seri/Mesin, Tahun Beli</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB C</span> Luas Bangunan, Alamat Lengkap</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB D</span> Panjang (m), Kondisi Khusus</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB E</span> Jenis, Keterangan</div>
                                    <div class="mb-0"><span class="badge bg-secondary">KIB F</span> Progress (%), Nilai Kontrak, Vendor</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <button type="reset" class="btn btn-sm btn-light">Reset</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4">Simpan Aset</button>
                </div>
            </form>
        </div>
    </div>
</x-bootstrap-layout>
