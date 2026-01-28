<?php

namespace Tests\Unit\Models;

use App\Models\UrusanSkpd;
use App\Models\Skpd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrusanSkpdTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test urusan skpd dapat dibuat dengan data yang benar
     */
    public function test_urusan_skpd_can_be_created(): void
    {
        $skpd = Skpd::factory()->create();
        $urusan = UrusanSkpd::factory()->create([
            'id_skpd' => $skpd->id,
            'nama_urusan' => 'Urusan Pendidikan Dasar',
        ]);

        $this->assertInstanceOf(UrusanSkpd::class, $urusan);
        $this->assertEquals('Urusan Pendidikan Dasar', $urusan->nama_urusan);
        $this->assertDatabaseHas('urusan_skpds', [
            'id' => $urusan->id,
            'nama_urusan' => 'Urusan Pendidikan Dasar',
        ]);
    }

    /**
     * Test urusan skpd memiliki fillable attributes yang benar
     */
    public function test_urusan_skpd_has_correct_fillable_attributes(): void
    {
        $urusan = new UrusanSkpd();
        
        $expectedFillable = [
            'id_skpd',
            'nama_urusan',
            'kepala_urusan',
            'kegiatan',
            'deleted_at',
            'created_by',
            'updated_by',
            'deleted_by',
        ];
        
        $this->assertEquals($expectedFillable, $urusan->getFillable());
    }

    /**
     * Test relasi urusan skpd dengan skpd
     */
    public function test_urusan_skpd_belongs_to_skpd(): void
    {
        $skpd = Skpd::factory()->create();
        $urusan = UrusanSkpd::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertInstanceOf(Skpd::class, $urusan->skpd);
        $this->assertEquals($skpd->id, $urusan->skpd->id);
    }

    /**
     * Test urusan skpd dapat di soft delete
     */
    public function test_urusan_skpd_can_be_soft_deleted(): void
    {
        $urusan = UrusanSkpd::factory()->create();
        $urusan->delete();

        $this->assertSoftDeleted('urusan_skpds', ['id' => $urusan->id]);
    }

    /**
     * Test urusan skpd dapat di restore
     */
    public function test_urusan_skpd_can_be_restored(): void
    {
        $urusan = UrusanSkpd::factory()->create();
        $urusan->delete();
        $urusan->restore();

        $this->assertDatabaseHas('urusan_skpds', [
            'id' => $urusan->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * Test urusan skpd dengan kepala urusan
     */
    public function test_urusan_skpd_with_kepala_urusan(): void
    {
        $urusan = UrusanSkpd::factory()->create([
            'kepala_urusan' => 'Drs. John Doe, M.Pd',
        ]);

        $this->assertEquals('Drs. John Doe, M.Pd', $urusan->kepala_urusan);
    }

    /**
     * Test urusan skpd dengan kegiatan
     */
    public function test_urusan_skpd_with_kegiatan(): void
    {
        $urusan = UrusanSkpd::factory()->create([
            'kegiatan' => 'Pembinaan Pendidikan Anak Usia Dini',
        ]);

        $this->assertEquals('Pembinaan Pendidikan Anak Usia Dini', $urusan->kegiatan);
    }

    /**
     * Test multiple urusan dapat dibuat untuk satu skpd
     */
    public function test_skpd_can_have_multiple_urusan(): void
    {
        $skpd = Skpd::factory()->create();
        
        $urusan1 = UrusanSkpd::factory()->create([
            'id_skpd' => $skpd->id,
            'nama_urusan' => 'Urusan Pendidikan Dasar',
        ]);
        
        $urusan2 = UrusanSkpd::factory()->create([
            'id_skpd' => $skpd->id,
            'nama_urusan' => 'Urusan Pendidikan Menengah',
        ]);

        $this->assertEquals($skpd->id, $urusan1->id_skpd);
        $this->assertEquals($skpd->id, $urusan2->id_skpd);
        $this->assertNotEquals($urusan1->id, $urusan2->id);
    }
}
