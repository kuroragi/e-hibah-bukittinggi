<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Permohonan;
use App\Models\Status_permohonan;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\KabKota;
use App\Models\Propinsi;
use App\Models\Bank;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ManualTestingSeeder extends Seeder
{
    public function run(): void
    {
        echo "🌱 Starting Manual Testing Data Seeding...\n\n";

        // Create Propinsi
        echo "Creating Propinsi...\n";
        $propinsi = Propinsi::firstOrCreate(
            ['id' => '13'],
            ['name' => 'Sumatera Barat']
        );

        // Create Kab/Kota
        echo "Creating Kab/Kota...\n";
        $kabkota = KabKota::firstOrCreate(
            ['id' => '1375'],
            ['propinsi_id' => $propinsi->id, 'name' => 'Kota Bukittinggi']
        );

        // Create Kecamatan
        echo "Creating Kecamatan...\n";
        $kecamatan = Kecamatan::firstOrCreate(
            ['name' => 'Guguk Panjang'],
            ['kab_kota_id' => $kabkota->id]
        );

        // Create Kelurahan
        echo "Creating Kelurahan...\n";
        $kelurahan = Kelurahan::firstOrCreate(
            ['name' => 'Puhun Pintu Kabun'],
            ['kecamatan_id' => $kecamatan->id]
        );

        // Create Banks
        echo "Creating Banks...\n";
        $banks = ['BRI', 'BNI', 'Mandiri', 'BCA', 'Bank Nagari'];
        foreach ($banks as $bankName) {
            Bank::firstOrCreate(['name' => $bankName]);
        }

        // Create SKPDs
        echo "Creating SKPDs...\n";
        $skpds = [
            ['type' => 'Dinas', 'name' => 'Dinas Pendidikan', 'email' => 'disdik@bukittinggikota.go.id'],
            ['type' => 'Dinas', 'name' => 'Dinas Kesehatan', 'email' => 'dinkes@bukittinggikota.go.id'],
            ['type' => 'Dinas', 'name' => 'Dinas Sosial', 'email' => 'dinsos@bukittinggikota.go.id'],
            ['type' => 'Badan', 'name' => 'Badan Perencanaan Pembangunan Daerah', 'email' => 'bappeda@bukittinggikota.go.id'],
        ];

        $createdSkpds = [];
        foreach ($skpds as $skpdData) {
            $skpd = Skpd::firstOrCreate(
                ['name' => $skpdData['name']],
                $skpdData
            );
            $createdSkpds[] = $skpd;
            
            // Create Urusan for each SKPD
            UrusanSkpd::firstOrCreate(
                ['skpd_id' => $skpd->id, 'name' => 'Urusan ' . $skpdData['name']],
                ['kepala_urusan' => 'Kepala Urusan ' . $skpdData['name']]
            );
        }

        // Create Status Permohonan
        echo "Creating Status Permohonan...\n";
        $statuses = [
            'Draft',
            'Diajukan',
            'Dalam Review',
            'Perlu Perbaikan',
            'Disetujui',
            'Ditolak',
            'NPHD Generated',
            'NPHD Signed',
            'Proses Pencairan',
            'Selesai',
        ];

        foreach ($statuses as $status) {
            Status_permohonan::firstOrCreate(['name' => $status]);
        }

        // Ensure roles exist
        echo "Creating Roles...\n";
        $roles = ['Super Admin', 'Admin SKPD', 'Reviewer', 'Admin Lembaga'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create permissions
        echo "Creating Permissions...\n";
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view lembaga', 'create lembaga', 'edit lembaga', 'delete lembaga',
            'view skpd', 'create skpd', 'edit skpd', 'delete skpd',
            'view permohonan', 'create permohonan', 'edit permohonan', 'delete permohonan',
            'review permohonan', 'approve permohonan', 'reject permohonan',
            'view nphd', 'create nphd', 'edit nphd',
            'view pencairan', 'approve pencairan',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName]);
        }

        // Assign permissions to roles
        echo "Assigning Permissions to Roles...\n";
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->givePermissionTo(Permission::all());

        $adminSkpd = Role::where('name', 'Admin SKPD')->first();
        $adminSkpd->givePermissionTo([
            'view permohonan', 'review permohonan', 'approve permohonan', 'reject permohonan',
            'view nphd', 'create nphd', 'edit nphd',
            'view pencairan', 'approve pencairan',
        ]);

        // Ensure Super Admin user exists
        echo "Ensuring Super Admin user exists...\n";
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@bukittinggikota.go.id'],
            [
                'name' => 'Admin Utama',
                'password' => bcrypt('password'),
            ]
        );
        
        if (!$superAdminUser->hasRole('Super Admin')) {
            $superAdminUser->assignRole('Super Admin');
        }

        // Create Admin SKPD users
        echo "Creating Admin SKPD users...\n";
        foreach ($createdSkpds as $index => $skpd) {
            $email = 'admin.skpd' . ($index + 1) . '@bukittinggikota.go.id';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . $skpd->name,
                    'password' => bcrypt('password'),
                    'skpd_id' => $skpd->id,
                ]
            );
            
            if (!$user->hasRole('Admin SKPD')) {
                $user->assignRole('Admin SKPD');
            }
        }

        // Create sample Lembaga with Factory
        echo "Creating Sample Lembagas...\n";
        if (Lembaga::count() < 3) {
            Lembaga::factory()->count(3)->create([
                'skpd_id' => $createdSkpds[0]->id,
                'urusan_id' => UrusanSkpd::where('skpd_id', $createdSkpds[0]->id)->first()->id,
                'kelurahan_id' => $kelurahan->id,
            ]);
        }

        // Create Admin Lembaga users
        echo "Creating Admin Lembaga users...\n";
        $lembagas = Lembaga::take(3)->get();
        foreach ($lembagas as $index => $lembaga) {
            $email = 'admin.lembaga' . ($index + 1) . '@example.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . $lembaga->name,
                    'password' => bcrypt('password'),
                    'lembaga_id' => $lembaga->id,
                ]
            );
            
            if (!$user->hasRole('Admin Lembaga')) {
                $user->assignRole('Admin Lembaga');
            }
        }

        // Create sample Permohonan
        echo "Creating Sample Permohonans...\n";
        if (Permohonan::count() < 5) {
            $draftStatus = Status_permohonan::where('name', 'Draft')->first();
            $diajukanStatus = Status_permohonan::where('name', 'Diajukan')->first();
            
            foreach ($lembagas as $lembaga) {
                Permohonan::factory()->create([
                    'lembaga_id' => $lembaga->id,
                    'skpd_id' => $lembaga->skpd_id,
                    'urusan_id' => $lembaga->urusan_id,
                    'status_permohonan_id' => $draftStatus->id,
                ]);
                
                Permohonan::factory()->create([
                    'lembaga_id' => $lembaga->id,
                    'skpd_id' => $lembaga->skpd_id,
                    'urusan_id' => $lembaga->urusan_id,
                    'status_permohonan_id' => $diajukanStatus->id,
                ]);
            }
        }

        echo "\n✅ Manual Testing Data Seeding Completed!\n\n";
        
        echo "=== TEST USERS CREATED ===\n";
        echo "Super Admin:\n";
        echo "  Email: admin@bukittinggikota.go.id\n";
        echo "  Password: password\n\n";
        
        echo "Admin SKPD (example):\n";
        echo "  Email: admin.skpd1@bukittinggikota.go.id\n";
        echo "  Password: password\n\n";
        
        echo "Admin Lembaga (example):\n";
        echo "  Email: admin.lembaga1@example.com\n";
        echo "  Password: password\n\n";
        
        echo "=== STATISTICS ===\n";
        echo "Users: " . User::count() . "\n";
        echo "SKPDs: " . Skpd::count() . "\n";
        echo "Lembagas: " . Lembaga::count() . "\n";
        echo "Permohonans: " . Permohonan::count() . "\n";
        echo "Status: " . Status_permohonan::count() . "\n";
    }
}
