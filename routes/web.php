<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\UserController;
use App\Livewire\Permohonan\CreateOrUpdate;
use App\Livewire\Lembagas\IndexLembaga;
use App\Livewire\Permohonan\IsiPendukung;
use App\Livewire\SKPD;
use App\Livewire\User;
use App\Models\Lembaga;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role as ModelsRole;

Route::get('/', [AuthController::class, 'Authenticate'])->name('login');
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [MainController::class, 'dasboard'])->name('dashboard');
    Route::get('/permission', [MainController::class, 'permission'])->name('permission');
    Route::get('/role', [MainController::class, 'role'])->name('role');
    Route::get('/skpd', SKPD::class)->name('skpd');
    Route::get('/user', User::class)->name('user.index');
    Route::get('/user-create', [UserController::class, 'create'])->name('user.create');
    Route::get('/lembaga', [LembagaController::class, 'index'])->name('lembaga');
    Route::get('/lembaga/uncreate', [LembagaController::class, 'uncreate'])->name('lembaga.uncreate');
    Route::get('/lembaga/show', [LembagaController::class, 'show'])->name('lembaga.show');
    Route::post('/lembaga/store', [LembagaController::class, 'store'])->name('lembaga.store');
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan');
    Route::get('/permohonan/create', CreateOrUpdate::class)->name('permohonan.create');
    Route::get('/permohonan/show/{id_permohonan}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('/permhonan/isi_pendukung/{id_permohonan}', IsiPendukung::class)->name('permohonan.isi_pendukung');
    Route::get('/permhonan/isi_rab/{id_permohonan}', IsiPendukung::class)->name('permohonan.isi_rab');
});


// Route::get('/testing', function () {
//     $user = auth()->user();

//     if (!$user) {
//         return 'Tidak ada user yang login.';
//     }

//     return [
//         'user_id'       => $user->id,
//         'roles'         => $user->getRoleNames(),       // daftar role
//         'permissions'   => $user->getAllPermissions()->pluck('name'), // daftar permission
//         'has_role_admin' => $user->hasRole('Admin Lembaga'),    // cek role admin
//         'can_check_permohonan'  => $user->can('view_dukung', App\Models\Status_permohonan::class),   // cek permission view users
//     ];
// })->middleware('auth');