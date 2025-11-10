                                                                                                                                                                                                                                                                                                <?php

namespace Tests\Feature\Livewire\Permohonan;

use Tests\TestCase;
use App\Livewire\Permohonan\CreateOrUpdate;
use App\Models\User;
use App\Models\Lembaga;
use App\Models\Permohonan;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class CreateOrUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $lembaga;
    protected $skpd;
    protected $urusan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lembaga = Lembaga::factory()->create();
        $this->skpd = Skpd::factory()->create();
        $this->urusan = UrusanSkpd::factory()->create(['id_skpd' => $this->skpd->id]);
        
        $this->user = User::factory()->create([
            'id_lembaga' => $this->lembaga->id
        ]);

        Storage::fake('public');
    }

    /** @test */
    public function component_can_render()
    {
        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->assertOk();
    }

    /** @test */
    public function component_loads_with_correct_initial_data()
    {
        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->assertSet('id_lembaga', $this->lembaga->id)
            ->assertViewHas('skpds')
            ->assertViewHas('urusans');
    }

    /** @test */
    public function component_can_create_new_permohonan()
    {
        $file_mohon = UploadedFile::fake()->create('permohonan.pdf', 1024, 'application/pdf');
        $file_proposal = UploadedFile::fake()->create('proposal.pdf', 1024, 'application/pdf');

        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->set('usulan_apbd', '2024')
            ->set('no_mohon', '001/HIBAH/2024')
            ->set('tanggal_mohon', '2024-01-15')
            ->set('perihal_mohon', 'Permohonan Hibah Test')
            ->set('file_mohon', $file_mohon)
            ->set('no_proposal', '001/PROP/2024')
            ->set('tanggal_proposal', '2024-01-16')
            ->set('title', 'Program Test Lembaga')
            ->set('id_skpd', $this->skpd->id)
            ->set('urusan', $this->urusan->id)
            ->set('awal_laksana', '2024-02-01')
            ->set('akhir_laksana', '2024-12-31')
            ->set('latar_belakang', 'Latar belakang program test')
            ->set('maksud_tujuan', 'Maksud dan tujuan program test')
            ->set('keterangan', 'Keterangan tambahan')
            ->set('file_proposal', $file_proposal)
            ->call('store')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('permohonans', [
            'id_lembaga' => $this->lembaga->id,
            'no_mohon' => '001/HIBAH/2024',
            'perihal_mohon' => 'Permohonan Hibah Test',
            'title' => 'Program Test Lembaga',
            'id_skpd' => $this->skpd->id,
            'urusan' => $this->urusan->id,
        ]);
    }

    /** @test */
    public function component_validates_required_fields()
    {
        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->call('store')
            ->assertHasErrors([
                'usulan_apbd',
                'no_mohon',
                'tanggal_mohon',
                'perihal_mohon',
                'file_mohon',
                'no_proposal',
                'tanggal_proposal',
                'title',
            ]);
    }

    /** @test */
    public function component_can_update_existing_permohonan()
    {
        $permohonan = Permohonan::factory()->create([
            'id_lembaga' => $this->lembaga->id,
            'id_skpd' => $this->skpd->id,
            'urusan' => $this->urusan->id,
        ]);

        $newFile = UploadedFile::fake()->create('updated_proposal.pdf', 1024, 'application/pdf');

        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class, ['id_permohonan' => $permohonan->id])
            ->assertSet('id_permohonan', $permohonan->id)
            ->set('title', 'Updated Program Title')
            ->set('file_proposal', $newFile)
            ->call('store')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'title' => 'Updated Program Title',
        ]);
    }

    /** @test */
    public function component_uploads_files_correctly()
    {
        $file_mohon = UploadedFile::fake()->create('permohonan.pdf', 1024, 'application/pdf');
        $file_proposal = UploadedFile::fake()->create('proposal.pdf', 1024, 'application/pdf');

        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->set('usulan_apbd', '2024')
            ->set('no_mohon', '001/HIBAH/2024')
            ->set('tanggal_mohon', '2024-01-15')
            ->set('perihal_mohon', 'Permohonan Hibah Test')
            ->set('file_mohon', $file_mohon)
            ->set('no_proposal', '001/PROP/2024')
            ->set('tanggal_proposal', '2024-01-16')
            ->set('title', 'Program Test Lembaga')
            ->set('id_skpd', $this->skpd->id)
            ->set('urusan', $this->urusan->id)
            ->set('awal_laksana', '2024-02-01')
            ->set('akhir_laksana', '2024-12-31')
            ->set('latar_belakang', 'Latar belakang program test')
            ->set('maksud_tujuan', 'Maksud dan tujuan program test')
            ->set('keterangan', 'Keterangan tambahan')
            ->set('file_proposal', $file_proposal)
            ->call('store');

        $permohonan = Permohonan::first();
        
        $this->assertNotNull($permohonan->file_mohon);
        $this->assertNotNull($permohonan->file_proposal);
        
        Storage::disk('public')->assertExists($permohonan->file_mohon);
        Storage::disk('public')->assertExists($permohonan->file_proposal);
    }

    /** @test */
    public function component_validates_file_types()
    {
        $invalidFile = UploadedFile::fake()->create('invalid.txt', 100, 'text/plain');

        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->set('file_mohon', $invalidFile)
            ->call('store')
            ->assertHasErrors(['file_mohon']);
    }

    /** @test */
    public function component_validates_date_logic()
    {
        $file_mohon = UploadedFile::fake()->create('permohonan.pdf', 1024, 'application/pdf');
        $file_proposal = UploadedFile::fake()->create('proposal.pdf', 1024, 'application/pdf');

        // tanggal_proposal tidak boleh lebih awal dari tanggal_mohon
        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->set('usulan_apbd', '2024')
            ->set('no_mohon', '001/HIBAH/2024')
            ->set('tanggal_mohon', '2024-01-15')
            ->set('perihal_mohon', 'Permohonan Hibah Test')
            ->set('file_mohon', $file_mohon)
            ->set('no_proposal', '001/PROP/2024')
            ->set('tanggal_proposal', '2024-01-10') // Earlier than tanggal_mohon
            ->set('title', 'Program Test Lembaga')
            ->set('id_skpd', $this->skpd->id)
            ->set('urusan', $this->urusan->id)
            ->set('awal_laksana', '2024-02-01')
            ->set('akhir_laksana', '2024-01-31') // Earlier than awal_laksana
            ->set('latar_belakang', 'Latar belakang program test')
            ->set('maksud_tujuan', 'Maksud dan tujuan program test')
            ->set('keterangan', 'Keterangan tambahan')
            ->set('file_proposal', $file_proposal)
            ->call('store')
            ->assertHasErrors(['tanggal_proposal', 'akhir_laksana']);
    }

    /** @test */
    public function component_can_select_skpd_and_load_urusan()
    {
        $urusan1 = UrusanSkpd::factory()->create(['id_skpd' => $this->skpd->id]);
        $urusan2 = UrusanSkpd::factory()->create(['id_skpd' => $this->skpd->id]);
        
        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->set('id_skpd', $this->skpd->id)
            ->call('loadUrusan')
            ->assertSet('urusans', function ($urusans) use ($urusan1, $urusan2) {
                return $urusans->contains($urusan1) && $urusans->contains($urusan2);
            });
    }

    /** @test */
    public function component_only_allows_lembaga_owner_to_access()
    {
        $otherUser = User::factory()->create(); // User without lembaga

        Livewire::actingAs($otherUser)
            ->test(CreateOrUpdate::class)
            ->assertForbidden();
    }

    /** @test */
    public function component_prevents_unauthorized_permohonan_edit()
    {
        $otherLembaga = Lembaga::factory()->create();
        $otherUser = User::factory()->create(['id_lembaga' => $otherLembaga->id]);
        
        $permohonan = Permohonan::factory()->create([
            'id_lembaga' => $this->lembaga->id, // Owned by different lembaga
        ]);

        Livewire::actingAs($otherUser)
            ->test(CreateOrUpdate::class, ['id_permohonan' => $permohonan->id])
            ->assertForbidden();
    }

    /** @test */
    public function component_can_cancel_and_redirect()
    {
        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->call('cancel')
            ->assertRedirect('/permohonan');
    }

    /** @test */
    public function component_validates_file_size_limits()
    {
        $largeFile = UploadedFile::fake()->create('large.pdf', 10240, 'application/pdf'); // 10MB

        Livewire::actingAs($this->user)
            ->test(CreateOrUpdate::class)
            ->set('file_mohon', $largeFile)
            ->call('store')
            ->assertHasErrors(['file_mohon']);
    }
}