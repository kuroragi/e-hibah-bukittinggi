<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\User;
use App\Models\Pengurus;
use App\Models\NphdLembaga;
use App\Models\Kelurahan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LembagaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $expectedFillable = [
            'name',
            'acronym',
            'id_skpd',
            'id_urusan',
            'email',
            'phone',
            'id_kelurahan',
            'alamat',
            'photo',
            'npwp',
            'no_akta_kumham',
            'date_akta_kumham',
            'file_akta_kumham',
            'no_domisili',
            'date_domisili',
            'file_domisili',
            'no_operasional',
            'date_operasional',
            'file_operasional',
            'no_pernyataan',
            'date_pernyataan',
            'file_pernyataan',
            'id_bank',
            'atas_nama',
            'no_rekening',
            'photo_rek',
            'deleted_at',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        $this->assertModelHasFillable(Lembaga::class, $expectedFillable);
    }

    /** @test */
    public function it_belongs_to_skpd()
    {
        $skpd = Skpd::factory()->create();
        $lembaga = Lembaga::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertModelHasRelationship($lembaga, 'skpd', BelongsTo::class);
        $this->assertEquals($skpd->id, $lembaga->skpd->id);
    }

    /** @test */
    public function it_belongs_to_urusan()
    {
        $urusan = UrusanSkpd::factory()->create();
        $lembaga = Lembaga::factory()->create(['id_urusan' => $urusan->id]);

        $this->assertModelHasRelationship($lembaga, 'urusan', BelongsTo::class);
        $this->assertEquals($urusan->id, $lembaga->urusan->id);
    }

    /** @test */
    public function it_belongs_to_kelurahan()
    {
        $kelurahan = Kelurahan::factory()->create();
        $lembaga = Lembaga::factory()->create(['id_kelurahan' => $kelurahan->id]);

        $this->assertModelHasRelationship($lembaga, 'kelurahan', BelongsTo::class);
        $this->assertEquals($kelurahan->id, $lembaga->kelurahan->id);
    }

    /** @test */
    public function it_has_one_user()
    {
        $lembaga = Lembaga::factory()->create();
        $user = User::factory()->create(['id_lembaga' => $lembaga->id]);

        $this->assertModelHasRelationship($lembaga, 'user', HasOne::class);
        $this->assertEquals($user->id, $lembaga->user->id);
    }

    /** @test */
    public function it_has_many_pengurus()
    {
        $lembaga = Lembaga::factory()->create();
        $pengurus1 = Pengurus::factory()->create(['id_lembaga' => $lembaga->id]);
        $pengurus2 = Pengurus::factory()->create(['id_lembaga' => $lembaga->id]);

        $this->assertModelHasRelationship($lembaga, 'pengurus', HasMany::class);
        $this->assertCount(2, $lembaga->pengurus);
    }

    /** @test */
    public function it_has_one_nphd_lembaga()
    {
        $lembaga = Lembaga::factory()->create();
        $nphdLembaga = NphdLembaga::factory()->create(['id_lembaga' => $lembaga->id]);

        $this->assertModelHasRelationship($lembaga, 'nphdLembaga', HasOne::class);
        $this->assertEquals($nphdLembaga->id, $lembaga->nphdLembaga->id);
    }

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $lembaga = Lembaga::factory()->create();

        $this->assertInstanceOf(Lembaga::class, $lembaga);
        $this->assertDatabaseHas('lembagas', [
            'id' => $lembaga->id,
            'name' => $lembaga->name,
        ]);
    }

    /** @test */
    public function it_can_be_created_with_documents()
    {
        $lembaga = Lembaga::factory()->withDocuments()->create();

        $this->assertNotNull($lembaga->file_akta_kumham);
        $this->assertNotNull($lembaga->file_domisili);
        $this->assertNotNull($lembaga->file_operasional);
        $this->assertNotNull($lembaga->file_pernyataan);
        $this->assertNotNull($lembaga->photo);
        $this->assertNotNull($lembaga->photo_rek);
    }

    /** @test */
    public function it_uses_soft_deletes()
    {
        $lembaga = Lembaga::factory()->create();
        $lembagaId = $lembaga->id;

        $lembaga->delete();

        $this->assertSoftDeleted('lembagas', ['id' => $lembagaId]);
        $this->assertNotNull($lembaga->fresh()->deleted_at);
    }

    /** @test */
    public function it_uses_blameable_trait()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $lembaga = Lembaga::factory()->create();

        $this->assertNotNull($lembaga->created_by);
    }

    /** @test */
    public function it_has_valid_npwp_format()
    {
        $lembaga = Lembaga::factory()->create();

        $this->assertMatchesRegularExpression(
            '/^\d{2}\.\d{3}\.\d{3}\.\d{1}-\d{3}\.\d{3}$/',
            $lembaga->npwp
        );
    }

    /** @test */
    public function it_has_valid_bank_account_number()
    {
        $lembaga = Lembaga::factory()->create();

        $this->assertIsString($lembaga->no_rekening);
        $this->assertNotEmpty($lembaga->no_rekening);
        $this->assertNotNull($lembaga->atas_nama);
    }

    /** @test */
    public function it_has_valid_email_format()
    {
        $lembaga = Lembaga::factory()->create();

        $this->assertNotNull($lembaga->email);
        $this->assertMatchesRegularExpression(
            '/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            $lembaga->email
        );
    }

    /** @test */
    public function it_extends_base_model()
    {
        $lembaga = new Lembaga();

        $this->assertInstanceOf(\App\Models\BaseModel::class, $lembaga);
    }

    /** @test */
    public function required_fields_should_not_be_null()
    {
        $lembaga = Lembaga::factory()->create();

        $this->assertNotNull($lembaga->name);
        $this->assertNotNull($lembaga->acronym);
        $this->assertNotNull($lembaga->email);
        $this->assertNotNull($lembaga->alamat);
    }

    /** @test */
    public function acronym_should_be_short()
    {
        $lembaga = Lembaga::factory()->create();

        $this->assertLessThanOrEqual(10, strlen($lembaga->acronym));
    }

    /** @test */
    public function documents_can_be_null()
    {
        $lembaga = Lembaga::factory()->create([
            'photo' => null,
            'file_akta_kumham' => null,
            'file_domisili' => null,
            'file_operasional' => null,
            'file_pernyataan' => null,
            'photo_rek' => null,
        ]);

        $this->assertNull($lembaga->photo);
        $this->assertNull($lembaga->file_akta_kumham);
        $this->assertNull($lembaga->file_domisili);
        $this->assertNull($lembaga->file_operasional);
        $this->assertNull($lembaga->file_pernyataan);
        $this->assertNull($lembaga->photo_rek);
    }
}