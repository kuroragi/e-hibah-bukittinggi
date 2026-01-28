<?php

namespace Tests\Feature\Permohonan;

use App\Models\User;
use App\Models\Permohonan;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Status_permohonan;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role as SpatieRole;
use Tests\TestCase;

class PermohonanIndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create necessary roles
        SpatieRole::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'Admin SKPD', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'Admin Lembaga', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'Reviewer', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'Verifikator', 'guard_name' => 'web']);
    }

    protected function createPermohonan(array $attributes = []): Permohonan
    {
        $lembaga = Lembaga::factory()->create();
        $skpd = Skpd::factory()->create();
        $urusan = UrusanSkpd::factory()->create();
        $status = Status_permohonan::factory()->create();
        
        $defaultAttributes = [
            'id_lembaga' => $lembaga->id,
            'no_mohon' => '001/HIBAH/TEST/' . date('Y') . '/' . uniqid(),
            'tanggal_mohon' => now(),
            'tahun_apbd' => date('Y'),
            'perihal_mohon' => 'Perihal Test',
            'file_mohon' => 'test.pdf',
            'no_proposal' => '001/PROPOSAL/TEST/' . date('Y') . '/' . uniqid(),
            'tanggal_proposal' => now(),
            'title' => 'Test Permohonan',
            'urusan' => $urusan->id,
            'id_skpd' => $skpd->id,
            'awal_laksana' => now()->addMonth(),
            'akhir_laksana' => now()->addMonths(6),
            'latar_belakang' => 'Latar belakang test',
            'maksud_tujuan' => 'Maksud tujuan test',
            'keterangan' => 'Keterangan test',
            'file_proposal' => 'proposal.pdf',
            'nominal_rab' => 50000000,
            'nominal_anggaran' => 45000000,
            'id_status' => $status->id,
            'status_rekomendasi' => 0,
            'nominal_rekomendasi' => 0,
        ];
        
        return Permohonan::create(array_merge($defaultAttributes, $attributes));
    }

    /**
     * Test halaman permohonan tidak dapat diakses oleh guest
     */
    public function test_permohonan_index_requires_authentication(): void
    {
        $response = $this->get('/permohonan');

        $response->assertRedirect('/');
    }

    /**
     * Test Super Admin dapat melihat semua permohonan
     */
    public function test_super_admin_can_view_all_permohonan(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        // Create some permohonan with status 1-12
        $status1 = Status_permohonan::create(['name' => 'Draft', 'description' => 'Draft']);
        $this->createPermohonan(['id_status' => $status1->id]);
        $this->createPermohonan(['id_status' => $status1->id]);

        $response = $this->actingAs($user)->get('/permohonan');

        $response->assertStatus(200);
    }

    /**
     * Test Admin SKPD hanya dapat melihat permohonan di SKPD-nya
     */
    public function test_admin_skpd_can_view_own_skpd_permohonan(): void
    {
        $skpd = Skpd::factory()->create();
        
        $user = User::factory()->create([
            'id_skpd' => $skpd->id,
        ]);
        $user->assignRole('Admin SKPD');

        // Create status with id 1
        $status = Status_permohonan::create(['name' => 'Draft', 'description' => 'Draft']);
        
        // Create permohonan for this SKPD
        $lembaga = Lembaga::factory()->create(['id_skpd' => $skpd->id]);
        $urusan = UrusanSkpd::factory()->create();
        
        Permohonan::create([
            'id_lembaga' => $lembaga->id,
            'no_mohon' => '001/HIBAH/TEST/' . date('Y') . '/' . uniqid(),
            'tanggal_mohon' => now(),
            'tahun_apbd' => date('Y'),
            'perihal_mohon' => 'Perihal Test',
            'file_mohon' => 'test.pdf',
            'no_proposal' => '001/PROPOSAL/TEST/' . date('Y') . '/' . uniqid(),
            'tanggal_proposal' => now(),
            'title' => 'Test Permohonan SKPD',
            'urusan' => $urusan->id,
            'id_skpd' => $skpd->id,
            'awal_laksana' => now()->addMonth(),
            'akhir_laksana' => now()->addMonths(6),
            'latar_belakang' => 'Latar belakang test',
            'maksud_tujuan' => 'Maksud tujuan test',
            'keterangan' => 'Keterangan test',
            'file_proposal' => 'proposal.pdf',
            'nominal_rab' => 50000000,
            'nominal_anggaran' => 45000000,
            'id_status' => $status->id,
            'status_rekomendasi' => 0,
            'nominal_rekomendasi' => 0,
        ]);

        $response = $this->actingAs($user)->get('/permohonan');

        $response->assertStatus(200);
    }

    /**
     * Test Admin Lembaga hanya dapat melihat permohonan lembaga-nya
     */
    public function test_admin_lembaga_can_view_own_lembaga_permohonan(): void
    {
        $lembaga = Lembaga::factory()->create();
        
        $user = User::factory()->create([
            'id_lembaga' => $lembaga->id,
        ]);
        $user->assignRole('Admin Lembaga');

        // Create status with id 1
        $status = Status_permohonan::create(['name' => 'Draft', 'description' => 'Draft']);
        $skpd = Skpd::factory()->create();
        $urusan = UrusanSkpd::factory()->create();
        
        Permohonan::create([
            'id_lembaga' => $lembaga->id,
            'no_mohon' => '001/HIBAH/TEST/' . date('Y') . '/' . uniqid(),
            'tanggal_mohon' => now(),
            'tahun_apbd' => date('Y'),
            'perihal_mohon' => 'Perihal Test',
            'file_mohon' => 'test.pdf',
            'no_proposal' => '001/PROPOSAL/TEST/' . date('Y') . '/' . uniqid(),
            'tanggal_proposal' => now(),
            'title' => 'Test Permohonan Lembaga',
            'urusan' => $urusan->id,
            'id_skpd' => $skpd->id,
            'awal_laksana' => now()->addMonth(),
            'akhir_laksana' => now()->addMonths(6),
            'latar_belakang' => 'Latar belakang test',
            'maksud_tujuan' => 'Maksud tujuan test',
            'keterangan' => 'Keterangan test',
            'file_proposal' => 'proposal.pdf',
            'nominal_rab' => 50000000,
            'nominal_anggaran' => 45000000,
            'id_status' => $status->id,
            'status_rekomendasi' => 0,
            'nominal_rekomendasi' => 0,
        ]);

        $response = $this->actingAs($user)->get('/permohonan');

        $response->assertStatus(200);
    }
}
