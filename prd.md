# 📄 PRODUCT REQUIREMENTS DOCUMENT (PRD) FINAL

## Aplikasi Manajemen Aset (KIB A–F) Berbasis QR Code

### Dinas Pertanian Kabupaten Muna Barat

---

# 1. 📌 LATAR BELAKANG

Pengelolaan aset daerah di Dinas Pertanian Kabupaten Muna Barat masih dilakukan secara manual dan belum terintegrasi secara digital. Dampaknya:

* Sulit melakukan pelacakan aset
* Data tidak real-time
* Proses stock opname lambat dan tidak efisien
* Kurangnya transparansi dan akuntabilitas

Diperlukan sistem berbasis web yang modern, cepat, dan mudah digunakan dengan dukungan QR Code untuk meningkatkan kualitas pengelolaan aset.

---

# 2. 🎯 TUJUAN

* Mewujudkan digitalisasi pengelolaan aset
* Meningkatkan efisiensi dan kecepatan kerja
* Menyediakan sistem tracking aset berbasis QR Code
* Mendukung transparansi dan akuntabilitas aset pemerintah

---

# 3. 👥 ROLE & AKSES

## 3.1 Admin

* Full akses sistem
* Kelola aset, lokasi, laporan
* Monitoring seluruh aktivitas

## 3.2 Operator

* Input dan update aset
* Melakukan stock opname
* Scan QR

---

# 4. 🧩 RUANG LINGKUP FITUR

---

## 4.1 Manajemen Aset (KIB A–F)

### Deskripsi

Pengelolaan aset berdasarkan klasifikasi:

* KIB A (Tanah)
* KIB B (Peralatan & Mesin)
* KIB C (Gedung & Bangunan)
* KIB D (Jalan, Irigasi, Jaringan)
* KIB E (Aset Tetap Lainnya)
* KIB F (Konstruksi Dalam Pengerjaan)

### Fitur

* CRUD aset
* Kode aset otomatis
* Upload foto aset
* Input lokasi + koordinat
* Form dinamis sesuai jenis KIB
* Status kondisi aset

---

## 4.2 QR Code Aset

### Fitur

* Generate otomatis setelah simpan
* Format PNG
* Berisi:

  * ID aset
  * Nama aset
  * Kode aset
* Tampil di halaman detail
* Bisa dicetak

---

## 4.3 Scan QR Code

### Fitur

* Scan via kamera (web)
* Redirect otomatis ke detail aset
* Real-time

---

## 4.4 Stock Opname

### Fitur

* Scan QR → langsung tampil data
* Update status:

  * Ada
  * Hilang
  * Rusak
* Simpan riwayat
* One-click action (cepat)

---

## 4.5 Mutasi Aset

### Fitur

* Pindah lokasi
* Riwayat mutasi
* Tracking perubahan aset

---

## 4.6 Dashboard

### Fitur

* Total aset
* Grafik kondisi
* Aset per KIB
* Aktivitas terbaru

---

## 4.7 Laporan

### Fitur

* Export PDF
* Export Excel
* Filter berdasarkan:

  * KIB
  * Tahun
  * Lokasi

---

# 5. 🎨 UI / UX DESIGN SYSTEM

---

## 5.1 Prinsip Desain

* Modern & profesional
* Compact (tidak boros ruang)
* Konsisten
* Mudah digunakan
* Mobile-friendly

---

## 5.2 Layout Utama

* Sidebar kiri (collapsible)
* Topbar
* Content area

---

## 5.3 Komponen UI

Menggunakan:

* Card
* Table
* Modal
* Button
* Input
* Notification

---

## 5.4 UX Rules

* Maksimal 3 klik ke fitur utama
* Form tidak panjang
* Feedback cepat
* Loading ringan

---

# 6. 🧱 STRUKTUR DATABASE (FINAL)

---

## tabel_asets

* id
* kode_aset (unique)
* nama_aset
* kib_type (A-F)
* lokasi_id (FK)
* tahun_perolehan
* nilai
* kondisi
* qr_code
* latitude
* longitude
* created_at
* updated_at

---

## tabel_lokasi

* id
* nama_lokasi
* kecamatan_id
* desa_id

---

## tabel_kib_a

* id
* aset_id
* luas
* status_tanah
* nomor_sertifikat

---

## tabel_kib_b

* id
* aset_id
* merk
* tipe
* nomor_seri
* tahun_pembelian

---

## tabel_kib_c

* id
* aset_id
* luas_bangunan
* alamat

---

## tabel_kib_d

* id
* aset_id
* panjang
* kondisi

---

## tabel_kib_e

* id
* aset_id
* jenis
* keterangan

---

## tabel_kib_f

* id
* aset_id
* progress
* nilai_kontrak
* vendor

---

## tabel_stock_opname

* id
* aset_id
* status
* tanggal
* keterangan

---

## tabel_mutasi_aset

* id
* aset_id
* lokasi_lama
* lokasi_baru
* tanggal

---

# 7. ⚙️ ARSITEKTUR SISTEM

---

## Backend

* Laravel 12
* Service Layer
* Eloquent ORM
* Validation Request

## Frontend

* Blade
* BladewindUI

## Library

* QR Code: simplesoftwareio/simple-qrcode
* Excel: maatwebsite/excel
* PDF: dompdf
* Scanner: html5-qrcode

---

# 8. 🔄 FLOW SISTEM

---

## Input Aset

1. Isi form
2. Simpan
3. QR otomatis dibuat
4. Tampil detail

---

## Scan QR

1. Buka halaman scan
2. Scan
3. Redirect ke detail

---

## Stock Opname

1. Scan QR
2. Klik status
3. Data tersimpan

---

# 9. ⚡ NON-FUNCTIONAL REQUIREMENTS

* Response < 2 detik
* Aman (CSRF, validation)
* Tidak ada N+1 query
* Mobile responsive
* Maintainable code

---

# 10. 📊 KPI (INDIKATOR KEBERHASILAN)

* 100% aset terdigitalisasi
* Pengurangan waktu stock opname > 50%
* Data real-time

---

# 11. 📅 ROADMAP IMPLEMENTASI

---

## Sprint 1

* Setup Laravel
* Auth
* Master lokasi

## Sprint 2

* CRUD aset
* Relasi KIB

## Sprint 3

* QR Code
* Detail aset

## Sprint 4

* Scan QR
* Stock opname

## Sprint 5

* Dashboard
* Laporan

---

# 12. ⚠️ RISIKO & MITIGASI

| Risiko              | Solusi       |
| ------------------- | ------------ |
| Data tidak valid    | Validasi     |
| QR rusak            | Regenerate   |
| User tidak terbiasa | UI sederhana |

---

# 13. 🏆 NILAI AKTUALISASI LATSAR

* Berorientasi pelayanan publik
* Akuntabilitas
* Kompeten (digitalisasi)
* Adaptif
* Kolaboratif

---

# 14. ✅ KESIMPULAN

Aplikasi ini merupakan solusi digital yang:

* Modern dan profesional
* Efisien dan cepat
* Transparan
* Mudah digunakan

Sangat relevan untuk mendukung peningkatan kinerja ASN dan pengelolaan aset daerah berbasis teknologi.

---
