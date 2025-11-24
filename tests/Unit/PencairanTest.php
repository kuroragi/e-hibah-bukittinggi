<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pencairan;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PencairanTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_create_pencairan(): void
    {
        $permohonan = Permohonan::factory()->create();
        
        $pencairan = Pencairan::factory()->create([
            'id_permohonan' => $permohonan->id,
            'tahap_pencairan' => 1,
        ]);

        $this->assertDatabaseHas('pencairans', [
            'id' => $pencairan->id,
            'id_permohonan' => $permohonan->id,
            'tahap_pencairan' => 1,
        ]);
    }

    public function test_pencairan_belongs_to_permohonan(): void
    {
        $permohonan = Permohonan::factory()->create();
        $pencairan = Pencairan::factory()->create([
            'id_permohonan' => $permohonan->id,
        ]);

        $this->assertInstanceOf(Permohonan::class, $pencairan->permohonan);
        $this->assertEquals($permohonan->id, $pencairan->permohonan->id);
    }

    public function test_pencairan_can_be_verified(): void
    {
        $verifier = User::factory()->create();
        $pencairan = Pencairan::factory()->create(['status' => 'diajukan']);

        $pencairan->update([
            'status' => 'diverifikasi',
            'verified_by' => $verifier->id,
            'verified_at' => now(),
            'catatan_verifikasi' => 'Dokumen lengkap',
        ]);

        $this->assertEquals('diverifikasi', $pencairan->status);
        $this->assertEquals($verifier->id, $pencairan->verified_by);
        $this->assertNotNull($pencairan->verified_at);
    }

    public function test_pencairan_can_be_approved(): void
    {
        $approver = User::factory()->create();
        $pencairan = Pencairan::factory()->verified()->create();

        $pencairan->update([
            'status' => 'disetujui',
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'catatan_approval' => 'Disetujui untuk dicairkan',
        ]);

        $this->assertEquals('disetujui', $pencairan->status);
        $this->assertEquals($approver->id, $pencairan->approved_by);
        $this->assertNotNull($pencairan->approved_at);
    }

    public function test_pencairan_can_be_rejected(): void
    {
        $pencairan = Pencairan::factory()->create(['status' => 'diajukan']);

        $pencairan->update([
            'status' => 'ditolak',
            'catatan_verifikasi' => 'Dokumen tidak lengkap',
        ]);

        $this->assertEquals('ditolak', $pencairan->status);
    }

    public function test_pencairan_has_verifier_relationship(): void
    {
        $verifier = User::factory()->create();
        $pencairan = Pencairan::factory()->create([
            'verified_by' => $verifier->id,
        ]);

        $this->assertInstanceOf(User::class, $pencairan->verifier);
        $this->assertEquals($verifier->id, $pencairan->verifier->id);
    }

    public function test_pencairan_has_approver_relationship(): void
    {
        $approver = User::factory()->create();
        $pencairan = Pencairan::factory()->create([
            'approved_by' => $approver->id,
        ]);

        $this->assertInstanceOf(User::class, $pencairan->approver);
        $this->assertEquals($approver->id, $pencairan->approver->id);
    }

    public function test_pencairan_scope_status(): void
    {
        Pencairan::factory()->create(['status' => 'diajukan']);
        Pencairan::factory()->create(['status' => 'diverifikasi']);
        Pencairan::factory()->create(['status' => 'disetujui']);

        $diajukan = Pencairan::status('diajukan')->get();
        $diverifikasi = Pencairan::status('diverifikasi')->get();

        $this->assertCount(1, $diajukan);
        $this->assertCount(1, $diverifikasi);
    }

    public function test_pencairan_scope_tahap(): void
    {
        Pencairan::factory()->create(['tahap_pencairan' => 1]);
        Pencairan::factory()->create(['tahap_pencairan' => 2]);
        Pencairan::factory()->create(['tahap_pencairan' => 1]);

        $tahap1 = Pencairan::tahap(1)->get();
        $tahap2 = Pencairan::tahap(2)->get();

        $this->assertCount(2, $tahap1);
        $this->assertCount(1, $tahap2);
    }

    public function test_is_approved_method(): void
    {
        $pencairanDisetujui = Pencairan::factory()->create(['status' => 'disetujui']);
        $pencairanDicairkan = Pencairan::factory()->create(['status' => 'dicairkan']);
        $pencairanDiajukan = Pencairan::factory()->create(['status' => 'diajukan']);

        $this->assertTrue($pencairanDisetujui->isApproved());
        $this->assertTrue($pencairanDicairkan->isApproved());
        $this->assertFalse($pencairanDiajukan->isApproved());
    }

    public function test_is_completed_method(): void
    {
        $pencairanDicairkan = Pencairan::factory()->create(['status' => 'dicairkan']);
        $pencairanDisetujui = Pencairan::factory()->create(['status' => 'disetujui']);

        $this->assertTrue($pencairanDicairkan->isCompleted());
        $this->assertFalse($pencairanDisetujui->isCompleted());
    }

    public function test_multiple_tahap_pencairan_for_same_permohonan(): void
    {
        $permohonan = Permohonan::factory()->create();

        $pencairan1 = Pencairan::factory()->create([
            'id_permohonan' => $permohonan->id,
            'tahap_pencairan' => 1,
        ]);

        $pencairan2 = Pencairan::factory()->create([
            'id_permohonan' => $permohonan->id,
            'tahap_pencairan' => 2,
        ]);

        $pencairans = Pencairan::where('id_permohonan', $permohonan->id)->get();

        $this->assertCount(2, $pencairans);
        $this->assertEquals(1, $pencairans->first()->tahap_pencairan);
        $this->assertEquals(2, $pencairans->last()->tahap_pencairan);
    }

    public function test_pencairan_has_required_documents(): void
    {
        $pencairan = Pencairan::factory()->create();

        $this->assertNotNull($pencairan->file_lpj);
        $this->assertNotNull($pencairan->file_realisasi);
        $this->assertNotNull($pencairan->file_kwitansi);
    }
}
