# 📘 DOKUMENTASI E-HIBAH BUKITTINGGI - BAGIAN 1
## OVERVIEW & ARSITEKTUR SISTEM

**Tanggal:** 24 November 2025  
**Versi:** 1.0  
**Framework:** Laravel 12.20.0  
**Branch:** tambah_test_unit  

---

## 📋 DAFTAR ISI BAGIAN 1

1. [Ringkasan Aplikasi](#ringkasan-aplikasi)
2. [Tujuan & Target Pengguna](#tujuan--target-pengguna)
3. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4. [Arsitektur Sistem](#arsitektur-sistem)
5. [Role & Hak Akses](#role--hak-akses)
6. [Struktur Database](#struktur-database)

---

## 🎯 RINGKASAN APLIKASI

**E-Hibah Bukittinggi** adalah sistem manajemen hibah daerah berbasis web yang dikembangkan untuk Pemerintah Kota Bukittinggi. Aplikasi ini mendigitalisasi seluruh proses pengajuan, review, persetujuan, dan pencairan hibah dari lembaga-lembaga ke SKPD (Satuan Kerja Perangkat Daerah).

### Masalah yang Diselesaikan:
- ❌ Proses manual yang memakan waktu
- ❌ Dokumen fisik yang mudah hilang
- ❌ Tracking status yang sulit
- ❌ Transparansi yang kurang
- ❌ Koordinasi antar instansi yang tidak efisien

### Solusi yang Ditawarkan:
- ✅ Digitalisasi proses end-to-end
- ✅ Document management system
- ✅ Real-time status tracking
- ✅ Transparansi penuh dengan activity log
- ✅ Integrasi sistem antar instansi
- ✅ Workflow otomatis dengan notifikasi email

---

## 🎯 TUJUAN & TARGET PENGGUNA

### Tujuan Aplikasi:
1. **Efisiensi Proses** - Mengurangi waktu proses dari bulan ke minggu
2. **Transparansi** - Semua proses tercatat dan dapat dilacak
3. **Akuntabilitas** - Activity logging untuk audit trail
4. **Kemudahan Akses** - Web-based, bisa diakses dari mana saja
5. **Paperless** - Mengurangi penggunaan kertas
6. **Integrasi Data** - Satu pintu untuk semua data hibah

### Target Pengguna:

#### 1. **Super Admin**
- Mengelola seluruh sistem
- Konfigurasi aplikasi
- Manage semua user dan permission
- Full access ke semua modul

#### 2. **Admin SKPD** 
- Mengelola permohonan di SKPD masing-masing
- Review dan verifikasi permohonan
- Generate NPHD dan surat-surat
- Manage data SKPD dan urusan

#### 3. **Reviewer/Verifikator**
- Review permohonan sesuai urusan
- Verifikasi kelengkapan dokumen
- Beri rekomendasi (setuju/perbaikan/tolak)
- Generate berita acara

#### 4. **Admin Lembaga**
- Mengajukan permohonan hibah
- Upload dokumen pendukung
- Melakukan perbaikan jika diminta
- Tracking status permohonan
- Upload dokumen pencairan

---

## 💻 TEKNOLOGI YANG DIGUNAKAN

### Backend Stack:
- **Framework:** Laravel 12.20.0 (PHP 8.2+)
- **Database:** MySQL 8.0+
- **ORM:** Eloquent
- **Authentication:** Laravel Sanctum + Spatie Permission
- **Testing:** PHPUnit 11.5.27

### Frontend Stack:
- **Template Engine:** Blade
- **CSS Framework:** Bootstrap 5
- **JavaScript:** Livewire 3.6 (untuk real-time components)
- **Icons:** Bootstrap Icons

### Additional Libraries:
- **PDF Generation:** DomPDF
- **Excel Import/Export:** Maatwebsite Excel
- **Email:** Laravel Mail dengan Queue
- **File Storage:** Laravel Storage (Local & Cloud ready)
- **Activity Logging:** Spatie Laravel Activitylog

### Development Tools:
- **Version Control:** Git
- **Package Manager:** Composer
- **Asset Bundler:** Vite
- **Code Quality:** PHPStan (static analysis)

---

## 🏗️ ARSITEKTUR SISTEM

### Layer Architecture:

```
┌─────────────────────────────────────────┐
│         PRESENTATION LAYER              │
│  (Views, Livewire Components, Assets)   │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│         APPLICATION LAYER               │
│   (Controllers, Middleware, Requests)   │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│          BUSINESS LOGIC LAYER           │
│      (Services, Helpers, Policies)      │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│           DATA ACCESS LAYER             │
│    (Models, Repositories, Eloquent)     │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│            DATABASE LAYER               │
│          (MySQL, Migrations)            │
└─────────────────────────────────────────┘
```

### Folder Structure:

```
e-hibah-bukittinggi/
├── app/
│   ├── Console/          # Artisan commands
│   ├── Facades/          # Custom facades
│   ├── Helpers/          # Helper functions
│   ├── Http/
│   │   ├── Controllers/  # HTTP controllers
│   │   └── Middleware/   # Custom middleware
│   ├── Imports/          # Excel imports
│   ├── Livewire/         # Livewire components
│   ├── Logging/          # Custom logging
│   ├── Mail/             # Email classes
│   ├── Models/           # Eloquent models
│   ├── Policies/         # Authorization policies
│   ├── Providers/        # Service providers
│   ├── Services/         # Business logic services
│   └── Traits/           # Reusable traits
├── bootstrap/            # Framework bootstrap
├── config/               # Configuration files
├── database/
│   ├── factories/        # Model factories
│   ├── migrations/       # Database migrations (65 files)
│   └── seeders/          # Database seeders
├── public/               # Public assets
│   ├── assets/           # CSS, JS, Images
│   └── storage/          # Symlink to storage
├── resources/
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript
│   └── views/            # Blade templates
├── routes/
│   ├── console.php       # Console routes
│   └── web.php           # Web routes
├── storage/              # File storage
│   ├── app/              # Application files
│   ├── framework/        # Framework files
│   └── logs/             # Application logs
├── tests/                # Automated tests
│   ├── Feature/          # Feature tests
│   └── Unit/             # Unit tests
└── vendor/               # Composer dependencies
```

---

## 👥 ROLE & HAK AKSES

### Role Hierarchy:

```
Super Admin (Level 0)
    ↓
Admin SKPD (Level 1)
    ↓
Reviewer/Verifikator (Level 2)
    ↓
Admin Lembaga (Level 3)
```

### Permission Matrix:

| Modul | Super Admin | Admin SKPD | Reviewer | Admin Lembaga |
|-------|------------|------------|----------|---------------|
| **User Management** | ✅ Full | ❌ No | ❌ No | ❌ No |
| **Role & Permission** | ✅ Full | ❌ No | ❌ No | ❌ No |
| **SKPD Management** | ✅ Full | ✅ Own SKPD | ❌ No | ❌ No |
| **Lembaga Management** | ✅ View All | ✅ View SKPD | ✅ View Urusan | ✅ Own Lembaga |
| **Permohonan - Create** | ✅ Yes | ❌ No | ❌ No | ✅ Yes |
| **Permohonan - Review** | ✅ All | ✅ SKPD | ✅ Urusan | ❌ No |
| **Permohonan - Approve** | ✅ Yes | ✅ SKPD | ✅ Urusan | ❌ No |
| **NPHD - Generate** | ✅ Yes | ✅ SKPD | ❌ No | ❌ No |
| **NPHD - Upload** | ✅ Yes | ✅ SKPD | ❌ No | ❌ No |
| **Pencairan - Process** | ✅ All | ✅ SKPD | ✅ Urusan | ❌ No |
| **Pencairan - Upload** | ❌ No | ❌ No | ❌ No | ✅ Yes |
| **Config - NPHD** | ✅ Yes | ❌ No | ❌ No | ❌ No |
| **Config - Pertanyaan** | ✅ Yes | ✅ Limited | ❌ No | ❌ No |
| **Activity Log** | ✅ View All | ✅ View SKPD | ✅ View Urusan | ✅ View Own |
| **User Guide** | ✅ Yes | ✅ Yes | ✅ Yes | ✅ Yes |

### Authentication & Authorization:

**Authentication Method:**
- Email & Password based authentication
- Session-based (with remember me option)
- Password reset via email

**Authorization Method:**
- Spatie Laravel Permission package
- Role-based access control (RBAC)
- Permission checking via Policies
- Middleware protection on routes

**Password Policy:**
- Minimum 8 characters
- Must contain uppercase letter
- Must contain lowercase letter
- Must contain number
- Must contain special character

---

## 🗄️ STRUKTUR DATABASE

### Total Migrations: **65 migrations**

### Database Tables (Grouped by Module):

#### **1. AUTHENTICATION & USER MANAGEMENT** (7 tables)
```
- users                          # User accounts
- password_reset_tokens          # Password resets
- sessions                       # User sessions
- permissions                    # Spatie permissions
- roles                          # Spatie roles
- model_has_permissions          # User permissions
- model_has_roles                # User roles
- role_has_permissions           # Role permissions
```

#### **2. LEMBAGA MODULE** (5 tables)
```
- lembagas                       # Lembaga data
- penguruses                     # Pengurus lembaga
- nphd_lembagas                  # NPHD lembaga
- banks                          # Master bank
- kelurahans                     # Master kelurahan
```

#### **3. SKPD MODULE** (3 tables)
```
- skpds                          # SKPD data
- skpd_details                   # Detail SKPD
- urusan_skpds                   # Urusan SKPD
```

#### **4. PERMOHONAN MODULE** (10 tables)
```
- permohonans                    # Permohonan hibah
- status_permohonans             # Master status
- pendukung_permohonans          # Data pendukung
- rab_permohonans                # RAB (Rencana Anggaran)
- satuans                        # Master satuan
- verifikasi_permohonans         # Verifikasi
- perbaikan_proposals            # Perbaikan proposal
- perbaikan_rabs                 # Perbaikan RAB
- berita_acaras                  # Berita acara
- kelengkapan_berita_acaras      # Kelengkapan BA
```

#### **5. NPHD MODULE** (4 tables)
```
- nphds                          # NPHD data
- nphd_configs                   # Config NPHD
- nphd_field_configs             # Field config
- nphd_field_values              # Field values
```

#### **6. PENCAIRAN MODULE** (1 table)
```
- pencairans                     # Data pencairan
```

#### **7. MASTER DATA** (7 tables)
```
- propinsis                      # Provinsi
- kab_kotas                      # Kabupaten/Kota
- kecamatans                     # Kecamatan
- kelurahans                     # Kelurahan
- pertanyaan_kelengkapans        # Pertanyaan checklist
- pertanyaan_perbaikans          # Pertanyaan perbaikan
- kelengkapan_perbaikans         # Kelengkapan perbaikan
```

#### **8. SYSTEM TABLES** (3 tables)
```
- user_logs                      # Activity logs
- cache                          # Cache storage
- cache_locks                    # Cache locks
- jobs                           # Queue jobs
- job_batches                    # Job batches
- failed_jobs                    # Failed jobs
```

### Key Relationships:

```
User ──┬── has one → Lembaga
       ├── belongs to → Role
       ├── belongs to → SKPD
       └── has many → UserLog

Lembaga ──┬── belongs to → SKPD
          ├── belongs to → UrusanSkpd
          ├── belongs to → Kelurahan
          ├── has many → Pengurus
          ├── has many → Permohonan
          └── has one → NphdLembaga

SKPD ──┬── has many → User
       ├── has many → Lembaga
       ├── has many → UrusanSkpd
       ├── has many → Permohonan
       └── has one → SkpdDetail

Permohonan ──┬── belongs to → Lembaga
             ├── belongs to → SKPD
             ├── belongs to → UrusanSkpd
             ├── belongs to → Status
             ├── has one → PendukungPermohonan
             ├── has many → RabPermohonan
             ├── has many → PerbaikanProposal
             ├── has many → PerbaikanRab
             ├── has one → Nphd
             └── has one → Pencairan

NPHD ──┬── belongs to → Permohonan
       ├── belongs to → NphdConfig
       └── has many → NphdFieldValue
```

### Database Status:

✅ **All 65 migrations have been successfully executed**  
✅ **Database schema is consistent**  
✅ **Foreign key constraints are properly set**  
✅ **Indexes are optimized for queries**

---

## 📊 STATISTIK KODE

```
Total Files:           ~500+ files
Total Lines of Code:   ~50,000+ lines
Total Models:          30+ models
Total Controllers:     15+ controllers
Total Livewire:        25+ components
Total Migrations:      65 migrations
Total Tests:           18+ test files
Total Factories:       11 factories
```

---

## 🔐 SECURITY MEASURES

1. **Authentication:**
   - Session-based authentication
   - Password hashing with bcrypt
   - CSRF protection on all forms
   - Remember me functionality

2. **Authorization:**
   - Role-based access control
   - Permission checking via policies
   - Middleware protection on routes
   - Gate checks in views

3. **Data Protection:**
   - Mass assignment protection
   - SQL injection prevention (Eloquent ORM)
   - XSS protection (Blade escaping)
   - File upload validation

4. **Audit Trail:**
   - Activity logging for all critical actions
   - User action tracking
   - Blameable trait (created_by, updated_by, deleted_by)
   - Soft deletes for data recovery

---

**DOKUMENTASI LANJUTAN:**
- [Bagian 2: Fitur & Workflow →](02_FITUR_DAN_WORKFLOW.md)
- [Bagian 3: Testing & Quality Assurance →](03_TESTING_DAN_QA.md)
- [Bagian 4: Deployment & Maintenance →](04_DEPLOYMENT_DAN_MAINTENANCE.md)
