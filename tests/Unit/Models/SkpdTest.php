<?php

namespace Tests\Unit\Models;

use App\Models\Skpd;
use App\Models\SkpdDetail;
use App\Models\User;
use App\Models\Lembaga;
use App\Models\UrusanSkpd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SkpdTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test skpd dapat dibuat dengan data yang benar
     */
    public function test_skpd_can_be_created(): void
    {
        $skpd = Skpd::factory()->create([
            'name' => 'Dinas Pendidikan',
            'type' => 'dinas',
        ]);

        $this->assertInstanceOf(Skpd::class, $skpd);
        $this->assertEquals('Dinas Pendidikan', $skpd->name);
        $this->assertEquals('dinas', $skpd->type);
        $this->assertDatabaseHas('skpds', [
            'id' => $skpd->id,
            'name' => 'Dinas Pendidikan',
        ]);
    }

    /**
     * Test skpd memiliki fillable attributes yang benar
     */
    public function test_skpd_has_correct_fillable_attributes(): void
    {
        $skpd = new Skpd();
        
        $expectedFillable = [
            'type',
            'name',
            'deskripsi',
            'alamat',
            'telp',
            'email',
            'fax',
        ];
        
        $this->assertEquals($expectedFillable, $skpd->getFillable());
    }

    /**
     * Test relasi skpd dengan users
     */
    public function test_skpd_has_many_users(): void
    {
        $skpd = Skpd::factory()->create();
        $user = User::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertTrue($skpd->users->contains($user));
        $this->assertInstanceOf(User::class, $skpd->users->first());
    }

    /**
     * Test relasi skpd dengan lembaga
     */
    public function test_skpd_has_many_lembagas(): void
    {
        $skpd = Skpd::factory()->create();
        $lembaga = Lembaga::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertTrue($skpd->lembagas->contains($lembaga));
        $this->assertInstanceOf(Lembaga::class, $skpd->lembagas->first());
    }

    /**
     * Test relasi skpd dengan urusan
     */
    public function test_skpd_has_many_urusan(): void
    {
        $skpd = Skpd::factory()->create();
        $urusan = UrusanSkpd::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertTrue($skpd->has_urusan->contains($urusan));
        $this->assertInstanceOf(UrusanSkpd::class, $skpd->has_urusan->first());
    }

    /**
     * Test skpd dapat di soft delete
     */
    public function test_skpd_can_be_soft_deleted(): void
    {
        $skpd = Skpd::factory()->create();
        $skpd->delete();

        $this->assertSoftDeleted('skpds', ['id' => $skpd->id]);
    }

    /**
     * Test skpd dapat di restore
     */
    public function test_skpd_can_be_restored(): void
    {
        $skpd = Skpd::factory()->create();
        $skpd->delete();
        $skpd->restore();

        $this->assertDatabaseHas('skpds', [
            'id' => $skpd->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * Test skpd dengan informasi kontak lengkap
     */
    public function test_skpd_with_full_contact_info(): void
    {
        $skpd = Skpd::factory()->create([
            'name' => 'Dinas Kesehatan',
            'alamat' => 'Jl. Test No. 1',
            'telp' => '0751-123456',
            'email' => 'dinkes@bukittinggi.go.id',
            'fax' => '0751-654321',
        ]);

        $this->assertEquals('Jl. Test No. 1', $skpd->alamat);
        $this->assertEquals('0751-123456', $skpd->telp);
        $this->assertEquals('dinkes@bukittinggi.go.id', $skpd->email);
        $this->assertEquals('0751-654321', $skpd->fax);
    }

    /**
     * Test skpd dengan deskripsi
     */
    public function test_skpd_with_description(): void
    {
        $skpd = Skpd::factory()->create([
            'deskripsi' => 'Dinas yang menangani urusan pendidikan',
        ]);

        $this->assertEquals('Dinas yang menangani urusan pendidikan', $skpd->deskripsi);
    }
}
