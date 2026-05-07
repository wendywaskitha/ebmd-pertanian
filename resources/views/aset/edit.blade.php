<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Aset</h1>
        <a href="{{ route('aset.show', $aset) }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-4">
            <form action="{{ route('aset.update', $aset) }}" method="POST" enctype="multipart/form-data" x-data="{ 
                kib_type: '{{ old('kib_type', $aset->kib_type) }}',
                lampirans: [{ id: Date.now(), keterangan: '' }],
                getSuggestions() {
                    if (this.kib_type === 'A') return ['Sertifikat Tanah', 'Peta Bidang', 'AJB'];
                    if (this.kib_type === 'B') return ['STNK', 'BPKB', 'Faktur', 'Kuitansi'];
                    if (this.kib_type === 'C') return ['IMB/PBG', 'As Built Drawing'];
                    if (this.kib_type === 'D') return ['Dokumen Kontrak', 'BAST'];
                    if (this.kib_type === 'E') return ['Sertifikat', 'Faktur'];
                    if (this.kib_type === 'F') return ['Kontrak Kerja', 'Dokumentasi'];
                    return [];
                }
            }">
                @csrf
                @method('PUT')
                
                <div class="row g-4 mb-4">
                    <!-- Basic Info -->
                    <div class="col-md-6 border-end">
                        <h5 class="mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Informasi Umum</h5>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kode Aset</label>
                            <input type="text" name="kode_aset" class="form-control form-control-sm @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset', $aset->kode_aset) }}" required>
                            @error('kode_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Aset</label>
                            <input type="text" name="nama_aset" class="form-control form-control-sm @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset', $aset->nama_aset) }}" required>
                            @error('nama_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jenis KIB</label>
                            <select class="form-select form-select-sm bg-light" disabled>
                                <option value="A" {{ old('kib_type', $aset->kib_type) == 'A' ? 'selected' : '' }}>KIB A (Tanah)</option>
                                <option value="B" {{ old('kib_type', $aset->kib_type) == 'B' ? 'selected' : '' }}>KIB B (Peralatan & Mesin)</option>
                                <option value="C" {{ old('kib_type', $aset->kib_type) == 'C' ? 'selected' : '' }}>KIB C (Gedung & Bangunan)</option>
                                <option value="D" {{ old('kib_type', $aset->kib_type) == 'D' ? 'selected' : '' }}>KIB D (Jalan, Irigasi, Jaringan)</option>
                                <option value="E" {{ old('kib_type', $aset->kib_type) == 'E' ? 'selected' : '' }}>KIB E (Aset Tetap Lainnya)</option>
                                <option value="F" {{ old('kib_type', $aset->kib_type) == 'F' ? 'selected' : '' }}>KIB F (Konstruksi Dalam Pengerjaan)</option>
                            </select>
                            <input type="hidden" name="kib_type" value="{{ old('kib_type', $aset->kib_type) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Lokasi</label>
                            <select name="lokasi_id" class="form-select form-select-sm" required>
                                <option value="">Pilih Lokasi...</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ old('lokasi_id', $aset->lokasi_id) == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pengguna Aset (Penanggung Jawab)</label>
                            <input type="text" name="pengguna_aset" class="form-control form-control-sm @error('pengguna_aset') is-invalid @enderror" value="{{ old('pengguna_aset', $aset->pengguna_aset) }}" placeholder="Nama penanggung jawab aset...">
                            @error('pengguna_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Details & Photo -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary"><i class="bi bi-card-list me-2"></i>Detail & Kondisi</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Tahun Perolehan</label>
                                <input type="number" name="tahun_perolehan" class="form-control form-control-sm" value="{{ old('tahun_perolehan', $aset->tahun_perolehan) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Kondisi</label>
                                <select name="kondisi" class="form-select form-select-sm" required>
                                    <option value="Baik" {{ old('kondisi', $aset->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Kurang Baik" {{ old('kondisi', $aset->kondisi) == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi', $aset->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi', $aset->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                    <option value="Hilang" {{ old('kondisi', $aset->kondisi) == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nilai Aset (Rp)</label>
                            <input type="number" name="nilai" class="form-control form-control-sm" value="{{ old('nilai', $aset->nilai) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Foto Aset</label>
                            @if($aset->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $aset->foto) }}" class="img-thumbnail" style="height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
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
                                            <div class="col-sm-8"><input type="number" name="luas" class="form-control form-control-sm" value="{{ old('luas', $aset->kibA->luas ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Status Tanah</label>
                                            <div class="col-sm-8"><input type="text" name="status_tanah" class="form-control form-control-sm" value="{{ old('status_tanah', $aset->kibA->status_tanah ?? '') }}" placeholder="Misal: Hak Milik, HGB, dll"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Sertifikat</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_sertifikat" class="form-control form-control-sm" value="{{ old('nomor_sertifikat', $aset->kibA->nomor_sertifikat ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tgl. Sertifikat</label>
                                            <div class="col-sm-8"><input type="date" name="tanggal_sertifikat" class="form-control form-control-sm" value="{{ old('tanggal_sertifikat', $aset->kibA->tanggal_sertifikat ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Penggunaan</label>
                                            <div class="col-sm-8"><input type="text" name="penggunaan" class="form-control form-control-sm" value="{{ old('penggunaan', $aset->kibA->penggunaan ?? '') }}" placeholder="Misal: Perkantoran, Sekolah, dll"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Keterangan</label>
                                            <div class="col-sm-8"><textarea name="keterangan" class="form-control form-control-sm" rows="2">{{ old('keterangan', $aset->kibA->keterangan ?? '') }}</textarea></div>
                                        </div>
                                    </div>

                                    <!-- KIB B -->
                                    <div x-show="kib_type === 'B'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Merk</label>
                                            <div class="col-sm-8"><input type="text" name="merk" class="form-control form-control-sm" value="{{ old('merk', $aset->kibB->merk ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tipe</label>
                                            <div class="col-sm-8"><input type="text" name="tipe" class="form-control form-control-sm" value="{{ old('tipe', $aset->kibB->tipe ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Ukuran</label>
                                            <div class="col-sm-8"><input type="text" name="ukuran" class="form-control form-control-sm" value="{{ old('ukuran', $aset->kibB->ukuran ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Seri/Mesin</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_seri" class="form-control form-control-sm" value="{{ old('nomor_seri', $aset->kibB->nomor_seri ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Rangka</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_rangka" class="form-control form-control-sm" value="{{ old('nomor_rangka', $aset->kibB->nomor_rangka ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Polisi/Kendaraan</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_polisi" class="form-control form-control-sm" value="{{ old('nomor_polisi', $aset->kibB->nomor_polisi ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. BPKB</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_bpkb" class="form-control form-control-sm" value="{{ old('nomor_bpkb', $aset->kibB->nomor_bpkb ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tahun Beli</label>
                                            <div class="col-sm-8"><input type="number" name="tahun_pembelian" class="form-control form-control-sm" value="{{ old('tahun_pembelian', $aset->kibB->tahun_pembelian ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Asal Usul</label>
                                            <div class="col-sm-8"><input type="text" name="asal_usul" class="form-control form-control-sm" value="{{ old('asal_usul', $aset->kibB->asal_usul ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Ruang Penyimpanan</label>
                                            <div class="col-sm-8"><input type="text" name="ruang_penyimpanan" class="form-control form-control-sm" value="{{ old('ruang_penyimpanan', $aset->kibB->ruang_penyimpanan ?? '') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB C -->
                                    <div x-show="kib_type === 'C'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Luas Bangunan</label>
                                            <div class="col-sm-8"><input type="number" name="luas_bangunan" class="form-control form-control-sm" value="{{ old('luas_bangunan', $aset->kibC->luas_bangunan ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Bertingkat</label>
                                            <div class="col-sm-8">
                                                <select name="bertingkat" class="form-select form-select-sm">
                                                    <option value="Tidak" {{ old('bertingkat', $aset->kibC->bertingkat ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                    <option value="Ya" {{ old('bertingkat', $aset->kibC->bertingkat ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tgl. Kontrak</label>
                                            <div class="col-sm-8"><input type="date" name="tanggal_kontrak" class="form-control form-control-sm" value="{{ old('tanggal_kontrak', $aset->kibC->tanggal_kontrak ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Kontrak</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_kontrak" class="form-control form-control-sm" value="{{ old('nomor_kontrak', $aset->kibC->nomor_kontrak ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Alamat Lengkap</label>
                                            <div class="col-sm-8"><input type="text" name="alamat" class="form-control form-control-sm" value="{{ old('alamat', $aset->kibC->alamat ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Status Tanah</label>
                                            <div class="col-sm-8">
                                                <select name="status_tanah" class="form-select form-select-sm">
                                                    <option value="">Pilih Status...</option>
                                                    <option value="Milik Sendiri" {{ old('status_tanah', $aset->kibC->status_tanah ?? '') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                                    <option value="Tanah Milik Pemda" {{ old('status_tanah', $aset->kibC->status_tanah ?? '') == 'Tanah Milik Pemda' ? 'selected' : '' }}>Tanah Milik Pemda</option>
                                                    <option value="Tanah Milik Negara" {{ old('status_tanah', $aset->kibC->status_tanah ?? '') == 'Tanah Milik Negara' ? 'selected' : '' }}>Tanah Milik Negara</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Kode Tanah</label>
                                            <div class="col-sm-8"><input type="text" name="kode_tanah" class="form-control form-control-sm" value="{{ old('kode_tanah', $aset->kibC->kode_tanah ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Asal Usul</label>
                                            <div class="col-sm-8"><input type="text" name="asal_usul" class="form-control form-control-sm" value="{{ old('asal_usul', $aset->kibC->asal_usul ?? '') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB D -->
                                    <div x-show="kib_type === 'D'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Konstruksi</label>
                                            <div class="col-sm-8"><input type="text" name="konstruksi" class="form-control form-control-sm" value="{{ old('konstruksi', $aset->kibD->konstruksi ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Panjang (m)</label>
                                            <div class="col-sm-8"><input type="number" name="panjang" class="form-control form-control-sm" value="{{ old('panjang', $aset->kibD->panjang ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Luas (m2)</label>
                                            <div class="col-sm-8"><input type="number" step="any" name="luas" class="form-control form-control-sm" value="{{ old('luas', $aset->kibD->luas ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tgl. Kontrak</label>
                                            <div class="col-sm-8"><input type="date" name="tanggal_kontrak" class="form-control form-control-sm" value="{{ old('tanggal_kontrak', $aset->kibD->tanggal_kontrak ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">No. Kontrak</label>
                                            <div class="col-sm-8"><input type="text" name="nomor_kontrak" class="form-control form-control-sm" value="{{ old('nomor_kontrak', $aset->kibD->nomor_kontrak ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Status Tanah</label>
                                            <div class="col-sm-8">
                                                <select name="status_tanah" class="form-select form-select-sm">
                                                    <option value="">Pilih Status...</option>
                                                    <option value="Milik Sendiri" {{ old('status_tanah', $aset->kibD->status_tanah ?? '') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                                    <option value="Tanah Milik Pemda" {{ old('status_tanah', $aset->kibD->status_tanah ?? '') == 'Tanah Milik Pemda' ? 'selected' : '' }}>Tanah Milik Pemda</option>
                                                    <option value="Tanah Milik Negara" {{ old('status_tanah', $aset->kibD->status_tanah ?? '') == 'Tanah Milik Negara' ? 'selected' : '' }}>Tanah Milik Negara</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Asal Usul</label>
                                            <div class="col-sm-8"><input type="text" name="asal_usul" class="form-control form-control-sm" value="{{ old('asal_usul', $aset->kibD->asal_usul ?? '') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB E -->
                                    <div x-show="kib_type === 'E'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Jenis</label>
                                            <div class="col-sm-8"><input type="text" name="jenis" class="form-control form-control-sm" value="{{ old('jenis', $aset->kibE->jenis ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Keterangan</label>
                                            <div class="col-sm-8"><input type="text" name="keterangan" class="form-control form-control-sm" value="{{ old('keterangan', $aset->kibE->keterangan ?? '') }}"></div>
                                        </div>
                                    </div>

                                    <!-- KIB F -->
                                    <div x-show="kib_type === 'F'" class="col-12">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Bertingkat</label>
                                            <div class="col-sm-8">
                                                <select name="bertingkat" class="form-select form-select-sm">
                                                    <option value="Tidak" {{ old('bertingkat', $aset->kibF->bertingkat ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                    <option value="Ya" {{ old('bertingkat', $aset->kibF->bertingkat ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Tgl. Kontrak</label>
                                            <div class="col-sm-8"><input type="date" name="tanggal_kontrak" class="form-control form-control-sm" value="{{ old('tanggal_kontrak', $aset->kibF->tanggal_kontrak ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Nilai Kontrak</label>
                                            <div class="col-sm-8"><input type="number" name="nilai_kontrak" class="form-control form-control-sm" value="{{ old('nilai_kontrak', $aset->kibF->nilai_kontrak ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Status Tanah</label>
                                            <div class="col-sm-8">
                                                <select name="status_tanah" class="form-select form-select-sm">
                                                    <option value="">Pilih Status...</option>
                                                    <option value="Milik Sendiri" {{ old('status_tanah', $aset->kibF->status_tanah ?? '') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                                    <option value="Tanah Milik Pemda" {{ old('status_tanah', $aset->kibF->status_tanah ?? '') == 'Tanah Milik Pemda' ? 'selected' : '' }}>Tanah Milik Pemda</option>
                                                    <option value="Tanah Milik Negara" {{ old('status_tanah', $aset->kibF->status_tanah ?? '') == 'Tanah Milik Negara' ? 'selected' : '' }}>Tanah Milik Negara</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Asal Usul</label>
                                            <div class="col-sm-8"><input type="text" name="asal_usul" class="form-control form-control-sm" value="{{ old('asal_usul', $aset->kibF->asal_usul ?? '') }}"></div>
                                        </div>
                                        <div class="row g-2 align-items-center">
                                            <label class="col-sm-4 col-form-label col-form-label-sm fw-bold">Sisa Kontrak</label>
                                            <div class="col-sm-8"><input type="number" name="sisa_kontrak" class="form-control form-control-sm" value="{{ old('sisa_kontrak', $aset->kibF->sisa_kontrak ?? '') }}"></div>
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
                                    <div class="mb-2"><span class="badge bg-secondary">KIB A</span> Luas (m2), Status Tanah, No. Sertifikat, Tgl. Sertifikat, Penggunaan, Keterangan</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB B</span> Merk, Tipe, Ukuran, No. Seri, No. Rangka, No. Polisi, No. BPKB, Tahun Beli, Asal Usul, Ruang</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB C</span> Luas, Bertingkat, Kontrak, Alamat, Status Tanah, Kode Tanah</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB D</span> Konstruksi, Panjang, Luas, Kontrak, Status Tanah</div>
                                    <div class="mb-2"><span class="badge bg-secondary">KIB E</span> Jenis, Keterangan</div>
                                    <div class="mb-0"><span class="badge bg-secondary">KIB F</span> Bertingkat, Kontrak, Status Tanah, Sisa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lampiran Dokumen Saat Ini -->
                @if($aset->lampirans->count() > 0)
                <div class="card mb-3 border-start border-5 border-success shadow-sm">
                    <div class="card-header bg-light py-2">
                        <h6 class="fw-bold text-dark mb-0 small">
                            <i class="bi bi-paperclip me-2"></i>Lampiran Dokumen Saat Ini
                        </h6>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <tbody class="small">
                                    @foreach($aset->lampirans as $lampiran)
                                        <tr>
                                            <td>
                                                <a href="{{ Storage::url($lampiran->path) }}" target="_blank" class="text-decoration-none">
                                                    <i class="bi bi-file-earmark-text me-1"></i>{{ $lampiran->nama_file }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-light text-dark border">{{ $lampiran->keterangan ?? '-' }}</span></td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="if(confirm('Hapus lampiran ini?')) { document.getElementById('delete-lampiran-{{ $lampiran->id }}').submit(); }">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @foreach($aset->lampirans as $lampiran)
                    <form id="delete-lampiran-{{ $lampiran->id }}" action="{{ route('aset.destroy-lampiran', $lampiran) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
                @endif

                <!-- Tambah Lampiran Baru -->
                <div class="card mt-4 mb-4 border-start border-5 border-primary shadow-sm">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0 small">
                            <i class="bi bi-plus-circle me-2"></i>Unggah Lampiran Baru (Opsional)
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" @click="lampirans.push({ id: Date.now(), keterangan: '' })">
                            <i class="bi bi-plus-lg"></i> Tambah Baris
                        </button>
                    </div>
                    <div class="card-body py-3">
                        <div class="text-muted small mb-3">
                            <span class="me-2">Saran:</span>
                            <template x-for="sug in getSuggestions()" :key="sug">
                                <span class="badge bg-white text-dark border me-1 py-1 px-2" @click="if (lampirans.length > 0) lampirans[lampirans.length-1].keterangan = sug" style="cursor:pointer;" x-text="sug"></span>
                            </template>
                        </div>

                        <template x-for="(row, index) in lampirans" :key="row.id">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="file" :name="'lampirans[' + index + ']'" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" :name="'lampiran_keterangans[' + index + ']'" class="form-control form-control-sm" placeholder="Keterangan (misal: STNK, Sertifikat)" x-model="row.keterangan">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger w-100" @click="if(lampirans.length > 1) lampirans.splice(index, 1); else { row.keterangan = ''; }">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('aset.show', $aset) }}" class="btn btn-sm btn-light">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary px-4">Perbarui Aset</button>
                </div>
            </form>
        </div>
    </div>
</x-bootstrap-layout>
