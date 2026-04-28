<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Lokasi</h1>
        <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('lokasi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror" value="{{ old('nama_lokasi') }}" required>
                            @error('nama_lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Kecamatan</label>
                                <input type="text" name="kecamatan_id" class="form-control" value="{{ old('kecamatan_id') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Desa</label>
                                <input type="text" name="desa_id" class="form-control" value="{{ old('desa_id') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-4">
                            <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-light">Batal</a>
                            <button type="submit" class="btn btn-sm btn-primary px-4">Simpan Lokasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
