<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\Attributes\Test;

class SkpdTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_correct_fillable_attributes()
    {
        $expectedFillable = [
            'name',
            'alamat', 
            'deskripsi',
        ];

        $this->assertModelHasFillable(Skpd::class, $expectedFillable);
    }

    #[Test]
    public function it_can_be_created_with_factory()
    {
        $skpd = Skpd::factory()->create();

        $this->assertInstanceOf(Skpd::class, $skpd);
        $this->assertDatabaseHas('skpds', [
            'id' => $skpd->id,
            'name' => $skpd->name,
        ]);
    }

    #[Test]
    public function it_can_be_created_with_specific_name()
    {
        $name = 'Dinas Pendidikan Test';
        $skpd = Skpd::factory()->withName($name)->create();

        $this->assertEquals($name, $skpd->name);
    }

    #[Test]
    public function it_extends_base_model()
    {
        $skpd = new Skpd();

        $this->assertInstanceOf(\App\Models\BaseModel::class, $skpd);
    }

    #[Test]
    public function required_fields_should_not_be_null()
    {
        $skpd = Skpd::factory()->create();

        $this->assertNotNull($skpd->name);
        $this->assertNotNull($skpd->alamat);
    }

    #[Test]
    public function it_has_valid_skpd_names()
    {
        $validNames = [
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas Pekerjaan Umum',
            'Dinas Sosial',
            'Dinas Pemuda dan Olahraga',
            'Dinas Kebudayaan dan Pariwisata',
            'Dinas Lingkungan Hidup',
            'Badan Perencanaan Pembangunan Daerah',
            'Dinas Koperasi dan UKM',
            'Dinas Perindustrian dan Perdagangan'
        ];

        $skpd = Skpd::factory()->create();

        $this->assertContains($skpd->name, $validNames);
    }

    #[Test]
    public function name_should_be_string()
    {
        $skpd = Skpd::factory()->create();

        $this->assertIsString($skpd->name);
    }

    #[Test]
    public function alamat_should_be_string()
    {
        $skpd = Skpd::factory()->create();

        $this->assertIsString($skpd->alamat);
        $this->assertNotEmpty($skpd->alamat);
    }

    #[Test]
    public function deskripsi_can_be_null_or_string()
    {
        $skpd = Skpd::factory()->create();

        $this->assertTrue(is_string($skpd->deskripsi) || is_null($skpd->deskripsi));
    }

    #[Test]
    public function it_uses_blameable_trait()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $skpd = Skpd::factory()->create();

        $this->assertNotNull($skpd->created_by);
    }

    #[Test]
    public function it_uses_soft_deletes()
    {
        $skpd = Skpd::factory()->create();
        $skpdId = $skpd->id;

        $skpd->delete();

        $this->assertSoftDeleted('skpds', ['id' => $skpdId]);
        $this->assertNotNull($skpd->fresh()->deleted_at);
    }
}
