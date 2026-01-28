<?php

namespace Tests\Unit\Models;

use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Status_permohonan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LembagaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test lembaga dapat dibuat dengan data yang benar
     */
    public function test_lembaga_can_be_created(): void
    {
        $lembaga = Lembaga::factory()->create([
            'name' => 'Yayasan Pendidikan Test',
            'acronym' => 'YPT',
        ]);

        $this->assertInstanceOf(Lembaga::class, $lembaga);
        $this->assertEquals('Yayasan Pendidikan Test', $lembaga->name);
        $this->assertEquals('YPT', $lembaga->acronym);
        $this->assertDatabaseHas('lembagas', [
            'id' => $lembaga->id,
            'name' => 'Yayasan Pendidikan Test',
        ]);
    }

    /**
     * Test lembaga memiliki fillable attributes yang benar
     */
    public function test_lembaga_has_correct_fillable_attributes(): void
    {
        $lembaga = new Lembaga();
        
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
        
        $this->assertEquals($expectedFillable, $lembaga->getFillable());
    }

    /**
     * Test relasi lembaga dengan skpd
     */
    public function test_lembaga_belongs_to_skpd(): void
    {
        $skpd = Skpd::factory()->create();
        $lembaga = Lembaga::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertInstanceOf(Skpd::class, $lembaga->skpd);
        $this->assertEquals($skpd->id, $lembaga->skpd->id);
    }

    /**
     * Test relasi lembaga dengan urusan
     */
    public function test_lembaga_belongs_to_urusan(): void
    {
        $urusan = UrusanSkpd::factory()->create();
        $lembaga = Lembaga::factory()->create(['id_urusan' => $urusan->id]);

        $this->assertInstanceOf(UrusanSkpd::class, $lembaga->urusan);
        $this->assertEquals($urusan->id, $lembaga->urusan->id);
    }

    /**
     * Test relasi lembaga dengan user
     */
    public function test_lembaga_has_one_user(): void
    {
        $lembaga = Lembaga::factory()->create();
        $user = User::factory()->create(['id_lembaga' => $lembaga->id]);

        $this->assertInstanceOf(User::class, $lembaga->user);
        $this->assertEquals($user->id, $lembaga->user->id);
    }

    /**
     * Test lembaga dapat di soft delete
     */
    public function test_lembaga_can_be_soft_deleted(): void
    {
        $lembaga = Lembaga::factory()->create();
        $lembaga->delete();

        $this->assertSoftDeleted('lembagas', ['id' => $lembaga->id]);
    }

    /**
     * Test lembaga dapat di restore
     */
    public function test_lembaga_can_be_restored(): void
    {
        $lembaga = Lembaga::factory()->create();
        $lembaga->delete();
        $lembaga->restore();

        $this->assertDatabaseHas('lembagas', [
            'id' => $lembaga->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * Test lembaga dengan informasi kontak lengkap
     */
    public function test_lembaga_with_contact_info(): void
    {
        $lembaga = Lembaga::factory()->create([
            'email' => 'lembaga@test.com',
            'phone' => '08123456789',
            'alamat' => 'Jl. Test No. 123, Bukittinggi',
        ]);

        $this->assertEquals('lembaga@test.com', $lembaga->email);
        $this->assertEquals('08123456789', $lembaga->phone);
        $this->assertEquals('Jl. Test No. 123, Bukittinggi', $lembaga->alamat);
    }

    /**
     * Test lembaga dengan data rekening bank
     */
    public function test_lembaga_with_bank_info(): void
    {
        $lembaga = Lembaga::factory()->create([
            'atas_nama' => 'Yayasan Test',
            'no_rekening' => '1234567890',
        ]);

        $this->assertEquals('Yayasan Test', $lembaga->atas_nama);
        $this->assertEquals('1234567890', $lembaga->no_rekening);
    }

    /**
     * Test lembaga dengan dokumen legalitas
     */
    public function test_lembaga_with_legal_documents(): void
    {
        $lembaga = Lembaga::factory()->create([
            'no_akta_kumham' => 'AKT-001/2026',
            'date_akta_kumham' => now(),
            'file_akta_kumham' => 'akta.pdf',
            'no_domisili' => 'DOM-001/2026',
            'file_domisili' => 'domisili.pdf',
        ]);

        $this->assertEquals('AKT-001/2026', $lembaga->no_akta_kumham);
        $this->assertEquals('akta.pdf', $lembaga->file_akta_kumham);
        $this->assertEquals('DOM-001/2026', $lembaga->no_domisili);
        $this->assertEquals('domisili.pdf', $lembaga->file_domisili);
    }

    /**
     * Test lembaga dengan NPWP
     */
    public function test_lembaga_with_npwp(): void
    {
        $lembaga = Lembaga::factory()->create([
            'npwp' => '123456789012345', // 15 digit NPWP
        ]);

        $this->assertEquals('123456789012345', $lembaga->npwp);
    }
}
