<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Aset</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('report.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Jenis KIB</label>
                    <select name="kib_type" class="form-select form-select-sm">
                        <option value="">Semua KIB</option>
                        <option value="A" {{ request('kib_type') == 'A' ? 'selected' : '' }}>KIB A</option>
                        <option value="B" {{ request('kib_type') == 'B' ? 'selected' : '' }}>KIB B</option>
                        <option value="C" {{ request('kib_type') == 'C' ? 'selected' : '' }}>KIB C</option>
                        <option value="D" {{ request('kib_type') == 'D' ? 'selected' : '' }}>KIB D</option>
                        <option value="E" {{ request('kib_type') == 'E' ? 'selected' : '' }}>KIB E</option>
                        <option value="F" {{ request('kib_type') == 'F' ? 'selected' : '' }}>KIB F</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Lokasi</label>
                    <select name="lokasi_id" class="form-select form-select-sm">
                        <option value="">Semua Lokasi</option>
                        @foreach($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Kondisi</label>
                    <select name="kondisi" class="form-select form-select-sm">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Kurang Baik" {{ request('kondisi') == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                        <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <a href="{{ route('report.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Laporan ({{ $asets->count() }} item)</h6>
            <div class="d-flex gap-2">
                <form action="{{ route('report.excel') }}" method="GET">
                    @foreach(request()->query() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-file-earmark-excel me-1"></i> Excel
                    </button>
                </form>
                <form action="{{ route('report.pdf') }}" method="GET">
                    @foreach(request()->query() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle border">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Aset</th>
                            <th>KIB</th>
                            <th>Lokasi</th>
                            <th>Tahun</th>
                            
                            @if(request('kib_type') == 'A')
                                <th>Luas</th>
                                <th>Status</th>
                            @elseif(request('kib_type') == 'B')
                                <th>Merk/Tipe</th>
                                <th>No. Seri/Polisi</th>
                            @elseif(request('kib_type') == 'C')
                                <th>Luas Bangunan</th>
                                <th>Alamat</th>
                            @elseif(request('kib_type') == 'D')
                                <th>Panjang</th>
                            @elseif(request('kib_type') == 'E')
                                <th>Jenis</th>
                            @elseif(request('kib_type') == 'F')
                                <th>Progress</th>
                            @endif

                            <th>Nilai</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asets as $aset)
                            <tr>
                                <td class="fw-bold">{{ $aset->kode_aset }}</td>
                                <td>{{ $aset->nama_aset }}</td>
                                <td><span class="badge bg-secondary">KIB {{ $aset->kib_type }}</span></td>
                                <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                                <td>{{ $aset->tahun_perolehan }}</td>

                                @if(request('kib_type') == 'A')
                                    <td>{{ $aset->kibA->luas ?? '-' }} m2</td>
                                    <td>{{ $aset->kibA->status_tanah ?? '-' }}</td>
                                @elseif(request('kib_type') == 'B')
                                    <td>{{ $aset->kibB->merk ?? '-' }} / {{ $aset->kibB->tipe ?? '-' }}</td>
                                    <td>{{ $aset->kibB->nomor_seri ?? '-' }} / {{ $aset->kibB->nomor_polisi ?? '-' }}</td>
                                @elseif(request('kib_type') == 'C')
                                    <td>{{ $aset->kibC->luas_bangunan ?? '-' }} m2</td>
                                    <td class="text-truncate" style="max-width: 150px;">{{ $aset->kibC->alamat ?? '-' }}</td>
                                @elseif(request('kib_type') == 'D')
                                    <td>{{ $aset->kibD->panjang ?? '-' }} m</td>
                                @elseif(request('kib_type') == 'E')
                                    <td>{{ $aset->kibE->jenis ?? '-' }}</td>
                                @elseif(request('kib_type') == 'F')
                                    <td>
                                        <div class="progress" style="height: 5px; width: 50px;">
                                            <div class="progress-bar" style="width: {{ $aset->kibF?->progress ?? 0 }}%;"></div>
                                        </div>
                                    </td>
                                @endif

                                <td>Rp {{ number_format($aset->nilai, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $aset->kondisi == 'Baik' ? 'success' : ($aset->kondisi == 'Kurang Baik' ? 'warning text-dark' : 'danger') }}">
                                        {{ $aset->kondisi }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
