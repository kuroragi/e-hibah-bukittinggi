# Dokumentasi Widget Tambahan Dashboard E-Hibah Bukittinggi

## 📋 Overview
Dokumen ini menjelaskan widget tambahan yang telah diimplementasikan untuk melengkapi dashboard sistem e-hibah Bukittinggi. Widget-widget ini menyediakan informasi lebih komprehensif tentang aktivitas sistem, performa lembaga, dan progress anggaran.

---

## 🎯 Widget yang Diimplementasikan

### 1. Recent Activity Widget
**Tujuan**: Menampilkan 5 aktivitas terbaru terkait pencairan dana hibah
**Lokasi**: Row ke-4, kolom kiri (6/12 grid)

#### Fitur:
- Menampilkan aktivitas terbaru dengan informasi:
  - Nama lembaga
  - Jenis aktivitas (diajukan, diverifikasi, disetujui, ditolak, dicairkan)
  - Jumlah dana
  - Waktu aktivitas (format relatif)
- Badge berwarna sesuai status aktivitas
- Filter berdasarkan role user
- Update real-time timestamp

#### Warna Status:
- **Warning** (kuning): Diajukan
- **Info** (biru): Diverifikasi
- **Primary** (biru tua): Disetujui
- **Danger** (merah): Ditolak
- **Success** (hijau): Dicairkan

### 2. Top Lembaga Widget
**Tujuan**: Menampilkan 5 lembaga teratas berdasarkan total anggaran
**Lokasi**: Row ke-4, kolom kanan (6/12 grid)

#### Fitur:
- Ranking lembaga dengan badge khusus:
  - Rank 1: Crown icon (emas)
  - Rank 2: Badge silver
  - Rank 3: Badge bronze
  - Rank 4-5: Badge putih
- Menampilkan total permohonan dan total anggaran
- Filter berdasarkan role user

### 3. Budget Progress Widget
**Tujuan**: Menampilkan progress realisasi anggaran tahun berjalan
**Lokasi**: Row ke-5, full width (12/12 grid)

#### Fitur:
- Progress bar visual dengan persentase
- Breakdown anggaran:
  - Total anggaran
  - Total realisasi
  - Sisa anggaran
- Filter berdasarkan tahun APBD aktif
- Filter berdasarkan role user

---

## 🔧 Implementasi Teknis

### Backend (MainController.php)

#### Method getRecentActivity()
```php
private function getRecentActivity()
{
    $user = Auth::user();
    
    $query = Pencairan::with(['permohonan.lembaga', 'verifier', 'approver'])
                      ->orderBy('updated_at', 'desc')
                      ->limit(5);
    
    // Role-based filtering
    if ($user->hasRole('Admin Lembaga')) {
        $query->whereHas('permohonan', function($q) use ($user) {
            $q->where('id_lembaga', $user->id_lembaga);
        });
    } elseif ($user->hasRole('Reviewer') || $user->hasRole('Admin SKPD')) {
        $query->whereHas('permohonan', function($q) use ($user) {
            $q->where('id_skpd', $user->id_skpd);
        });
    }
    
    return $query->get()->map(function($pencairan) {
        // Format data untuk view
    });
}
```

#### Method getTopLembaga()
```php
private function getTopLembaga()
{
    $query = Permohonan::with('lembaga')
                      ->selectRaw('id_lembaga, COUNT(*) as total_permohonan, SUM(nominal_anggaran) as total_anggaran')
                      ->groupBy('id_lembaga')
                      ->orderBy('total_anggaran', 'desc')
                      ->limit(5);
    
    // Role-based filtering
    // Return formatted data
}
```

#### Method getBudgetProgress()
```php
private function getBudgetProgress()
{
    $currentYear = date('Y');
    $totalAnggaran = // Query total anggaran
    $totalRealisasi = // Query total realisasi
    $percentage = ($totalRealisasi / $totalAnggaran) * 100;
    
    return [
        'total_anggaran' => $totalAnggaran,
        'total_realisasi' => $totalRealisasi,
        'sisa_anggaran' => $totalAnggaran - $totalRealisasi,
        'percentage' => round($percentage, 1),
        'year' => $currentYear
    ];
}
```

### Frontend (dashboard.blade.php)

#### Structure:
```html
<!-- Row 4: Recent Activity & Top Lembaga -->
<div class="row">
    <div class="col-md-6"><!-- Recent Activity Widget --></div>
    <div class="col-md-6"><!-- Top Lembaga Widget --></div>
</div>

<!-- Row 5: Budget Progress -->
<div class="row mt-4">
    <div class="col-12"><!-- Budget Progress Widget --></div>
</div>
```

