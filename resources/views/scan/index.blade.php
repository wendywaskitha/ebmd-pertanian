<x-bootstrap-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Scan QR Code Aset</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-camera me-2"></i>Kamera Scanner</h6>
                </div>
                <div class="card-body">
                    <div id="reader" style="width: 100%; border-radius: 10px; overflow: hidden; border: 2px solid #eee;"></div>
                    
                    <div id="error" class="mt-4 d-none">
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                            <div id="error-message">Aset tidak ditemukan dalam sistem.</div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-muted small">Posisikan QR Code aset di dalam kotak scanner untuk identifikasi otomatis.</p>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-lightning-fill text-warning"></i> Cepat
                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-shield-check text-success"></i> Aman
                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-phone text-primary"></i> Mobile Ready
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Modal (Meta Data Lengkap) -->
    <div class="modal fade" id="scanResultModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Aset Berhasil Diidentifikasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light text-center p-3 d-flex align-items-center justify-content-center border-end">
                            <img id="aset-foto" src="" class="img-fluid rounded shadow-sm d-none" style="max-height: 200px;">
                            <div id="aset-no-foto" class="text-muted small">
                                <i class="bi bi-image fs-1 d-block mb-2"></i>
                                Tidak Ada Foto
                            </div>
                        </div>
                        <div class="col-md-8 p-4">
                            <div class="badge bg-primary mb-2" id="aset-kib"></div>
                            <h4 class="fw-bold mb-1" id="aset-nama"></h4>
                            <p class="text-muted small mb-4" id="aset-kode"></p>
                            
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="text-muted small d-block">Lokasi</label>
                                    <span class="fw-bold" id="aset-lokasi"></span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Kondisi</label>
                                    <span class="badge" id="aset-kondisi"></span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Tahun</label>
                                    <span class="fw-bold" id="aset-tahun"></span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Nilai</label>
                                    <span class="fw-bold text-success" id="aset-nilai"></span>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Atribut Khusus KIB</h6>
                            <div id="aset-kib-data" class="row g-2 small">
                                <!-- Dynamic KIB attributes will be injected here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <a id="aset-detail-link" href="#" class="btn btn-primary btn-sm px-4">
                        Lihat Detail Lengkap <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrcodeScanner;
        let scanResultModal;

        document.addEventListener('DOMContentLoaded', function() {
            scanResultModal = new bootstrap.Modal(document.getElementById('scanResultModal'));
            renderScanner();

            document.getElementById('scanResultModal').addEventListener('hidden.bs.modal', function () {
                renderScanner();
            });
        });

        function onScanSuccess(decodedText, decodedResult) {
            html5QrcodeScanner.clear();
            
            fetch('{{ route("scan.lookup") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const aset = data.aset;
                    
                    // Fill modal data
                    document.getElementById('aset-nama').innerText = aset.nama;
                    document.getElementById('aset-kode').innerText = aset.kode;
                    document.getElementById('aset-kib').innerText = 'KIB ' + aset.kib;
                    document.getElementById('aset-lokasi').innerText = aset.lokasi;
                    document.getElementById('aset-tahun').innerText = aset.tahun;
                    document.getElementById('aset-nilai').innerText = 'Rp ' + aset.nilai;
                    document.getElementById('aset-detail-link').href = data.redirect;
                    
                    // Condition badge
                    const condBadge = document.getElementById('aset-kondisi');
                    condBadge.innerText = aset.kondisi;
                    condBadge.className = 'badge bg-' + (aset.kondisi === 'Baik' ? 'success' : (aset.kondisi === 'Kurang Baik' ? 'warning text-dark' : 'danger'));

                    // Photo
                    if (aset.foto) {
                        document.getElementById('aset-foto').src = aset.foto;
                        document.getElementById('aset-foto').classList.remove('d-none');
                        document.getElementById('aset-no-foto').classList.add('d-none');
                    } else {
                        document.getElementById('aset-foto').classList.add('d-none');
                        document.getElementById('aset-no-foto').classList.remove('d-none');
                    }

                    // KIB Data
                    const kibContainer = document.getElementById('aset-kib-data');
                    kibContainer.innerHTML = '';
                    for (const [key, value] of Object.entries(aset.kib_data)) {
                        kibContainer.innerHTML += `
                            <div class="col-6">
                                <label class="text-muted d-block">${key}</label>
                                <span class="fw-bold">${value || '-'}</span>
                            </div>
                        `;
                    }

                    scanResultModal.show();
                } else {
                    document.getElementById('error-message').innerText = data.message;
                    document.getElementById('error').classList.remove('d-none');
                    setTimeout(() => {
                        document.getElementById('error').classList.add('d-none');
                        renderScanner();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                renderScanner();
            });
        }

        function renderScanner() {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 15, qrbox: {width: 250, height: 250} }, /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess);
        }
    </script>
    @endpush
</x-bootstrap-layout>
