# 📘 DOKUMENTASI E-HIBAH BUKITTINGGI - BAGIAN 2
## FITUR & WORKFLOW SISTEM

**Tanggal:** 24 November 2025  
**Versi:** 1.0  

---

## 📋 DAFTAR ISI BAGIAN 2

1. [Fitur Authentication](#fitur-authentication)
2. [Fitur User Management](#fitur-user-management)
3. [Fitur Lembaga Management](#fitur-lembaga-management)
4. [Fitur SKPD Management](#fitur-skpd-management)
5. [Fitur Permohonan Hibah](#fitur-permohonan-hibah)
6. [Fitur NPHD](#fitur-nphd)
7. [Fitur Pencairan](#fitur-pencairan)
8. [Workflow Lengkap](#workflow-lengkap)

---

## 🔐 FITUR AUTHENTICATION

### 1. Login
**Route:** `GET /` → `POST /authenticate`

**Fitur:**
- Email & password authentication
- Remember me checkbox
- Session management
- Redirect to dashboard after login

**Validasi:**
- Email format validation
- Password required
- Check credentials against database

**Flow:**
```
1. User masuk ke halaman login
2. Input email & password
3. Optional: centang "Remember Me"
4. Klik "Login"
5. Sistem validasi credentials
6. Jika valid → redirect ke /dashboard
7. Jika invalid → tampilkan error message
```

---

### 2. Forgot Password
**Route:** `GET /forgot_password` → `POST /reset_password`

**Fitur:**
- Reset password via email
- Generate random secure password
- Send new password via email queue

**Validasi:**
- Email harus terdaftar di sistem

**Flow:**
```
1. User klik "Lupa Password"
2. Input email
3. Sistem cek email di database
4. Generate password baru (10 karakter)
5. Update password di database
6. Kirim email berisi password baru
7. User login dengan password baru
8. Redirect ke change password
```

---

### 3. Change Password
**Route:** `GET /user/change_password`

**Fitur:**
- Change password setelah login
- Real-time password strength indicator
- Password validation rules

**Validasi:**
- Current password harus benar
- New password minimal 8 karakter
- Harus ada uppercase
- Harus ada lowercase
- Harus ada angka
- Harus ada special character
- Confirm password harus sama

**Flow:**
```
1. User ke menu Change Password
2. Input current password
3. Input new password
4. Lihat indicator kekuatan password
5. Confirm new password
6. Submit
7. Sistem validasi
8. Update password
9. Logout otomatis
10. Login dengan password baru
```

---

### 4. Logout
**Route:** `DELETE /logout`

**Fitur:**
- Logout dan clear session
- Invalidate session token
- Regenerate CSRF token

**Flow:**
```
1. User klik Logout
2. Sistem invalidate session
3. Clear cookies
4. Regenerate CSRF token
5. Redirect ke login page
```

---

## 👥 FITUR USER MANAGEMENT

### 1. User List
**Route:** `GET /user`

**Fitur:**
- List semua users (sesuai role)
- Filter by role, SKPD, status
- Search by name, email
- Pagination
- Sorting

**Tampilan Data:**
- Name
- Email
- Role
- SKPD/Lembaga
- Status (Active/Inactive)
- Last Login
- Actions (Edit, Delete, Reset Password)

---

### 2. Create User
**Route:** `GET /user-create`

**Fitur:**
- Form create user baru
- Auto-generate password
- Assign role
- Assign SKPD/Lembaga (conditional)

**Field Input:**
- Name (required)
- Email (required, unique)
- Password (auto-generate)
- Role (required)
- SKPD (jika role = Admin SKPD/Reviewer)
- Urusan (jika role = Reviewer)
- Lembaga (jika role = Admin Lembaga)

**Flow:**
```
1. Super Admin buka form create user
2. Isi data user
3. Pilih role
4. Jika Admin SKPD → pilih SKPD
5. Jika Reviewer → pilih SKPD + Urusan
6. Jika Admin Lembaga → pilih Lembaga
7. Password auto-generate
8. Submit
9. User created
10. Email notifikasi terkirim dengan password
```

---

### 3. Reset Password User
**Route:** `GET /user_reset_password/{id}`

**Fitur:**
- Reset password user lain (Super Admin only)
- Generate password baru
- Send via email

**Flow:**
```
1. Super Admin pilih user
2. Klik "Reset Password"
3. Konfirmasi
4. Generate password baru
5. Update database
6. Kirim email ke user
7. Success message
```

---

## 🏢 FITUR LEMBAGA MANAGEMENT

### 1. Registrasi Lembaga Baru
**Route:** `GET /lembaga/create`

**Fitur:**
- Form registrasi lembaga baru (Livewire component)
- Multi-step wizard
- Upload multiple documents
- Auto-create user admin lembaga

**Data yang Diinput:**

**Step 1: Data Umum**
- Nama Lembaga (required)
- Acronym/Singkatan (required)
- Email (required, unique)
- No. Telepon (required, numeric)
- SKPD Pembina (required)
- Urusan (required)
- Kelurahan (required)
- Alamat Lengkap (required)
- Upload Photo Lembaga (required, jpg/png, max 2MB)

**Step 2: Data Legalitas**
- NPWP (required, 15 digit)
- No. Akta Kumham (required)
- Tanggal Akta (required)
- Upload Akta Kumham (required, PDF, max 5MB)
- No. Surat Domisili (required)
- Tanggal Domisili (required)
- Upload Domisili (required, PDF, max 5MB)
- No. Izin Operasional (required)
- Tanggal Operasional (required)
- Upload Operasional (required, PDF, max 5MB)
- No. Surat Pernyataan (required)
- Tanggal Pernyataan (required)
- Upload Pernyataan (required, PDF, max 5MB)

**Step 3: Data Bank**
- Bank (optional)
- Atas Nama (optional)
- No. Rekening (optional)
- Upload Photo Rekening (optional, jpg/png, max 2MB)

**Flow:**
```
1. Admin Lembaga request akun
2. Super Admin approve & create lembaga
3. Fill Step 1 → Next
4. Fill Step 2 → Next
5. Fill Step 3 → Submit
6. Sistem validasi semua data
7. Upload semua file ke storage
8. Create lembaga record
9. Auto-create user dengan role "Admin Lembaga"
10. Send email credential ke email lembaga
11. Success → redirect ke lembaga list
```

---

### 2. Update Profile Lembaga
**Route:** `GET /lembaga/update/profile/{id}`

**Fitur:**
- Edit data umum lembaga
- Update photo lembaga
- Ubah SKPD/Urusan

**Field yang Bisa Diubah:**
- Nama Lembaga
- Acronym
- Email
- Phone
- Alamat
- Photo
- SKPD
- Urusan
- Kelurahan

---

### 3. Update Data Pendukung
**Route:** `GET /lembaga/update/pendukung/{id}`

**Fitur:**
- Edit data legalitas
- Re-upload dokumen

**Field yang Bisa Diubah:**
- NPWP
- Data Akta Kumham
- Data Domisili
- Data Operasional
- Data Pernyataan
- Data Bank & Rekening

---

### 4. Manage Pengurus
**Route:** `GET /lembaga/update/pengurus/{id}`

**Fitur:**
- CRUD pengurus lembaga
- Minimal 3 pengurus (Pimpinan, Sekretaris, Bendahara)
- Upload KTP masing-masing

**Data Pengurus:**
- Nama Lengkap (required, unique per lembaga)
- Jabatan (Pimpinan/Sekretaris/Bendahara)
- NIK (required, unique, 16 digit)
- No. HP (optional)
- Email (optional)
- Alamat (required)
- Upload Scan KTP (optional, jpg/png, max 2MB)

**Validasi:**
- Minimal ada 1 Pimpinan
- Minimal ada 1 Sekretaris
- Minimal ada 1 Bendahara
- NIK harus unique
- Nama harus unique dalam 1 lembaga

---

### 5. View Lembaga Detail
**Route:** `GET /lembaga/show/{id}`

**Fitur:**
- Lihat detail lengkap lembaga
- Download dokumen lembaga
- Lihat list permohonan lembaga
- Lihat history activity

**Section:**
1. Data Umum
2. Data Legalitas
3. Data Pengurus
4. Data Bank
5. List Permohonan
6. Activity Log

---

## 🏛️ FITUR SKPD MANAGEMENT

### 1. CRUD SKPD
**Route:** `GET /skpd`

**Fitur:**
- List semua SKPD
- Create new SKPD
- Update SKPD
- Delete SKPD (soft delete)
- Livewire component untuk real-time

**Data SKPD:**
- Type (Dinas/Badan)
- Nama SKPD (required, unique)
- Deskripsi (optional)
- Alamat (optional)
- Telepon (optional)
- Email (optional, unique)
- Fax (optional)

---

### 2. Detail SKPD
**Route:** `GET /skpd/detail/{id}`

**Fitur:**
- Input detail pejabat SKPD
- Data untuk TTD di surat-surat

**Data yang Diinput:**
- **Kepala Dinas:**
  - NIP
  - Nama
  - Jabatan
  - Pangkat/Golongan
  - Alamat
  - No. HP
  - Email
  - Upload TTD Digital (PNG transparan)

- **Bendahara:**
  - NIP
  - Nama
  - Jabatan
  - Pangkat/Golongan
  - Alamat
  - No. HP
  - Email

---

### 3. Manage Urusan SKPD
**Route:** Integrated in SKPD module

**Fitur:**
- CRUD urusan di bawah SKPD
- Assign kepala urusan
- Input kegiatan urusan (JSON format)

**Data Urusan:**
- Nama Urusan (required)
- Kepala Urusan (optional)
- Kegiatan (JSON, optional)

**Format Kegiatan:**
```json
{
  "kegiatan": [
    {
      "kode": "1.01.01",
      "nama": "Program Pendidikan Dasar",
      "pagu": 1000000000,
      "sub_kegiatan": [
        {
          "kode": "1.01.01.01",
          "nama": "Bantuan Operasional Sekolah",
          "rekening": "5.1.1.01"
        }
      ]
    }
  ]
}
```

---

## 📝 FITUR PERMOHONAN HIBAH (CORE FEATURE)

### WORKFLOW PERMOHONAN:

```
┌─────────────────────────────────────────────────────────────┐
│                    1. PENGAJUAN (LEMBAGA)                    │
├─────────────────────────────────────────────────────────────┤
│ a. Buat Permohonan → b. Isi Proposal → c. Isi Data         │
│    Pendukung → d. Isi RAB → e. Kirim Permohonan            │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                 2. REVIEW PERTAMA (SKPD/REVIEWER)            │
├─────────────────────────────────────────────────────────────┤
│ a. Terima Permohonan → b. Review Dokumen → c. Verifikasi   │
│    Kelengkapan → d. Beri Rekomendasi                        │
└─────────────────────────────────────────────────────────────┘
                            ↓
         ┌──────────────────┴──────────────────┐
         ↓                  ↓                   ↓
    DISETUJUI      PERLU PERBAIKAN           DITOLAK
         │                  │                   │
         │                  ↓                   ↓
         │      ┌───────────────────┐      [END PROCESS]
         │      │ 3. PERBAIKAN      │
         │      │    (LEMBAGA)      │
         │      ├───────────────────┤
         │      │ a. Lihat Catatan  │
         │      │ b. Perbaiki Data  │
         │      │ c. Upload Revisi  │
         │      └───────────────────┘
         │                  │
         │                  ↓
         │      ┌───────────────────┐
         │      │ 4. REVIEW REVISI  │
         │      │    (SKPD)         │
         │      ├───────────────────┤
         │      │ Check Perbaikan   │
         │      └───────────────────┘
         │                  │
         └──────────────────┘
                  ↓
     ┌────────────────────────┐
     │   5. GENERATE NPHD     │
     │      (SKPD)            │
     ├────────────────────────┤
     │ a. Config Template     │
     │ b. Generate PDF        │
     │ c. Download NPHD       │
     └────────────────────────┘
                  ↓
     ┌────────────────────────┐
     │  6. UPLOAD NPHD TTD    │
     │      (SKPD)            │
     ├────────────────────────┤
     │ Upload NPHD signed     │
     └────────────────────────┘
                  ↓
     ┌────────────────────────┐
     │  7. PROSES PENCAIRAN   │
     │      (LEMBAGA)         │
     ├────────────────────────┤
     │ a. Upload Dok Pencairan│
     │ b. Submit Request      │
     └────────────────────────┘
                  ↓
     ┌────────────────────────┐
     │ 8. VERIFIKASI PENCAIRAN│
     │      (SKPD)            │
     ├────────────────────────┤
     │ a. Check Dokumen       │
     │ b. Approve Pencairan   │
     └────────────────────────┘
                  ↓
            [SELESAI]
```

---

### 1. CREATE PERMOHONAN (Lembaga)
**Route:** `GET /permohonan/create`

**Step 1: Surat Permohonan**
- No. Surat Permohonan (required, unique)
- Tanggal Surat (required)
- Tahun APBD (required, auto from tanggal)
- Perihal Permohonan (required)
- Upload Surat Permohonan (required, PDF, max 5MB)

**Step 2: Proposal**
- No. Proposal (required, unique)
- Tanggal Proposal (required)
- Judul Program/Kegiatan (required)
- SKPD Tujuan (required, dropdown)
- Urusan (required, dropdown based on SKPD)
- Tanggal Mulai Pelaksanaan (required)
- Tanggal Selesai Pelaksanaan (required)
- Latar Belakang (required, textarea)
- Maksud & Tujuan (required, textarea)
- Keterangan (optional, textarea)
- Upload File Proposal (required, PDF, max 10MB)

**Flow Create:**
```
1. Admin Lembaga login
2. Menu Permohonan → Buat Baru
3. Isi Step 1 (Surat Permohonan) → Next
4. Isi Step 2 (Proposal) → Submit
5. Validasi data
6. Upload files ke storage
7. Create record permohonan (status = Draft)
8. Redirect ke Isi Data Pendukung
```

---

### 2. ISI DATA PENDUKUNG
**Route:** `GET /permohonan/isi_pendukung/{id}`

**Data yang Diinput:**
- Surat Pertanggungjawaban (PDF, max 5MB)
- Struktur Organisasi (PDF/Image, max 5MB)
- Saldo Akhir Rekening Bank (PDF/Image, max 5MB)
- File RAB (Excel/PDF, max 5MB)

**Flow:**
```
1. Lanjutan dari create permohonan
2. Upload 4 dokumen pendukung
3. Validasi format & size
4. Upload ke storage
5. Create/Update pendukung_permohonan record
6. Redirect ke Isi RAB
```

---

### 3. ISI RAB (Rencana Anggaran Biaya)
**Route:** `GET /permohonan/isi_rab/{id}`

**Fitur:**
- Input RAB multi-kegiatan
- Multi-item per kegiatan
- Auto-calculate subtotal & total
- Dynamic add/remove rows

**Structure:**
```
Kegiatan 1
├── Item 1.1 (Keterangan, Volume, Satuan, Harga) → Subtotal
├── Item 1.2
└── Item 1.3
    Total Kegiatan 1

Kegiatan 2
├── Item 2.1
└── Item 2.2
    Total Kegiatan 2

GRAND TOTAL
```

**Data per Item:**
- Keterangan/Uraian (required)
- Volume (required, numeric)
- Satuan (required, dropdown: pcs, unit, orang, hari, dll)
- Harga Satuan (required, numeric)
- Subtotal (auto-calculate: volume × harga)

**Flow:**
```
1. Input Nama Kegiatan
2. Add items:
   - Keterangan
   - Volume
   - Satuan
   - Harga Satuan
3. Auto-calculate subtotal per item
4. Auto-calculate total per kegiatan
5. Add kegiatan lain (optional)
6. View Grand Total
7. Submit
8. Validasi: total RAB ≤ nominal yang diminta
9. Save RAB
10. Update nominal_rab di permohonan
11. Redirect ke preview permohonan
```

---

### 4. KIRIM PERMOHONAN
**Route:** `GET /permohonan/send/{id}`

**Flow:**
```
1. Admin Lembaga review permohonan lengkap
2. Check kelengkapan:
   ✓ Surat Permohonan
   ✓ Proposal
   ✓ Data Pendukung (4 dokumen)
   ✓ RAB
3. Klik "Kirim Permohonan"
4. Konfirmasi
5. Update status → "Diajukan"
6. Send notification email ke SKPD
7. Activity log
8. Success message
```

---

### 5. REVIEW PERMOHONAN (SKPD/Reviewer)
**Route:** `GET /permohonan/review/{id}`

**Fitur:**
- View detail lengkap permohonan
- Download semua dokumen
- Checklist kelengkapan
- Input rekomendasi

**Checklist Kelengkapan:**
- [ ] Surat Permohonan lengkap & sesuai
- [ ] Proposal sesuai format & isi lengkap
- [ ] Latar belakang jelas
- [ ] RAB masuk akal & terinci
- [ ] Data pendukung lengkap
- [ ] NPWP valid
- [ ] Akta Kumham valid
- [ ] Surat pernyataan ada
- [ ] Bank account verified

**Input Rekomendasi:**
- Status Rekomendasi (required):
  * Disetujui
  * Perlu Perbaikan
  * Ditolak
- Nominal Rekomendasi (jika disetujui, required)
- Tanggal Rekomendasi (auto: today)
- Catatan Rekomendasi (required)

**Jika "Perlu Perbaikan":**
- Checklist bagian yang perlu diperbaiki:
  * [ ] Proposal
  * [ ] RAB
  * [ ] Data Pendukung
  * [ ] Legalitas
- Catatan detail per bagian

**Flow Review:**
```
1. Reviewer login
2. List permohonan masuk
3. Pilih permohonan
4. View detail lengkap
5. Download & check dokumen
6. Isi checklist kelengkapan
7. Pilih rekomendasi
8. Jika Disetujui:
   - Input nominal rekomendasi
   - Input catatan
9. Jika Perlu Perbaikan:
   - Checklist bagian yang salah
   - Input catatan per bagian
10. Jika Ditolak:
    - Input alasan detail
11. Submit
12. Update status permohonan
13. Generate surat pemberitahuan (PDF)
14. Send email notifikasi ke lembaga
15. Activity log
```

---

### 6. DOWNLOAD SURAT PEMBERITAHUAN
**Route:** `GET /permohonan/pemberitahuan/download/{id}`

**Fitur:**
- Generate PDF surat pemberitahuan
- Include nomor surat auto-generate
- Include data reviewer & SKPD
- Include rekomendasi & catatan

**Content Surat:**
```
KOP SURAT SKPD

Nomor    : [AUTO-GENERATE]
Tanggal  : [TODAY]
Lampiran : -
Perihal  : Pemberitahuan Hasil Review Permohonan Hibah

Kepada Yth.
[Nama Lembaga]
[Alamat Lembaga]

Dengan hormat,
Sehubungan dengan permohonan hibah yang Saudara ajukan 
dengan nomor: [NO_MOHON], tanggal: [TGL_MOHON],
perihal: [PERIHAL],

Setelah dilakukan review dan verifikasi, dengan ini 
kami sampaikan bahwa permohonan Saudara:

STATUS: [DISETUJUI/PERLU PERBAIKAN/DITOLAK]

[JIKA DISETUJUI]
Nominal yang direkomendasikan: Rp [NOMINAL]

[JIKA PERLU PERBAIKAN]
Bagian yang perlu diperbaiki:
1. [CATATAN 1]
2. [CATATAN 2]

Catatan: [CATATAN_DETAIL]

Demikian pemberitahuan ini kami sampaikan.

[KOTA], [TANGGAL]
[JABATAN]

[TTD DIGITAL]

[NAMA_REVIEWER]
NIP. [NIP_REVIEWER]
```

---

### 7. PERBAIKAN PERMOHONAN (Lembaga)
**Route:** `GET /permohonan/revisi/{id}`

**Fitur:**
- View catatan perbaikan dari reviewer
- Edit bagian yang diminta diperbaiki
- Upload dokumen revisi
- Re-submit

**Flow Perbaikan:**
```
1. Lembaga receive notifikasi perlu perbaikan
2. Login & buka permohonan
3. Lihat catatan reviewer
4. Jika Proposal perlu diperbaiki:
   - Edit proposal
   - Upload proposal baru
5. Jika RAB perlu diperbaiki:
   - Edit RAB
   - Adjust items
6. Jika Data Pendukung perlu update:
   - Upload dokumen baru
7. Submit revisi
8. Update status → "Dalam Perbaikan - Menunggu Review"
9. Send notification ke reviewer
```

---

### 8. REVIEW PERBAIKAN (SKPD)
**Route:** `GET /permohonan/review_revisi/{id}`

**Fitur:**
- View permohonan yang sudah diperbaiki
- Compare dengan versi sebelumnya
- Accept atau request perbaikan lagi

**Flow:**
```
1. Reviewer receive notifikasi revisi masuk
2. Buka permohonan revisi
3. Check perbaikan
4. Pilih:
   - Perbaikan Diterima → lanjut generate NPHD
   - Belum Sesuai → request perbaikan lagi
5. Submit
6. Update status
7. Notifikasi
```

---

**DOKUMENTASI LANJUTAN:**
- [← Bagian 1: Overview & Arsitektur](01_OVERVIEW_DAN_ARSITEKTUR.md)
- [Bagian 3: Testing & Quality Assurance →](03_TESTING_DAN_QA.md)
- [Bagian 4: Deployment & Maintenance →](04_DEPLOYMENT_DAN_MAINTENANCE.md)