---

## 🎨 Styling & Design

### CSS Classes yang Digunakan:
- **Bootstrap 5**: Grid system, cards, badges, progress bars
- **FontAwesome**: Icons untuk visual enhancement
- **Custom CSS**: Height matching, color variations

### Responsive Design:
- **Desktop**: 2 kolom untuk widget aktivitas dan top lembaga
- **Mobile**: Stack vertikal untuk semua widget
- **Tablet**: Adaptive layout dengan responsive breakpoints

### Color Scheme:
- **Primary**: #007bff (biru)
- **Success**: #28a745 (hijau)
- **Warning**: #ffc107 (kuning)
- **Danger**: #dc3545 (merah)
- **Info**: #17a2b8 (biru muda)

---

## 🔐 Role-Based Access Control

### Admin Super
- Melihat semua data dari seluruh lembaga dan SKPD
- Akses penuh ke semua widget

### Admin SKPD
- Melihat data lembaga di bawah SKPD-nya
- Widget menampilkan data sesuai scope SKPD

### Reviewer
- Melihat data sesuai dengan SKPD yang ditugaskan
- Widget menampilkan data untuk review

### Admin Lembaga
- Hanya melihat data lembaganya sendiri
- Widget menampilkan aktivitas dan progress lembaga

---

## 📊 Data Sources

### Tables yang Digunakan:
1. **pencairan**: Data pencairan dana
2. **permohonan**: Data permohonan hibah
3. **lembaga**: Master data lembaga
4. **users**: Data pengguna untuk role filtering

### Relationships:
- Pencairan -> Permohonan (id_permohonan)
- Permohonan -> Lembaga (id_lembaga)
- Users -> Lembaga/SKPD (role-based)

---

## ⚡ Performance Considerations

### Optimasi Query:
- Eager loading dengan `with()` untuk menghindari N+1 problem
- Limit hasil untuk widget (5 items max)
- Efficient aggregation dengan `selectRaw()`

### Caching Strategy:
- Real-time data tanpa cache untuk akurasi
- Possible future: Redis cache dengan TTL singkat untuk high-traffic

### Database Indexes:
- Index pada kolom `updated_at` untuk sorting
- Index pada `id_lembaga` dan `id_skpd` untuk filtering
- Composite index untuk query kompleks

---

## 🚀 Future Enhancements

### Possible Improvements:
1. **Ajax Refresh**: Auto-refresh widget tanpa reload halaman
2. **Export Function**: Export data widget ke Excel/PDF
3. **Filter Options**: Dropdown filter periode waktu
4. **Animation**: Smooth transitions dan loading states
5. **Notification**: Real-time notification untuk aktivitas baru

### Additional Widgets Ideas:
1. **Approval Timeline**: Visualisasi timeline persetujuan
2. **Regional Distribution**: Peta distribusi hibah per wilayah
3. **Monthly Trends**: Trend bulanan pencairan dana
4. **User Activity Log**: Log aktivitas pengguna sistem

---

## 🐛 Troubleshooting

### Common Issues:

#### Widget Tidak Muncul:
1. Clear cache: `php artisan cache:clear`
2. Check role permissions
3. Verify data exists in database

#### Data Tidak Sesuai:
1. Check role-based filtering logic
2. Verify relationships antar tabel
3. Check data integrity

#### Performance Issues:
1. Monitor query execution time
2. Check database indexes
3. Consider query optimization

---

## 📝 Changelog

### Version 1.0.0 (Current)
- ✅ Recent Activity Widget
- ✅ Top Lembaga Widget  
- ✅ Budget Progress Widget
- ✅ Role-based data filtering
- ✅ Responsive design implementation
- ✅ Bootstrap 5 integration

### Planned Updates:
- 🔄 Ajax refresh functionality
- 🔄 Advanced filtering options
- 🔄 Export capabilities
- 🔄 Performance optimizations

---

## 👥 Developer Notes

### Code Maintenance:
- Follow Laravel best practices
- Maintain consistent naming conventions
- Document any custom methods
- Use type hints and return types
- Keep controller methods focused and single-purpose

### Testing Recommendations:
- Unit tests untuk method calculations
- Feature tests untuk widget display
- Performance tests untuk query optimization
- Role-based access tests

---

**Last Updated**: December 2024
**Developer**: GitHub Copilot Assistant
**Framework**: Laravel 11 + Bootstrap 5