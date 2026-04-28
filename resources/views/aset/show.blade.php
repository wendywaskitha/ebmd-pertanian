<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aset</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('aset.edit', $aset) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit Aset
            </a>
            <a href="{{ route('aset.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Aset</h6>
                </div>
                <div class="card-body text-center p-0">
                    @if($aset->foto)
                        <img src="{{ asset('storage/' . $aset->foto) }}" class="img-fluid rounded-bottom" alt="{{ $aset->nama_aset }}" style="width: 100%; height: 250px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">QR Code Identitas</h6>
                </div>
                <div class="card-body text-center">
                    <div class="p-3 bg-white border d-inline-block rounded shadow-sm mb-3">
                        @php
                            $qrText = "KODE: " . $aset->kode_aset . "\n" .
                                     "NAMA: " . $aset->nama_aset . "\n" .
                                     "TAHUN: " . $aset->tahun_perolehan . "\n" .
                                     "NILAI: Rp " . number_format($aset->nilai, 0, ',', '.');
                        @endphp
                        {!! QrCode::size(150)->generate($qrText) !!}
                    </div>
                    <div class="small fw-bold text-muted mb-3">{{ $aset->kode_aset }}</div>
                    <a href="{{ route('aset.print-qr', $aset) }}" target="_blank" class="btn btn-sm btn-outline-dark w-100">
                        <i class="bi bi-printer me-2"></i> Cetak Label QR
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Info -->
        <div class="col-lg-8">
            <!-- Informasi Umum -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Utama</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Nama Aset</label>
                            <span class="fw-bold h5 text-dark">{{ $aset->nama_aset }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Kode Registrasi</label>
                            <span class="badge bg-primary fs-6">{{ $aset->kode_aset }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Jenis KIB</label>
                            <span class="badge bg-info text-dark">KIB {{ $aset->kib_type }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Lokasi</label>
                            <span class="fw-bold">{{ $aset->lokasi->nama_lokasi ?? '-' }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block mb-1">Tahun Perolehan</label>
                            <span class="fw-bold">{{ $aset->tahun_perolehan }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block mb-1">Nilai Aset</label>
                            <span class="fw-bold text-success">Rp {{ number_format($aset->nilai, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block mb-1">Kondisi Saat Ini</label>
                            <span class="badge bg-{{ $aset->kondisi == 'Baik' ? 'success' : ($aset->kondisi == 'Kurang Baik' ? 'warning text-dark' : 'danger') }}">
                                {{ $aset->kondisi }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Atribut KIB -->
            <div class="card shadow mb-4 border-start border-5 border-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Detail Atribut KIB {{ $aset->kib_type }}</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @if($aset->kib_type == 'A' && $aset->kibA)
                            <div class="col-md-4"><label class="text-muted small d-block">Luas</label><span class="fw-bold">{{ $aset->kibA->luas }} m2</span></div>
                            <div class="col-md-4"><label class="text-muted small d-block">Status Tanah</label><span class="fw-bold">{{ $aset->kibA->status_tanah }}</span></div>
                            <div class="col-md-4"><label class="text-muted small d-block">No. Sertifikat</label><span class="fw-bold">{{ $aset->kibA->nomor_sertifikat ?? '-' }}</span></div>
                        @elseif($aset->kib_type == 'B' && $aset->kibB)
                            <div class="col-md-3"><label class="text-muted small d-block">Merk</label><span class="fw-bold">{{ $aset->kibB->merk ?? '-' }}</span></div>
                            <div class="col-md-3"><label class="text-muted small d-block">Tipe</label><span class="fw-bold">{{ $aset->kibB->tipe ?? '-' }}</span></div>
                            <div class="col-md-3"><label class="text-muted small d-block">No. Seri</label><span class="fw-bold">{{ $aset->kibB->nomor_seri ?? '-' }}</span></div>
                            <div class="col-md-3"><label class="text-muted small d-block">No. Polisi</label><span class="fw-bold">{{ $aset->kibB->nomor_polisi ?? '-' }}</span></div>
                            <div class="col-md-3"><label class="text-muted small d-block">Tahun Beli</label><span class="fw-bold">{{ $aset->kibB->tahun_pembelian ?? '-' }}</span></div>
                        @elseif($aset->kib_type == 'C' && $aset->kibC)
                            <div class="col-md-4"><label class="text-muted small d-block">Luas Bangunan</label><span class="fw-bold">{{ $aset->kibC->luas_bangunan }} m2</span></div>
                            <div class="col-md-8"><label class="text-muted small d-block">Alamat</label><span class="fw-bold">{{ $aset->kibC->alamat ?? '-' }}</span></div>
                        @elseif($aset->kib_type == 'D' && $aset->kibD)
                            <div class="col-md-6"><label class="text-muted small d-block">Panjang</label><span class="fw-bold">{{ $aset->kibD->panjang }} m</span></div>
                            <div class="col-md-6"><label class="text-muted small d-block">Kondisi Khusus</label><span class="fw-bold">{{ $aset->kibD->kondisi_kib_d ?? '-' }}</span></div>
                        @elseif($aset->kib_type == 'E' && $aset->kibE)
                            <div class="col-md-6"><label class="text-muted small d-block">Jenis</label><span class="fw-bold">{{ $aset->kibE->jenis }}</span></div>
                            <div class="col-md-6"><label class="text-muted small d-block">Keterangan</label><span class="fw-bold">{{ $aset->kibE->keterangan ?? '-' }}</span></div>
                        @elseif($aset->kib_type == 'F' && $aset->kibF)
                            <div class="col-md-4"><label class="text-muted small d-block">Progress</label><span class="fw-bold">{{ $aset->kibF->progress }}%</span></div>
                            <div class="col-md-4"><label class="text-muted small d-block">Nilai Kontrak</label><span class="fw-bold text-success">Rp {{ number_format($aset->kibF->nilai_kontrak, 0, ',', '.') }}</span></div>
                            <div class="col-md-4"><label class="text-muted small d-block">Vendor</label><span class="fw-bold">{{ $aset->kibF->vendor ?? '-' }}</span></div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Riwayat Stock Opname -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Stock Opname</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockOpnameModal">
                        <i class="bi bi-plus-lg me-1"></i> Update Status
                    </button>
                </div>
                <div class="card-body">
                    @if($aset->stockOpnames->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light small">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aset->stockOpnames as $so)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($so->tanggal)->format('d M Y') }}</td>
                                            <td>
                                                @php
                                                    $color = match($so->status) {
                                                        'Baik' => 'success',
                                                        'Kurang Baik' => 'warning text-dark',
                                                        'Rusak Ringan' => 'warning',
                                                        'Rusak Berat' => 'danger',
                                                        'Hilang' => 'dark',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ $so->status }}
                                                </span>
                                            </td>
                                            <td class="small">{{ $so->keterangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted small italic">Belum ada riwayat stock opname.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Opname Modal -->
    <div class="modal fade" id="stockOpnameModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Stock Opname</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stock-opname.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="aset_id" value="{{ $aset->id }}">
                    <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kondisi Terkini</label>
                            <select name="status" class="form-select" required>
                                <option value="Baik">Baik</option>
                                <option value="Kurang Baik">Kurang Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                                <option value="Hilang">Hilang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Opsional..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
