<?php

namespace Tests\Unit\Models;

use App\Models\Nphd;
use App\Models\Permohonan;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Status_permohonan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NphdTest extends TestCase
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

    protected function createNphd(Permohonan $permohonan = null, array $attributes = []): Nphd
    {
        $permohonan = $permohonan ?? $this->createPermohonan();
        
        $defaultAttributes = [
            'id_permohonan' => $permohonan->id,
            'file_nphd' => 'nphd_test.pdf',
            'no_nphd' => 'NPHD/' . date('Y') . '/' . uniqid(),
            'tanggal_nphd' => now(),
            'nilai_disetujui' => 45000000,
            'is_Signed_pemprov' => false,
            'is_Signed_pemko' => false,
        ];
        
        return Nphd::create(array_merge($defaultAttributes, $attributes));
    }

    /**
     * Test nphd dapat dibuat dengan data yang benar
     */
    public function test_nphd_can_be_created(): void
    {
        $permohonan = $this->createPermohonan();
        $nphd = $this->createNphd($permohonan);

        $this->assertInstanceOf(Nphd::class, $nphd);
        $this->assertEquals($permohonan->id, $nphd->id_permohonan);
        $this->assertDatabaseHas('nphds', [
            'id' => $nphd->id,
            'id_permohonan' => $permohonan->id,
        ]);
    }

    /**
     * Test nphd memiliki fillable attributes yang benar
     */
    public function test_nphd_has_correct_fillable_attributes(): void
    {
        $nphd = new Nphd();
        
        $expectedFillable = [
            'id_permohonan',
            'file_nphd',
            'no_nphd',
            'tanggal_nphd',
            'nilai_disetujui',
            'is_Signed_pemprov',
            'is_Signed_pemko',
            'no_permohonan',
            'tanggal_permohonan',
            'file_permohonan',
        ];
        
        $this->assertEquals($expectedFillable, $nphd->getFillable());
    }

    /**
     * Test relasi nphd dengan permohonan
     */
    public function test_nphd_belongs_to_permohonan(): void
    {
        $permohonan = $this->createPermohonan();
        $nphd = $this->createNphd($permohonan);

        $this->assertInstanceOf(Permohonan::class, $nphd->permohonan);
        $this->assertEquals($permohonan->id, $nphd->permohonan->id);
    }

    /**
     * Test nphd menyimpan nomor nphd dengan benar
     */
    public function test_nphd_stores_no_nphd_correctly(): void
    {
        $noNphd = 'NPHD/2026/001/TEST';
        $nphd = $this->createNphd(null, ['no_nphd' => $noNphd]);

        $this->assertEquals($noNphd, $nphd->no_nphd);
    }

    /**
     * Test nphd menyimpan nilai disetujui dengan benar
     */
    public function test_nphd_stores_nilai_disetujui_correctly(): void
    {
        $nilaiDisetujui = 100000000;
        $nphd = $this->createNphd(null, ['nilai_disetujui' => $nilaiDisetujui]);

        $this->assertEquals($nilaiDisetujui, $nphd->nilai_disetujui);
    }

    /**
     * Test nphd dengan status signed pemprov
     */
    public function test_nphd_with_signed_pemprov(): void
    {
        $nphd = $this->createNphd(null, ['is_Signed_pemprov' => true]);

        $this->assertTrue((bool) $nphd->is_Signed_pemprov);
    }

    /**
     * Test nphd dengan status signed pemko
     */
    public function test_nphd_with_signed_pemko(): void
    {
        $nphd = $this->createNphd(null, ['is_Signed_pemko' => true]);

        $this->assertTrue((bool) $nphd->is_Signed_pemko);
    }

    /**
     * Test nphd dengan kedua tanda tangan lengkap
     */
    public function test_nphd_with_both_signatures(): void
    {
        $nphd = $this->createNphd(null, [
            'is_Signed_pemprov' => true,
            'is_Signed_pemko' => true,
        ]);

        $this->assertTrue((bool) $nphd->is_Signed_pemprov);
        $this->assertTrue((bool) $nphd->is_Signed_pemko);
    }

    /**
     * Test nphd menyimpan file nphd dengan benar
     */
    public function test_nphd_stores_file_nphd_correctly(): void
    {
        $fileName = 'document_nphd_2026.pdf';
        $nphd = $this->createNphd(null, ['file_nphd' => $fileName]);

        $this->assertEquals($fileName, $nphd->file_nphd);
    }

    /**
     * Test nphd menyimpan tanggal nphd dengan benar
     */
    public function test_nphd_stores_tanggal_nphd_correctly(): void
    {
        $tanggal = now()->subDays(5);
        $nphd = $this->createNphd(null, ['tanggal_nphd' => $tanggal]);

        // Compare as Carbon or format both sides
        $this->assertEquals(
            $tanggal->format('Y-m-d'), 
            \Carbon\Carbon::parse($nphd->tanggal_nphd)->format('Y-m-d')
        );
    }

    /**
     * Test nphd dengan data permohonan tambahan
     */
    public function test_nphd_with_permohonan_data(): void
    {
        $nphd = $this->createNphd(null, [
            'no_permohonan' => 'PERM/2026/001',
            'tanggal_permohonan' => now(),
            'file_permohonan' => 'permohonan.pdf',
        ]);

        $this->assertEquals('PERM/2026/001', $nphd->no_permohonan);
        $this->assertEquals('permohonan.pdf', $nphd->file_permohonan);
        $this->assertNotNull($nphd->tanggal_permohonan);
    }

    /**
     * Test multiple nphd untuk satu permohonan
     */
    public function test_permohonan_can_have_multiple_nphd(): void
    {
        $permohonan = $this->createPermohonan();
        
        $nphd1 = $this->createNphd($permohonan, ['no_nphd' => 'NPHD/2026/001']);
        $nphd2 = $this->createNphd($permohonan, ['no_nphd' => 'NPHD/2026/002']);

        $this->assertEquals($permohonan->id, $nphd1->id_permohonan);
        $this->assertEquals($permohonan->id, $nphd2->id_permohonan);
        $this->assertNotEquals($nphd1->id, $nphd2->id);
    }
}
