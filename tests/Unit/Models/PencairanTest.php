<?php

namespace Tests\Unit\Models;

use App\Models\Pencairan;
use App\Models\Permohonan;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Status_permohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PencairanTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
     * Status values: 'diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'dicairkan'
     */
    protected function createPencairan(Permohonan $permohonan = null, array $attributes = []): Pencairan
    {
        $permohonan = $permohonan ?? $this->createPermohonan();
        
        $defaultAttributes = [
            'id_permohonan' => $permohonan->id,
            'tanggal_pencairan' => now(),
            'jumlah_pencairan' => 25000000,
            'tahap_pencairan' => 1,
            'status' => 'diajukan',
            'bukti' => 'bukti_transfer.pdf',
            'keterangan' => 'Test pencairan',
        ];
        
        return Pencairan::create(array_merge($defaultAttributes, $attributes));
    }

    /**
     * Test pencairan dapat dibuat dengan data yang benar
     */
    public function test_pencairan_can_be_created(): void
    {
        $permohonan = $this->createPermohonan();
        $pencairan = $this->createPencairan($permohonan);

        $this->assertInstanceOf(Pencairan::class, $pencairan);
        $this->assertEquals(25000000, $pencairan->jumlah_pencairan);
        $this->assertEquals(1, $pencairan->tahap_pencairan);
        $this->assertDatabaseHas('pencairans', [
            'id_permohonan' => $permohonan->id,
            'tahap_pencairan' => 1,
        ]);
    }

    /**
     * Test pencairan memiliki fillable attributes yang benar
     */
    public function test_pencairan_has_correct_fillable_attributes(): void
    {
        $pencairan = new Pencairan();
        
        $expectedFillable = [
            'id_permohonan',
            'tanggal_pencairan',
            'jumlah_pencairan',
            'tahap_pencairan',
            'status',
            'bukti',
            'keterangan',
            'file_lpj',
            'file_realisasi',
            'file_dokumentasi',
            'file_kwitansi',
            'verified_by',
            'verified_at',
            'catatan_verifikasi',
            'approved_by',
            'approved_at',
            'catatan_approval',
        ];
        
        $this->assertEquals($expectedFillable, $pencairan->getFillable());
    }

    /**
     * Test relasi pencairan dengan permohonan
     */
    public function test_pencairan_belongs_to_permohonan(): void
    {
        $permohonan = $this->createPermohonan();
        $pencairan = $this->createPencairan($permohonan);

        $this->assertInstanceOf(Permohonan::class, $pencairan->permohonan);
        $this->assertEquals($permohonan->id, $pencairan->permohonan->id);
    }

    /**
     * Test pencairan dapat diverifikasi
     */
    public function test_pencairan_can_be_verified(): void
    {
        $verifier = User::factory()->create();
        $pencairan = $this->createPencairan();
        
        $pencairan->update([
            'verified_by' => $verifier->id,
            'verified_at' => now(),
            'catatan_verifikasi' => 'Dokumen lengkap dan valid',
            'status' => 'diverifikasi',
        ]);
        
        $pencairan->refresh();
        
        $this->assertEquals($verifier->id, $pencairan->verified_by);
        $this->assertNotNull($pencairan->verified_at);
        $this->assertEquals('diverifikasi', $pencairan->status);
    }

    /**
     * Test pencairan dapat di-approve
     */
    public function test_pencairan_can_be_approved(): void
    {
        $approver = User::factory()->create();
        $pencairan = $this->createPencairan(null, ['status' => 'diverifikasi']);
        
        $pencairan->update([
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'catatan_approval' => 'Disetujui untuk pencairan',
            'status' => 'disetujui',
        ]);
        
        $pencairan->refresh();
        
        $this->assertEquals($approver->id, $pencairan->approved_by);
        $this->assertNotNull($pencairan->approved_at);
        $this->assertEquals('disetujui', $pencairan->status);
    }

    /**
     * Test scope status pada pencairan
     */
    public function test_pencairan_scope_status(): void
    {
        $permohonan = $this->createPermohonan();
        
        $this->createPencairan($permohonan, [
            'tahap_pencairan' => 1,
            'status' => 'diajukan',
        ]);
        
        $this->createPencairan($permohonan, [
            'tahap_pencairan' => 2,
            'status' => 'disetujui',
        ]);
        
        $diajukanCount = Pencairan::status('diajukan')->count();
        $disetujuiCount = Pencairan::status('disetujui')->count();
        
        $this->assertEquals(1, $diajukanCount);
        $this->assertEquals(1, $disetujuiCount);
    }

    /**
     * Test scope tahap pada pencairan
     */
    public function test_pencairan_scope_tahap(): void
    {
        $permohonan = $this->createPermohonan();
        
        $this->createPencairan($permohonan, [
            'tahap_pencairan' => 1,
        ]);
        
        $this->createPencairan($permohonan, [
            'tahap_pencairan' => 2,
        ]);
        
        $tahap1Count = Pencairan::tahap(1)->count();
        $tahap2Count = Pencairan::tahap(2)->count();
        
        $this->assertEquals(1, $tahap1Count);
        $this->assertEquals(1, $tahap2Count);
    }

    /**
     * Test relasi pencairan dengan verifier (user)
     */
    public function test_pencairan_belongs_to_verifier(): void
    {
        $verifier = User::factory()->create();
        $pencairan = $this->createPencairan(null, [
            'status' => 'diverifikasi',
            'verified_by' => $verifier->id,
            'verified_at' => now(),
        ]);

        $this->assertInstanceOf(User::class, $pencairan->verifier);
        $this->assertEquals($verifier->id, $pencairan->verifier->id);
    }

    /**
     * Test relasi pencairan dengan approver (user)
     */
    public function test_pencairan_belongs_to_approver(): void
    {
        $approver = User::factory()->create();
        $pencairan = $this->createPencairan(null, [
            'status' => 'disetujui',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);

        $this->assertInstanceOf(User::class, $pencairan->approver);
        $this->assertEquals($approver->id, $pencairan->approver->id);
    }

    /**
     * Test isApproved method returns true for disetujui status
     */
    public function test_is_approved_returns_true_for_disetujui(): void
    {
        $pencairan = $this->createPencairan(null, ['status' => 'disetujui']);
        
        $this->assertTrue($pencairan->isApproved());
    }

    /**
     * Test isApproved method returns true for dicairkan status
     */
    public function test_is_approved_returns_true_for_dicairkan(): void
    {
        $pencairan = $this->createPencairan(null, ['status' => 'dicairkan']);
        
        $this->assertTrue($pencairan->isApproved());
    }

    /**
     * Test isApproved method returns false for diajukan status
     */
    public function test_is_approved_returns_false_for_diajukan(): void
    {
        $pencairan = $this->createPencairan(null, ['status' => 'diajukan']);
        
        $this->assertFalse($pencairan->isApproved());
    }

    /**
     * Test isCompleted method
     */
    public function test_is_completed_method(): void
    {
        $completedPencairan = $this->createPencairan(null, ['status' => 'dicairkan']);
        $pendingPencairan = $this->createPencairan(null, ['status' => 'diajukan']);
        
        $this->assertTrue($completedPencairan->isCompleted());
        $this->assertFalse($pendingPencairan->isCompleted());
    }

    /**
     * Test pencairan dapat ditolak
     */
    public function test_pencairan_can_be_rejected(): void
    {
        $pencairan = $this->createPencairan();
        
        $pencairan->update([
            'status' => 'ditolak',
            'catatan_verifikasi' => 'Dokumen tidak lengkap',
        ]);
        
        $pencairan->refresh();
        
        $this->assertEquals('ditolak', $pencairan->status);
        $this->assertFalse($pencairan->isApproved());
    }

    /**
     * Test pencairan dengan file dokumen
     */
    public function test_pencairan_with_document_files(): void
    {
        $pencairan = $this->createPencairan(null, [
            'file_lpj' => 'lpj.pdf',
            'file_realisasi' => 'realisasi.pdf',
            'file_dokumentasi' => 'dokumentasi.pdf',
            'file_kwitansi' => 'kwitansi.pdf',
        ]);
        
        $this->assertEquals('lpj.pdf', $pencairan->file_lpj);
        $this->assertEquals('realisasi.pdf', $pencairan->file_realisasi);
        $this->assertEquals('dokumentasi.pdf', $pencairan->file_dokumentasi);
        $this->assertEquals('kwitansi.pdf', $pencairan->file_kwitansi);
    }
}
