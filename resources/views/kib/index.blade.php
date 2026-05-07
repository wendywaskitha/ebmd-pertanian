<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data KIB {{ $type }}</h1>
            <p class="text-muted small mb-0">
                @switch($type)
                    @case('A') (Tanah) @break
                    @case('B') (Peralatan dan Mesin) @break
                    @case('C') (Gedung dan Bangunan) @break
                    @case('D') (Jalan, Irigasi dan Jaringan) @break
                    @case('E') (Aset Tetap Lainnya) @break
                    @case('F') (Konstruksi Dalam Pengerjaan) @break
                @endswitch
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('kib.template', $type) }}" class="btn btn-sm btn-outline-success shadow-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> Unduh Template
            </a>
            <button type="button" class="btn btn-sm btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                <i class="bi bi-box-arrow-in-down me-1"></i> Impor Excel
            </button>
            <a href="{{ route('kib.print-bulk-qr', $type) }}" target="_blank" class="btn btn-sm btn-outline-danger shadow-sm">
                <i class="bi bi-qr-code me-1"></i> Cetak Semua QR
            </a>
            <a href="{{ route('aset.create') }}?kib_type={{ $type }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Aset KIB {{ $type }}
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4">Kode / Nama</th>
                            <th>Lokasi</th>
                            <th>Tahun</th>
                            <th>Nilai (Rp)</th>
                            
                            <!-- Dynamic Columns based on Type -->
                            @if($type == 'A')
                                <th>Luas</th>
                                <th>Status</th>
                            @elseif($type == 'B')
                                <th>Merk/Tipe</th>
                                <th>No. Seri</th>
                                <th>No. Polisi</th>
                            @elseif($type == 'C')
                                <th>Luas Bangunan</th>
                                <th>Alamat</th>
                            @elseif($type == 'D')
                                <th>Panjang</th>
                            @elseif($type == 'E')
                                <th>Jenis</th>
                            @elseif($type == 'F')
                                <th>Progress</th>
                                <th>Vendor</th>
                            @endif

                            <th>Kondisi</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($asets as $aset)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $aset->nama_aset }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $aset->kode_aset }}</div>
                                </td>
                                <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                                <td>{{ $aset->tahun_perolehan }}</td>
                                <td class="fw-bold text-success">{{ number_format($aset->nilai, 0, ',', '.') }}</td>
                                
                                <!-- Dynamic Data based on Type -->
                                @if($type == 'A')
                                    <td>{{ $aset->kibA->luas ?? '-' }} m2</td>
                                    <td>{{ $aset->kibA->status_tanah ?? '-' }}</td>
                                @elseif($type == 'B')
                                    <td>{{ $aset->kibB->merk ?? '-' }} / {{ $aset->kibB->tipe ?? '-' }}</td>
                                    <td>{{ $aset->kibB->nomor_seri ?? '-' }}</td>
                                    <td>{{ $aset->kibB->nomor_polisi ?? '-' }}</td>
                                @elseif($type == 'C')
                                    <td>{{ $aset->kibC->luas_bangunan ?? '-' }} m2</td>
                                    <td class="text-truncate" style="max-width: 150px;">{{ $aset->kibC->alamat ?? '-' }}</td>
                                @elseif($type == 'D')
                                    <td>{{ $aset->kibD->panjang ?? '-' }} m</td>
                                @elseif($type == 'E')
                                    <td>{{ $aset->kibE->jenis ?? '-' }}</td>
                                @elseif($type == 'F')
                                    <td>
                                        <div class="progress" style="height: 5px; width: 60px;">
                                            <div class="progress-bar" role="progressbar" {!! 'style="width: ' . ($aset->kibF?->progress ?? 0) . '%;"' !!}></div>
                                        </div>
                                        <span class="x-small">{{ $aset->kibF?->progress ?? 0 }}%</span>
                                    </td>
                                    <td>{{ $aset->kibF->vendor ?? '-' }}</td>
                                @endif

                                <td>
                                    <span class="badge bg-{{ $aset->kondisi == 'Baik' ? 'success' : ($aset->kondisi == 'Kurang Baik' ? 'warning text-dark' : 'danger') }}" style="font-size: 0.7rem;">
                                        {{ $aset->kondisi }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('aset.show', $aset) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('aset.edit', $aset) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data untuk KIB {{ $type }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($asets->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $asets->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Impor Excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('kib.import', $type) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importExcelModalLabel"><i class="bi bi-file-earmark-excel me-2 text-success"></i>Impor Data KIB {{ $type }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info py-2 small mb-3">
                            <i class="bi bi-info-circle me-1"></i> Pastikan Anda menggunakan file template Excel yang telah diunduh dari tombol <strong>Unduh Template</strong> untuk menghindari kesalahan format kolom.
                        </div>
                        <div class="mb-3">
                            <label for="file_excel" class="form-label small fw-bold">Pilih File Excel (.xlsx, .xls)</label>
                            <input class="form-control form-control-sm" type="file" id="file_excel" name="file" accept=".xlsx, .xls, .csv" required>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-success px-3"><i class="bi bi-cloud-arrow-up me-1"></i> Mulai Impor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
