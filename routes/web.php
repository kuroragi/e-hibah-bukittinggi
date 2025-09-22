<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NphdContoller;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\UserController;
use App\Livewire\Lembaga\Pendukung;
use App\Livewire\Lembaga\Pengurus;
use App\Livewire\Lembaga\Profile;
use App\Livewire\Permohonan\CreateOrUpdate;
use App\Livewire\Lembagas\IndexLembaga;
use App\Livewire\Pages\UserGuide;
use App\Livewire\Permission;
use App\Livewire\Permohonan\EditPermohonan;
use App\Livewire\Permohonan\IsiPendukung;
use App\Livewire\Permohonan\IsiRab;
use App\Livewire\Permohonan\Perbaikan;
use App\Livewire\Permohonan\Review;
use App\Livewire\Permohonan\ReviewPerbaikan;
use App\Livewire\PertanyaanKelengkapan;
use App\Livewire\Role;
use App\Livewire\SKPD;
use App\Livewire\User;
use App\Livewire\User\ChangePassword;
use App\Models\Bank;
use App\Models\Lembaga;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::get('/forgot_password', [AuthController::class, 'forgot_password'])->name('auth.forgot_password');
Route::post('/reset_password', [AuthController::class, 'reset_password'])->name('auth.reset_password');

Route::middleware(['auth'])->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [MainController::class, 'dasboard'])->name('dashboard');
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/role', Role::class)->name('role');
    Route::get('/skpd', SKPD::class)->name('skpd');
    Route::get('/user', User::class)->name('user.index');
    Route::get('/user/change_password', ChangePassword::class)->name('user.change_password');
    Route::get('/user-create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user_reset_password/{id_user}', [UserController::class, 'reset_password'])->name('user.reset_password');
    Route::get('/pertanyaan', PertanyaanKelengkapan::class)->name('pertanyaan');
    Route::get('/user_guide', UserGuide::class)->name('user_guide');
    Route::get('/lembaga', [LembagaController::class, 'index'])->name('lembaga');
    // Route::get('/lembaga/create', [LembagaController::class, 'create'])->name('lembaga.create');
    Route::get('/lembaga/create', App\Livewire\Lembaga\Create::class)->name('lembaga.create');
    Route::get('/lembaga/admin/{id_lembaga}', [LembagaController::class, 'admin'])->name('lembaga.admin');
    Route::post('/lembaga/store', [LembagaController::class, 'store'])->name('lembaga.store');
    Route::get('/lembaga/update/profile/{id_lembaga}', Profile::class)->name('lembaga.update.profile');
    Route::get('/lembaga/update/pendukung/{id_lembaga}', Pendukung::class)->name('lembaga.update.pendukung');
    Route::get('/lembaga/update/pengurus/{id_lembaga}', Pengurus::class)->name('lembaga.update.pengurus');
    Route::get('/lembaga/show/{id_lembaga}', [LembagaController::class, 'show'])->name('lembaga.show');
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan');
    Route::get('/permohonan/create', CreateOrUpdate::class)->name('permohonan.create');
    Route::get('/permohonan/edit/{id_permohonan}', EditPermohonan::class)->name('permohonan.edit');
    Route::get('/permohonan/show/{id_permohonan}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('/permhonan/isi_pendukung/{id_permohonan}', IsiPendukung::class)->name('permohonan.isi_pendukung');
    Route::get('/permohonan/isi_rab/{id_permohonan}', IsiRab::class)->name('permohonan.isi_rab');
    Route::get('/permohonan/send/{id_permohonan}', [PermohonanController::class, 'send'])->name('permohonan.send');
    Route::get('/permohonan/review/{id_permohonan}', Review::class)->name('permohonan.review');
    Route::get('/permohonan/edit_review/{id_permohonan}', Review::class)->name('permohonan.edit_review');
    Route::get('/permohonan/send_review/{id_permohonan}', [PermohonanController::class, 'send_review'])->name('permohonan.send_review');
    Route::get('/permohonan/confirm_review/{id_permohonan}', Review::class)->name('permohonan.confirm_review');
    Route::get('/permohonan/peberitahuan/download/{id_permohonan}', [PermohonanController::class, 'donwload_pemberitahuan'])->name('permohonan.pemberitahuan.download');
    Route::get('/permohonan/revisi/{id_permohonan}', Perbaikan::class)->name('permohonan.revisi');
    Route::get('/permohonan/send_revisi/{id_permohonan}', [PermohonanController::class, 'send_revisi'])->name('permohonan.send_revisi');
    Route::get('/permohonan/review_revisi/{id_permohonan}', ReviewPerbaikan::class)->name('permohonan.review_revisi');
    Route::get('/permohonan/confirm_revisi/{id_permohonan}', ReviewPerbaikan::class)->name('permohonan.confirm_revisi');

    Route::get('/nphd', [NphdContoller::class, 'index'])->name('nphd');
    Route::get('/nphd/show/{id_permohonan}', \App\Livewire\Nphd\Show::class)->name('nphd.show');
    Route::get('/nphd/review/{id_permohonan}', \App\Livewire\Nphd\Review::class)->name('nphd.review');

    Route::get('/pencairan', [PermohonanController::class, 'pencairan'])->name('pencairan');
    Route::post('/pencairan/upload_nphd', [PermohonanController::class, 'uploadNphd'])->name('pencairan.upload_nphd');
    Route::get('/pencairan/data_pendukung/{id_permohonan}', [PermohonanController::class, 'cekPendukung'])->name('pencairan.data_pendukung');

});


