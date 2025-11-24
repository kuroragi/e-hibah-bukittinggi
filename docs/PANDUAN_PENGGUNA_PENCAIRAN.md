# Panduan Pengguna - Modul Pencairan Dana Hibah

## Daftar Isi
1. [Pengantar](#pengantar)
2. [Alur Kerja Pencairan](#alur-kerja-pencairan)
3. [Panduan untuk Admin Lembaga](#panduan-untuk-admin-lembaga)
4. [Panduan untuk Reviewer](#panduan-untuk-reviewer)
5. [Panduan untuk Admin SKPD](#panduan-untuk-admin-skpd)
6. [FAQ](#faq)

---

## Pengantar

Modul Pencairan Dana Hibah adalah sistem yang memungkinkan lembaga penerima hibah untuk mengajukan pencairan dana secara bertahap dan terstruktur. Sistem ini memiliki 3 tahap pencairan:

- **Tahap 1 (Down Payment)**: Pencairan awal untuk memulai kegiatan
- **Tahap 2 (Progress Payment)**: Pencairan untuk melanjutkan kegiatan
- **Tahap 3 (Final Payment)**: Pencairan akhir setelah kegiatan selesai

### Status Pencairan

1. **Diajukan** - Pengajuan baru dari lembaga
2. **Diverifikasi** - Sudah diverifikasi oleh Reviewer
3. **Disetujui** - Sudah disetujui oleh Admin SKPD
4. **Ditolak** - Ditolak oleh Reviewer atau Admin SKPD
5. **Dicairkan** - Dana sudah dicairkan oleh Bendahara

---

## Alur Kerja Pencairan

```
┌─────────────────┐
│ Admin Lembaga   │
│ Ajukan Pencairan│
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Reviewer      │
│   Verifikasi    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Admin SKPD    │
│    Approval     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Bendahara     │
│   Pencairan     │
└─────────────────┘
```

---

## Panduan untuk Admin Lembaga

### 1. Mengakses Menu Pencairan

1. Login ke sistem dengan akun Admin Lembaga
2. Klik menu **"Pencairan"** di sidebar
3. Anda akan melihat daftar pencairan yang pernah diajukan

### 2. Mengajukan Pencairan Baru

**Persyaratan:**
- Permohonan hibah sudah disetujui (status: NPHD Diterbitkan)
- Dokumen pendukung sudah lengkap

**Langkah-langkah:**

1. **Buka Halaman Permohonan**
   - Klik menu **"Permohonan"**
   - Pilih permohonan yang ingin diajukan pencairannya
   - Klik tombol **"Detail"**

2. **Pilih Tahap Pencairan**
   - Di halaman detail permohonan, klik tombol **"Ajukan Pencairan"**
   - Pilih tahap pencairan (1, 2, atau 3)

3. **Isi Form Pengajuan**
   
   a. **Data Pencairan:**
   - Tanggal Pencairan: Pilih tanggal pengajuan
   - Jumlah Pencairan: Masukkan nominal yang diajukan (maksimal sisa dana)
   - Keterangan: Isi keterangan tambahan (opsional)

   b. **Upload Dokumen Wajib:**
   - **Laporan Pertanggungjawaban (LPJ)** - Format: PDF, Max: 2MB
     > Berisi laporan pertanggungjawaban penggunaan dana hibah
   
   - **Laporan Realisasi Kegiatan** - Format: PDF, Max: 2MB
     > Berisi laporan realisasi kegiatan yang telah dilaksanakan
   
   - **Dokumentasi Kegiatan** - Format: PDF/ZIP/RAR, Max: 5MB
     > Berisi foto-foto kegiatan yang telah dilaksanakan
   
   - **Kwitansi/Bukti Pengeluaran** - Format: PDF, Max: 2MB
     > Berisi kwitansi dan bukti-bukti pengeluaran dana

4. **Submit Pengajuan**
   - Periksa kembali semua data yang diisi
   - Klik tombol **"Ajukan Pencairan"**
   - Tunggu notifikasi sukses
   - Sistem akan redirect ke halaman detail permohonan

### 3. Memantau Status Pencairan

1. **Melihat Daftar Pencairan:**
   - Klik menu **"Pencairan"**
   - Lihat status setiap pengajuan:
     - 🟡 **Kuning (Diajukan)**: Menunggu verifikasi
     - 🔵 **Biru (Diverifikasi)**: Menunggu approval
     - 🟢 **Hijau (Disetujui)**: Menunggu pencairan
     - 🔴 **Merah (Ditolak)**: Pengajuan ditolak
     - 🟢 **Hijau (Dicairkan)**: Dana sudah dicairkan

2. **Melihat Detail Pencairan:**
   - Klik tombol **"Lihat Detail"** (ikon mata)
   - Anda akan melihat:
     - Timeline status pencairan
     - Detail dokumen yang diupload
     - Catatan verifikasi (jika sudah diverifikasi)
     - Catatan approval (jika sudah diapprove)
     - Riwayat pencairan permohonan

### 4. Mengatasi Pengajuan Ditolak

Jika pengajuan ditolak:

1. **Baca Catatan Penolakan**
   - Buka detail pencairan yang ditolak
   - Baca catatan verifikasi/approval
   - Identifikasi alasan penolakan

2. **Perbaiki Dokumen**
   - Perbaiki dokumen sesuai catatan penolakan
   - Pastikan semua persyaratan terpenuhi

3. **Ajukan Ulang**
   - Buat pengajuan pencairan baru
   - Upload dokumen yang sudah diperbaiki
   - Submit kembali

### Tips untuk Admin Lembaga

✅ **Do:**
- Siapkan semua dokumen sebelum mengajukan
- Pastikan nominal yang diajukan sesuai dengan realisasi
- Upload dokumen dengan kualitas yang baik (jelas dan terbaca)
- Isi keterangan dengan lengkap
- Periksa sisa dana sebelum mengajukan

❌ **Don't:**
- Mengajukan pencairan melebihi sisa dana
- Upload dokumen yang tidak lengkap atau tidak jelas
- Mengajukan pencairan tanpa ada kegiatan yang dilaksanakan
- Upload file yang rusak atau tidak bisa dibuka

---

## Panduan untuk Reviewer

### 1. Mengakses Daftar Pencairan

1. Login sebagai **Reviewer**
2. Klik menu **"Pencairan"**
3. Filter pencairan dengan status **"Diajukan"**

### 2. Memverifikasi Pengajuan

**Langkah-langkah:**

1. **Buka Detail Pencairan**
   - Klik tombol **"Verifikasi"** (ikon checklist) pada pencairan yang akan diverifikasi
   - Anda akan melihat halaman detail verifikasi

2. **Periksa Informasi Lembaga**
   - Nama lembaga
   - Ketua lembaga
   - Kontak (email & HP)

3. **Periksa Informasi Permohonan**
   - Perihal permohonan
   - Total anggaran
   - Tahun anggaran

4. **Periksa Detail Pencairan**
   - Tahap pencairan (1, 2, atau 3)
   - Tanggal pengajuan
   - Jumlah pencairan
   - Keterangan (jika ada)

5. **Review Dokumen Pendukung**
   
   Download dan periksa setiap dokumen:
   
   a. **Laporan Pertanggungjawaban (LPJ)**
   - ✅ Apakah format laporan sesuai?
   - ✅ Apakah isi laporan lengkap?
   - ✅ Apakah ada tanda tangan pimpinan lembaga?
   
   b. **Laporan Realisasi Kegiatan**
   - ✅ Apakah kegiatan sesuai dengan proposal?
   - ✅ Apakah realisasi sesuai dengan rencana?
   - ✅ Apakah ada bukti pelaksanaan kegiatan?
   
   c. **Dokumentasi Kegiatan**
   - ✅ Apakah foto-foto jelas?
   - ✅ Apakah dokumentasi menunjukkan kegiatan yang dilaksanakan?
   - ✅ Apakah ada spanduk/banner yang menunjukkan kegiatan hibah?
   
   d. **Kwitansi/Bukti Pengeluaran**
   - ✅ Apakah kwitansi lengkap?
   - ✅ Apakah nominal sesuai dengan yang diajukan?
   - ✅ Apakah ada tanda tangan dan cap?

6. **Buat Keputusan**
   
   **Pilihan A: Terima & Lanjutkan ke Approval**
   - Pilih radio button **"Terima & Lanjutkan ke Approval"**
   - Isi catatan verifikasi (contoh):
     ```
     Dokumen lengkap dan sesuai. LPJ sudah mencakup semua item kegiatan.
     Realisasi sesuai dengan proposal. Dokumentasi lengkap dan jelas.
     Kwitansi sudah lengkap dengan tanda tangan dan cap lembaga.
     Direkomendasikan untuk dilanjutkan ke approval.
     ```
   
   **Pilihan B: Tolak Pengajuan**
   - Pilih radio button **"Tolak Pengajuan"**
   - Isi catatan verifikasi dengan alasan jelas (contoh):
     ```
     Pengajuan ditolak dengan alasan:
     1. Laporan realisasi tidak sesuai dengan kegiatan dalam proposal
     2. Dokumentasi kegiatan kurang lengkap (tidak ada foto kegiatan utama)
     3. Kwitansi tidak lengkap (ada item yang tidak ada kwitansinya)
     
     Mohon untuk melengkapi dokumen dan mengajukan kembali.
     ```

7. **Simpan Verifikasi**
   - Klik tombol **"Simpan Verifikasi"**
   - Sistem akan menyimpan keputusan Anda
   - Jika disetujui, pencairan akan masuk ke antrian approval
   - Jika ditolak, lembaga bisa melihat catatan dan mengajukan ulang

### Checklist Verifikasi

**Dokumen:**
- [ ] LPJ lengkap dan sesuai format
- [ ] Laporan realisasi sesuai proposal
- [ ] Dokumentasi lengkap dan jelas
- [ ] Kwitansi lengkap dan sah

**Kelengkapan:**
- [ ] Tanda tangan pimpinan lembaga ada
- [ ] Cap lembaga ada
- [ ] Nomor dokumen jelas
- [ ] Tanggal dokumen sesuai

**Kesesuaian:**
- [ ] Kegiatan sesuai proposal
- [ ] Nominal sesuai RAB
- [ ] Waktu pelaksanaan sesuai jadwal
- [ ] Tidak ada penyalahgunaan dana

### Tips untuk Reviewer

✅ **Do:**
- Periksa dokumen dengan teliti dan objektif
- Berikan catatan yang jelas dan spesifik
- Verifikasi keaslian dokumen
- Cek kesesuaian dengan proposal awal
- Komunikasi dengan lembaga jika ada yang kurang jelas

❌ **Don't:**
- Memverifikasi tanpa memeriksa semua dokumen
- Memberikan catatan yang tidak jelas atau terlalu umum
- Menerima dokumen yang tidak lengkap
- Terpengaruh oleh hubungan personal

---

## Panduan untuk Admin SKPD

### 1. Mengakses Pencairan untuk Approval

1. Login sebagai **Admin SKPD** atau **Super Admin**
2. Klik menu **"Pencairan"**
3. Filter dengan status **"Diverifikasi"**

### 2. Melakukan Approval

**Langkah-langkah:**

1. **Buka Halaman Approval**
   - Klik tombol **"Approval"** (ikon double-check) pada pencairan yang akan diapprove
   - Anda akan melihat halaman detail approval

2. **Review Informasi Lengkap**
   
   a. **Informasi Lembaga**
   - Nama lembaga dan ketua
   - Kontak (email & HP)
   - **Rekening bank** (pastikan benar)
   - **Nama pemilik rekening** (pastikan sesuai)

   b. **Informasi Permohonan**
   - Perihal dan total anggaran
   - Tahun anggaran
   
   c. **Detail Pencairan**
   - Tahap, tanggal, jumlah
   - Keterangan

3. **Review Hasil Verifikasi**
   - Lihat siapa yang memverifikasi
   - Baca catatan verifikasi
   - Pastikan verifikasi sudah sesuai

4. **Review Dokumen**
   - Download dan periksa ulang semua dokumen
   - Fokus pada kesesuaian nominal dengan realisasi
   - Cek keabsahan dokumen

5. **Cek Riwayat Pencairan Lembaga**
   - Lihat sidebar kanan "Riwayat Pencairan Lembaga"
   - Periksa apakah lembaga punya track record yang baik
   - Identifikasi jika ada masalah di pencairan sebelumnya

6. **Buat Keputusan Approval**
   
   **Pilihan A: Setujui & Proses Pencairan**
   - Pilih radio button **"Setujui & Proses Pencairan"**
   - Isi catatan approval (contoh):
     ```
     Pengajuan disetujui untuk diproses pencairan dengan pertimbangan:
     1. Dokumen sudah lengkap dan terverifikasi
     2. Realisasi sesuai dengan rencana
     3. Rekening bank sudah terverifikasi
     4. Lembaga memiliki track record pencairan yang baik
     5. Anggaran tersedia
     
     Selanjutnya dapat diproses oleh Bendahara untuk pencairan dana.
     ```
   
   **Pilihan B: Tolak Pencairan**
   - Pilih radio button **"Tolak Pencairan"**
   - Isi catatan approval dengan alasan objektif (contoh):
     ```
     Pengajuan ditolak dengan pertimbangan:
     1. Anggaran untuk program ini sudah habis
     2. Rekening bank tidak sesuai dengan data lembaga
     3. Ada temuan penyalahgunaan dana di pencairan sebelumnya
     4. Realisasi kegiatan tidak sesuai dengan yang direncanakan
     
     Mohon untuk melakukan perbaikan dan koordinasi dengan SKPD.
     ```

7. **Simpan Approval**
   - Klik tombol **"Simpan Approval"**
   - Sistem akan menyimpan keputusan
   - Jika disetujui, pencairan masuk antrian Bendahara
   - Jika ditolak, lembaga bisa melihat catatan

### Checklist Approval

**Administratif:**
- [ ] Hasil verifikasi sudah ada dan valid
- [ ] Semua dokumen sudah dicek ulang
- [ ] Rekening bank sudah diverifikasi
- [ ] Nama rekening sesuai dengan lembaga

**Keuangan:**
- [ ] Anggaran tersedia
- [ ] Nominal sesuai dengan realisasi
- [ ] Tidak ada pencairan ganda
- [ ] Tidak melebihi total anggaran

**Track Record:**
- [ ] Lembaga tidak bermasalah
- [ ] Pencairan sebelumnya lancar
- [ ] Tidak ada temuan audit negatif
- [ ] Reputasi lembaga baik

**Legalitas:**
- [ ] Dokumen sah dan valid
- [ ] Tanda tangan berwenang
- [ ] Cap lembaga asli
- [ ] Sesuai dengan aturan hibah

### Tips untuk Admin SKPD

✅ **Do:**
- Periksa rekening bank dengan teliti
- Validasi ketersediaan anggaran
- Koordinasi dengan Bendahara
- Cek track record lembaga
- Buat keputusan yang objektif dan terukur

❌ **Don't:**
- Menyetujui tanpa cek anggaran
- Mengabaikan hasil verifikasi
- Tidak cek rekening bank
- Terburu-buru dalam membuat keputusan
- Terpengaruh oleh tekanan eksternal

---

## FAQ (Frequently Asked Questions)

### Untuk Admin Lembaga

**Q: Berapa kali saya bisa mengajukan pencairan?**
A: Maksimal 3 kali sesuai dengan tahap pencairan (Tahap 1, 2, dan 3).

**Q: Apakah saya harus mengajukan semua tahap?**
A: Tidak wajib. Anda bisa mengajukan sesuai kebutuhan dan realisasi kegiatan.

**Q: Bagaimana jika pengajuan ditolak?**
A: Anda bisa melihat catatan penolakan, perbaiki dokumen, lalu ajukan ulang.

**Q: Berapa lama proses persetujuan?**
A: Tergantung waktu verifikasi dan approval. Biasanya 3-7 hari kerja.

**Q: Apakah bisa mengajukan pencairan melebihi total anggaran?**
A: Tidak bisa. Sistem akan membatasi maksimal pencairan sesuai sisa dana.

**Q: Dokumen apa yang paling penting?**
A: Semua dokumen penting, tapi LPJ dan Kwitansi adalah dokumen utama yang wajib lengkap.

### Untuk Reviewer

**Q: Apa yang harus saya perhatikan saat verifikasi?**
A: Kelengkapan dokumen, kesesuaian dengan proposal, keabsahan dokumen, dan kewajaran nominal.

**Q: Bolehkah saya menghubungi lembaga untuk klarifikasi?**
A: Boleh, bahkan dianjurkan jika ada hal yang kurang jelas.

**Q: Berapa lama batas waktu verifikasi?**
A: Sebaiknya 2-3 hari kerja setelah pengajuan masuk.

**Q: Apa yang harus dilakukan jika dokumen mencurigakan?**
A: Tolak pengajuan dan buat catatan detail. Laporkan ke Admin SKPD jika perlu investigasi lebih lanjut.

### Untuk Admin SKPD

**Q: Apa perbedaan antara verifikasi dan approval?**
A: Verifikasi fokus pada kelengkapan dan kesesuaian dokumen. Approval fokus pada ketersediaan anggaran dan kelayakan pencairan.

**Q: Bolehkah saya menolak meskipun sudah diverifikasi?**
A: Boleh, jika ada pertimbangan khusus seperti anggaran tidak tersedia atau ditemukan masalah.

**Q: Bagaimana koordinasi dengan Bendahara?**
A: Setelah approval, Bendahara akan menerima notifikasi dan bisa proses pencairan melalui sistem.

**Q: Apakah saya bertanggung jawab atas pencairan yang disetujui?**
A: Ya, Admin SKPD bertanggung jawab atas keputusan approval. Pastikan semua sudah sesuai prosedur.

---

## Kontak & Bantuan

Jika mengalami kendala dalam menggunakan sistem:

1. **Admin Lembaga**: Hubungi SKPD terkait atau Admin SKPD
2. **Reviewer**: Hubungi Admin SKPD
3. **Admin SKPD**: Hubungi Tim IT atau Super Admin

**Tim Support:**
- Email: support@hibah-bukittinggi.go.id
- Telepon: (0752) 1234567
- WhatsApp: 0812-3456-7890

**Jam Kerja Support:**
- Senin - Jumat: 08:00 - 16:00 WIB
- Sabtu: 08:00 - 12:00 WIB

---

*Dokumen ini terakhir diperbarui: {{ date('d F Y') }}*
*Versi: 1.0.0*
