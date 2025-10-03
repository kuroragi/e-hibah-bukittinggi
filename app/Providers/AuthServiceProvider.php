<?php

namespace App\Providers;

use App\Models\Lembaga;
use App\Models\Permission;
use App\Models\Permohonan;
use App\Models\PertanyaanKelengkapan;
use App\Models\Role;
use App\Models\Skpd;
use App\Models\User;
use App\Policies\LembagaPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PermohonanPolicy;
use App\Policies\PertanyaanPolicy;
use App\Policies\RolePolicy;
use App\Policies\SkpdPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Lembaga::class => LembagaPolicy::class,
        Permission::class => PermissionPolicy::class,
        Permohonan::class => PermohonanPolicy::class,
        PertanyaanKelengkapan::class => PertanyaanPolicy::class,
        Role::class => RolePolicy::class,
        Skpd::class => SkpdPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Gate::before(function ($user, $ability) {
        //         return $user->has_role('Super Admin') ? true : null;
        // });
    }
}
