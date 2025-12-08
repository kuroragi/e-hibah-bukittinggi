<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });

        $permissions = [
            // User
            ['name' => 'View Any User', 'guard_name' => 'web'],
            ['name' => 'View User', 'guard_name' => 'web'],
            ['name' => 'Create User', 'guard_name' => 'web'],
            ['name' => 'Update User', 'guard_name' => 'web'],
            ['name' => 'Delete User', 'guard_name' => 'web'],
            ['name' => 'Restore User', 'guard_name' => 'web'],

            // Role
            ['name' => 'View Any Role', 'guard_name' => 'web'],
            ['name' => 'View Role', 'guard_name' => 'web'],
            ['name' => 'Create Role', 'guard_name' => 'web'],
            ['name' => 'Update Role', 'guard_name' => 'web'],
            ['name' => 'Delete Role', 'guard_name' => 'web'],
            ['name' => 'Restore Role', 'guard_name' => 'web'],

            // Permission
            ['name' => 'View Any Permission', 'guard_name' => 'web'],
            ['name' => 'Create Permission', 'guard_name' => 'web'],
            ['name' => 'Update Permission', 'guard_name' => 'web'],
            ['name' => 'Delete Permission', 'guard_name' => 'web'],
            ['name' => 'Restore Permission', 'guard_name' => 'web'],

            // Lembaga
            ['name' => 'View Any Lembaga', 'guard_name' => 'web'],
            ['name' => 'View Admin Lembaga', 'guard_name' => 'web'],
            ['name' => 'View Lembaga', 'guard_name' => 'web'],
            ['name' => 'Create Lembaga', 'guard_name' => 'web'],
            ['name' => 'Update Lembaga', 'guard_name' => 'web'],
            ['name' => 'Delete Lembaga', 'guard_name' => 'web'],
            ['name' => 'Restore Lembaga', 'guard_name' => 'web'],

            // Permohonan
            ['name' => 'View Any Permohonan', 'guard_name' => 'web'],
            ['name' => 'View Permohonan', 'guard_name' => 'web'],
            ['name' => 'Create Permohonan', 'guard_name' => 'web'],
            ['name' => 'Update Permohonan', 'guard_name' => 'web'],
            ['name' => 'Delete Permohonan', 'guard_name' => 'web'],
            ['name' => 'Restore Permohonan', 'guard_name' => 'web'],
            ['name' => 'View Dukung Permohonan', 'guard_name' => 'web'],
            ['name' => 'View Rab Permohonan', 'guard_name' => 'web'],
            ['name' => 'Check Permohonan', 'guard_name' => 'web'],
            ['name' => 'Send Permohonan', 'guard_name' => 'web'],
            ['name' => 'Review Permohonan', 'guard_name' => 'web'],
            ['name' => 'Reviewed Permohonan', 'guard_name' => 'web'],
            ['name' => 'Confirm Permohonan', 'guard_name' => 'web'],
            ['name' => 'Upload Rab Permohonan', 'guard_name' => 'web'],
            ['name' => 'Download Pemberitahuan Koreksi', 'guard_name' => 'web'],
            ['name' => 'Revision Permohonan', 'guard_name' => 'web'],
            ['name' => 'Confirm Review Permohonan', 'guard_name' => 'web'],
            ['name' => 'Revised Permohonan', 'guard_name' => 'web'],
            ['name' => 'Review Perbaikan Permohonan', 'guard_name' => 'web'],
            ['name' => 'Confirm Perbaikan Permohonan', 'guard_name' => 'web'],

            // Pencairan
            ['name' => 'View Any Pencairan', 'guard_name' => 'web'],
            ['name' => 'View Pencairan', 'guard_name' => 'web'],
            ['name' => 'Create Pencairan', 'guard_name' => 'web'],
            ['name' => 'Verify Pencairan', 'guard_name' => 'web'],
            ['name' => 'Approve Pencairan', 'guard_name' => 'web'],
            ['name' => 'Update Pencairan', 'guard_name' => 'web'],
            ['name' => 'Delete Pencairan', 'guard_name' => 'web'],
            ['name' => 'Restore Pencairan', 'guard_name' => 'web'],
            
            //NPHD
            ['name' => 'View Any Nphd', 'guard_name' => 'web'],
            ['name' => 'View Nphd', 'guard_name' => 'web'],
            ['name' => 'Review Nphd', 'guard_name' => 'web'],

            // Skpd
            ['name' => 'View Any Skpd', 'guard_name' => 'web'],
            ['name' => 'View Skpd', 'guard_name' => 'web'],
            ['name' => 'Create Skpd', 'guard_name' => 'web'],
            ['name' => 'Update Skpd', 'guard_name' => 'web'],
            ['name' => 'Delete Skpd', 'guard_name' => 'web'],
            ['name' => 'Restore Skpd', 'guard_name' => 'web'],

            // Pertanyaan
            ['name' => 'View Any Pertanyaan', 'guard_name' => 'web'],
            ['name' => 'View Pertanyaan', 'guard_name' => 'web'],
            ['name' => 'Create Pertanyaan', 'guard_name' => 'web'],
            ['name' => 'Update Pertanyaan', 'guard_name' => 'web'],
            ['name' => 'Delete Pertanyaan', 'guard_name' => 'web'],
            ['name' => 'Restore Pertanyaan', 'guard_name' => 'web'],
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->truncate();
    }
};
