<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Satuan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $permission_for_super_admin = Permission::all()->except(
            Permission::where('name', 'View Admin Lembaga')->first()->id
        );

        tap(Role::create(['name' => 'Super Admin', 'guard_name' => 'web']))->syncPermissions($permission_for_super_admin);
        tap(Role::create(['name' => 'Admin SKPD', 'guard_name' => 'web']))->syncPermissions([
            'View Any User',
            'Create User',
            'Update User',
            'Delete User',
            'View Any Lembaga',
            'View Lembaga',
            'View Any Permohonan',
            'Check Permohonan',
            'View Any Nphd',
        ]);
        tap(Role::create(['name' => 'Verifikator', 'guard_name' => 'web']))->syncPermissions([
            'View Any Permohonan',
            'Confirm Review Permohonan',
            'Confirm Perbaikan Permohonan',
        ]);
        tap(Role::create(['name' => 'Reviewer', 'guard_name' => 'web']))->syncPermissions([
            'View Any Permohonan',
            'Review Permohonan',
            'Send Permohonan',
            'Review Permohonan',
            'Reviewed Permohonan',
            'Reviewed Permohonan',
            'View Any Nphd',
            'Review Nphd',
        ]);
        tap(Role::create(['name' => 'Admin Lembaga', 'guard_name' => 'web']))->syncPermissions([
            'View Admin Lembaga',
            'Create Lembaga',
            'Update Lembaga',
            'View Any Permohonan',
            'Create Permohonan',
            'View Dukung Permohonan',
            'View Rab Permohonan',
            'Check Permohonan',
            'Send Permohonan',
            'Download Pemberitahuan Koreksi',
            'Revision Permohonan',
            'Revised Permohonan',
            'View Any Nphd',
            'View Nphd',
        ]);
        
        // contoh user superadmin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('@zaq123qwerty'),
            'id_role' => 1,
        ])->assignRole('Super Admin');
    
        $data = [
            ['name' => 'Ampul'], ['name' => 'Bal'], ['name' => 'Batang'], ['name' => 'Biji'],
            ['name' => 'Bungkus'], ['name' => 'Buah'], ['name' => 'Butir'], ['name' => 'Botol'],
            ['name' => 'Cm'], ['name' => 'Crt'], ['name' => 'Dos'], ['name' => 'Dus'],
            ['name' => 'Ekor'], ['name' => 'Ex'], ['name' => 'Galon'], ['name' => 'Gulung'],
            ['name' => 'Gram'], ['name' => 'Hektar'], ['name' => 'Ikat'], ['name' => 'Inchi'],
            ['name' => 'Kaleng'], ['name' => 'Karung'], ['name' => 'Keping'], ['name' => 'Kg'],
            ['name' => 'Koli'], ['name' => 'Kotak'], ['name' => 'Kubik'], ['name' => 'Kuintal'],
            ['name' => 'Lembar'], ['name' => 'Liter'], ['name' => 'Los'], ['name' => 'Lusin'],
            ['name' => 'M2'], ['name' => 'M3'], ['name' => 'Mg'], ['name' => 'Ml'],
            ['name' => 'Mtr'], ['name' => 'Ons'], ['name' => 'Paket'], ['name' => 'Pcs'],
            ['name' => 'Peti'], ['name' => 'Pot'], ['name' => 'Pound'], ['name' => 'Rim'],
            ['name' => 'Roll'], ['name' => 'Sachet'], ['name' => 'Sak'], ['name' => 'Set'],
            ['name' => 'Slop'], ['name' => 'Tablet']
        ];

        foreach ($data as $item) {
            Satuan::create($item);
        }
    }
}