// Route::get('/testing-pdf', function(){
//     $data = Permohonan::with(['lembaga' => function($query){
//         $query->with(['skpd', 'urusan', 'pengurus' => function($query){
//             $query->where('jabatan', 'Pimpinan');
//         }]);
//     }])->where('id', 3)->first();
//     $pimpinan_lembaga = $data->lembaga?->pengurus->first();
//     $kegiatan_rab = [];
//     $kegiatans = RabPermohonan::with(['rincian.satuan'])->where('id_permohonan', 3)->get();
//             if($kegiatans){
//                 $grand = 0;
//                 foreach ($kegiatans as $k1 => $item) {
//                     foreach ($item->rincian as $k2 => $child) {
//                         $grand += $child->subtotal;
//                     }
//                 }
//                 $total_kegiatan = $grand;
//             }
//             foreach ($kegiatans as $k1 => $item) {
//                 $kegiatan_rab[$k1] = [
//                     'id_kegiatan' => $item->id,
//                     'nama_kegiatan' => $item->nama_kegiatan,
//                     'total_kegiatan' => 0
//                 ];
//                 foreach($item->rincian as $k2 => $child){
//                     $kegiatan_rab[$k1]['rincian'][$k2] = [
//                         'id_rincian' => $child->id,
//                         'kegiatan' => $child->keterangan,
//                         'volume' => $child->volume,
//                         'satuan' => $child->id_satuan,
//                         'harga_satuan' => $child->harga,
//                         'subtotal' => $child->subtotal,
//                     ];
//                 }
//             }
//     return view('pdf.nphd', [
//         'data' => $data,
//         'pimpinan_lembaga' => $pimpinan_lembaga,
//         'kegiatans' => $kegiatans,
//         'nominal_rab' => 5000000,
//     ]);
// });

// Route::get('/testing', function () {
//     $user = auth()->user();

//     if (!$user) {
//         return 'Tidak ada user yang login.';
//     }

//     return [
//         'user_id'       => $user->id,
//         'roles'         => $user->getRoleNames(),       // daftar role
//         'permissions'   => $user->getAllPermissions()->pluck('name'), // daftar permission
//         'can_view_nphd'  => $user->can('viewNphd', App\Models\Permohonan::class),   // cek permission view users
//     ];
// })->middleware('auth');

// Route::get('/test-email', function () {
//     \Illuminate\Support\Facades\Mail::raw('Test email SMTP Gmail', function ($message) {
//         $message->to('s.uum1612@gmail.com')->subject('SMTP Gmail Test');
//     });
//     return 'Email terkirim!';
// });