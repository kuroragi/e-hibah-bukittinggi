<?php

namespace Tests\Unit\Models;

use App\Models\Permohonan;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Status_permohonan;
use App\Models\Nphd;
use App\Models\PendukungPermohonan;
use App\Models\PerbaikanProposal;
use App\Models\PerbaikanRab;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermohonanTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function createPermohonan(array $attributes = []): Permohonan
    {
        // Create dependencies first
        $lembaga = Lembaga::factory()->create();
        $skpd = Skpd::factory()->create();
        $urusan = UrusanSkpd::factory()->create();
        $status = Status_permohonan::factory()->create();
        
        $defaultAttributes = [
            'id_lembaga' => $lembaga->id,
            'no_mohon' => '001/HIBAH/TEST/' . date('Y'),
            'tanggal_mohon' => now(),
            'tahun_apbd' => date('Y'),
            'perihal_mohon' => 'Perihal Test',
            'file_mohon' => 'test.pdf',
            'no_proposal' => '001/PROPOSAL/TEST/' . date('Y'),
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
     * Test permohonan dapat dibuat dengan data yang benar
     */
    public function test_permohonan_can_be_created(): void
    {
        $permohonan = $this->createPermohonan([
            'title' => 'Permohonan Hibah Test',
            'perihal_mohon' => 'Perihal Test',
        ]);

        $this->assertInstanceOf(Permohonan::class, $permohonan);
        $this->assertEquals('Permohonan Hibah Test', $permohonan->title);
        $this->assertDatabaseHas('permohonans', [
            'title' => 'Permohonan Hibah Test',
        ]);
    }

    /**
     * Test permohonan memiliki fillable attributes yang benar
     */
    public function test_permohonan_has_correct_fillable_attributes(): void
    {
        $permohonan = new Permohonan();
        
        $expectedFillable = [
            'id_lembaga',
            'no_mohon',
            'tanggal_mohon',
            'tahun_apbd',
            'perihal_mohon',
            'file_mohon',
            'no_proposal',
            'tanggal_proposal',
            'title',
            'urusan',
            'id_skpd',
            'awal_laksana',
            'akhir_laksana',
            'latar_belakang',
            'maksud_tujuan',
            'keterangan',
            'file_proposal',
            'nominal_rab',
            'nominal_anggaran',
            'id_status',
            'status_rekomendasi',
            'nominal_rekomendasi',
            'tanggal_rekomendasi',
            'catatan_rekomendasi',
            'file_pemberitahuan',
            'file_permintaan_nphd',
            'deleted_at',
            'created_by',
            'updated_by',
            'deleted_by',
        ];
        
        $this->assertEquals($expectedFillable, $permohonan->getFillable());
    }

    /**
     * Test relasi permohonan dengan lembaga
     */
    public function test_permohonan_belongs_to_lembaga(): void
    {
        $permohonan = $this->createPermohonan();

        $this->assertInstanceOf(Lembaga::class, $permohonan->lembaga);
        $this->assertEquals($permohonan->id_lembaga, $permohonan->lembaga->id);
    }

    /**
     * Test relasi permohonan dengan SKPD
     */
    public function test_permohonan_belongs_to_skpd(): void
    {
        $permohonan = $this->createPermohonan();

        $this->assertInstanceOf(Skpd::class, $permohonan->skpd);
        $this->assertEquals($permohonan->id_skpd, $permohonan->skpd->id);
    }

    /**
     * Test relasi permohonan dengan urusan SKPD
     */
    public function test_permohonan_belongs_to_urusan_skpd(): void
    {
        $permohonan = $this->createPermohonan();

        $this->assertInstanceOf(UrusanSkpd::class, $permohonan->urusan_skpd);
        $this->assertEquals($permohonan->urusan, $permohonan->urusan_skpd->id);
    }

    /**
     * Test relasi permohonan dengan status
     */
    public function test_permohonan_belongs_to_status(): void
    {
        $permohonan = $this->createPermohonan();

        $this->assertInstanceOf(Status_permohonan::class, $permohonan->status);
        $this->assertEquals($permohonan->id_status, $permohonan->status->id);
    }

    /**
     * Test soft delete pada permohonan
     */
    public function test_permohonan_can_be_soft_deleted(): void
    {
        $permohonan = $this->createPermohonan();
        
        $permohonanId = $permohonan->id;
        $permohonan->delete();

        $this->assertNull(Permohonan::find($permohonanId));
        $this->assertNotNull(Permohonan::withTrashed()->find($permohonanId));
        $this->assertNotNull(Permohonan::withTrashed()->find($permohonanId)->deleted_at);
    }

    /**
     * Test permohonan dapat di-restore setelah soft delete
     */
    public function test_permohonan_can_be_restored_after_soft_delete(): void
    {
        $permohonan = $this->createPermohonan();
        
        $permohonanId = $permohonan->id;
        $permohonan->delete();
        
        Permohonan::withTrashed()->find($permohonanId)->restore();
        
        $restoredPermohonan = Permohonan::find($permohonanId);
        $this->assertNotNull($restoredPermohonan);
        $this->assertNull($restoredPermohonan->deleted_at);
    }

    /**
     * Test nomor permohonan unik
     */
    public function test_no_mohon_is_stored_correctly(): void
    {
        $permohonan = $this->createPermohonan([
            'no_mohon' => '001/HIBAH/LEMBAGA/2025',
        ]);

        $this->assertEquals('001/HIBAH/LEMBAGA/2025', $permohonan->no_mohon);
    }

    /**
     * Test nominal RAB dan nominal anggaran tersimpan dengan benar
     */
    public function test_nominal_fields_are_stored_correctly(): void
    {
        $permohonan = $this->createPermohonan([
            'nominal_rab' => 50000000,
            'nominal_anggaran' => 45000000,
        ]);

        $this->assertEquals(50000000, $permohonan->nominal_rab);
        $this->assertEquals(45000000, $permohonan->nominal_anggaran);
    }

    /**
     * Test relasi permohonan dengan NPHD
     */
    public function test_permohonan_has_one_nphd(): void
    {
        $permohonan = $this->createPermohonan();
        
        // Initially no NPHD
        $this->assertNull($permohonan->nphd);
        
        // Create NPHD for permohonan
        $nphd = Nphd::create([
            'id_permohonan' => $permohonan->id,
            'no_nphd' => 'NPHD-001/2025',
            'tanggal_nphd' => now(),
            'file_nphd' => 'nphd/nphd-001.pdf',
        ]);
        
        // Refresh relationship
        $permohonan->refresh();
        
        $this->assertInstanceOf(Nphd::class, $permohonan->nphd);
        $this->assertEquals($nphd->id, $permohonan->nphd->id);
    }

    /**
     * Test periode pelaksanaan (awal dan akhir)
     */
    public function test_periode_pelaksanaan_is_stored_correctly(): void
    {
        $awalLaksana = now()->addMonth();
        $akhirLaksana = now()->addMonths(6);
        
        $permohonan = $this->createPermohonan([
            'awal_laksana' => $awalLaksana,
            'akhir_laksana' => $akhirLaksana,
        ]);

        $this->assertEquals($awalLaksana->format('Y-m-d'), date('Y-m-d', strtotime($permohonan->awal_laksana)));
        $this->assertEquals($akhirLaksana->format('Y-m-d'), date('Y-m-d', strtotime($permohonan->akhir_laksana)));
    }

    /**
     * Test tahun APBD tersimpan dengan benar
     */
    public function test_tahun_apbd_is_stored_correctly(): void
    {
        $permohonan = $this->createPermohonan([
            'tahun_apbd' => '2025',
        ]);

        $this->assertEquals('2025', $permohonan->tahun_apbd);
    }

    /**
     * Test status rekomendasi default
     */
    public function test_status_rekomendasi_default_value(): void
    {
        $permohonan = $this->createPermohonan([
            'status_rekomendasi' => 0,
        ]);

        $this->assertEquals(0, $permohonan->status_rekomendasi);
    }
}
