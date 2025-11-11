<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Permohonan;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Status_permohonan;
use App\Models\PendukungPermohonan;
use App\Models\PerbaikanProposal;
use App\Models\PerbaikanRab;
use App\Models\Nphd;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\Attributes\Test;

class PermohonanTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_correct_fillable_attributes()
    {
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

        $this->assertModelHasFillable(Permohonan::class, $expectedFillable);
    }

    #[Test]
    public function it_belongs_to_lembaga()
    {
        $lembaga = Lembaga::factory()->create();
        $permohonan = Permohonan::factory()->create(['id_lembaga' => $lembaga->id]);

        $this->assertModelHasRelationship($permohonan, 'lembaga', BelongsTo::class);
        $this->assertEquals($lembaga->id, $permohonan->lembaga->id);
    }

    #[Test]
    public function it_belongs_to_skpd()
    {
        $skpd = Skpd::factory()->create();
        $permohonan = Permohonan::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertModelHasRelationship($permohonan, 'skpd', BelongsTo::class);
        $this->assertEquals($skpd->id, $permohonan->skpd->id);
    }

    #[Test]
    public function it_belongs_to_urusan_skpd()
    {
        $urusan = UrusanSkpd::factory()->create();
        $permohonan = Permohonan::factory()->create(['urusan' => $urusan->id]);

        $this->assertModelHasRelationship($permohonan, 'urusan_skpd', BelongsTo::class);
        $this->assertEquals($urusan->id, $permohonan->urusan_skpd->id);
    }

    #[Test]
    public function it_belongs_to_status()
    {
        $status = Status_permohonan::factory()->create();
        $permohonan = Permohonan::factory()->create(['id_status' => $status->id]);

        $this->assertModelHasRelationship($permohonan, 'status', BelongsTo::class);
        $this->assertEquals($status->id, $permohonan->status->id);
    }

    #[Test]
    public function it_has_one_pendukung()
    {
        $permohonan = Permohonan::factory()->create();
        $pendukung = PendukungPermohonan::factory()->create(['id_permohonan' => $permohonan->id]);

        $this->assertModelHasRelationship($permohonan, 'pendukung', HasOne::class);
        $this->assertEquals($pendukung->id, $permohonan->pendukung->id);
    }

    #[Test]
    public function it_has_many_perbaikan_proposal()
    {
        $permohonan = Permohonan::factory()->create();
        $perbaikan1 = PerbaikanProposal::factory()->create(['id_permohonan' => $permohonan->id]);
        $perbaikan2 = PerbaikanProposal::factory()->create(['id_permohonan' => $permohonan->id]);

        $this->assertModelHasRelationship($permohonan, 'perbaikanProposal', HasMany::class);
        $this->assertCount(2, $permohonan->perbaikanProposal);
    }

    #[Test]
    public function it_has_many_perbaikan_rab()
    {
        $permohonan = Permohonan::factory()->create();
        $perbaikan1 = PerbaikanRab::factory()->create(['id_permohonan' => $permohonan->id]);
        $perbaikan2 = PerbaikanRab::factory()->create(['id_permohonan' => $permohonan->id]);

        $this->assertModelHasRelationship($permohonan, 'perbaikanRab', HasMany::class);
        $this->assertCount(2, $permohonan->perbaikanRab);
    }

    #[Test]
    public function it_has_one_nphd()
    {
        $permohonan = Permohonan::factory()->create();
        $nphd = Nphd::factory()->create(['id_permohonan' => $permohonan->id]);

        $this->assertModelHasRelationship($permohonan, 'nphd', HasOne::class);
        $this->assertEquals($nphd->id, $permohonan->nphd->id);
    }

    #[Test]
    public function it_can_be_created_with_factory()
    {
        $permohonan = Permohonan::factory()->create();

        $this->assertInstanceOf(Permohonan::class, $permohonan);
        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'no_mohon' => $permohonan->no_mohon,
        ]);
    }

    #[Test]
    public function it_can_be_created_as_approved()
    {
        $permohonan = Permohonan::factory()->approved()->create();

        $this->assertEquals('disetujui', $permohonan->status_rekomendasi);
        $this->assertNotNull($permohonan->nominal_rekomendasi);
        $this->assertNotNull($permohonan->tanggal_rekomendasi);
    }

    #[Test]
    public function it_can_be_created_as_rejected()
    {
        $permohonan = Permohonan::factory()->rejected()->create();

        $this->assertEquals('ditolak', $permohonan->status_rekomendasi);
        $this->assertEquals(0, $permohonan->nominal_rekomendasi);
        $this->assertNotNull($permohonan->tanggal_rekomendasi);
    }

    #[Test]
    public function it_can_be_created_in_review()
    {
        $permohonan = Permohonan::factory()->inReview()->create();

        $this->assertEquals('dalam_review', $permohonan->status_rekomendasi);
        $this->assertEquals('Sedang dalam proses review', $permohonan->catatan_rekomendasi);
    }

    #[Test]
    public function it_uses_soft_deletes()
    {
        $permohonan = Permohonan::factory()->create();
        $permohonanId = $permohonan->id;

        $permohonan->delete();

        $this->assertSoftDeleted('permohonans', ['id' => $permohonanId]);
        $this->assertNotNull($permohonan->fresh()->deleted_at);
    }

    #[Test]
    public function it_uses_blameable_trait()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $permohonan = Permohonan::factory()->create();

        $this->assertNotNull($permohonan->created_by);
    }

    #[Test]
    public function it_generates_proper_no_mohon_format()
    {
        $permohonan = Permohonan::factory()->create(['tahun_apbd' => 2025]);

        $this->assertMatchesRegularExpression(
            '/^\d{3}\/HIBAH\/LEMBAGA\/2025$/',
            $permohonan->no_mohon
        );
    }

    #[Test]
    public function it_generates_proper_no_proposal_format()
    {
        $permohonan = Permohonan::factory()->create(['tahun_apbd' => 2025]);

        $this->assertMatchesRegularExpression(
            '/^\d{3}\/PROPOSAL\/2025$/',
            $permohonan->no_proposal
        );
    }

    #[Test]
    public function it_has_valid_nominal_range()
    {
        $permohonan = Permohonan::factory()->create();

        $this->assertGreaterThanOrEqual(10000000, $permohonan->nominal_rab);
        $this->assertLessThanOrEqual(500000000, $permohonan->nominal_rab);
        $this->assertGreaterThanOrEqual(10000000, $permohonan->nominal_anggaran);
        $this->assertLessThanOrEqual(500000000, $permohonan->nominal_anggaran);
    }

    #[Test]
    public function it_has_logical_date_sequence()
    {
        $permohonan = Permohonan::factory()->create();

        $this->assertLessThanOrEqual(
            $permohonan->tanggal_proposal,
            $permohonan->tanggal_mohon,
            'Tanggal proposal should be after or equal to tanggal mohon'
        );
        
        $this->assertLessThanOrEqual(
            $permohonan->akhir_laksana,
            $permohonan->awal_laksana,
            'Akhir laksana should be after awal laksana'
        );
    }
}
