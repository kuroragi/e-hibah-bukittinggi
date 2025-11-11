<?php

namespace Tests\Feature\Livewire\Lembaga;

use Tests\TestCase;
use App\Livewire\Lembaga\Profile;
use App\Models\User;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Propinsi;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $lembaga;
    protected $skpd;
    protected $urusan;
    protected $propinsi;
    protected $kabkota;
    protected $kecamatan;
    protected $kelurahan;

    protected function setUp(): void
    {
        parent::setUp();

        // Create geographical data
        $this->propinsi = Propinsi::factory()->create();
        $this->kabkota = KabKota::factory()->create(['id_propinsi' => $this->propinsi->id]);
        $this->kecamatan = Kecamatan::factory()->create(['id_kabkota' => $this->kabkota->id]);
        $this->kelurahan = Kelurahan::factory()->create(['id_kecamatan' => $this->kecamatan->id]);

        // Create organizational data
        $this->skpd = Skpd::factory()->create();
        $this->urusan = UrusanSkpd::factory()->create(['id_skpd' => $this->skpd->id]);
        
        $this->lembaga = Lembaga::factory()->create([
            'id_skpd' => $this->skpd->id,
            'id_urusan' => $this->urusan->id,
            'id_kelurahan' => $this->kelurahan->id,
        ]);

        $this->user = User::factory()->create([
            'id_lembaga' => $this->lembaga->id
        ]);
    }

    #[Test]
    public function component_can_render()
    {
        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->assertOk();
    }

    #[Test]
    public function component_loads_lembaga_data_on_mount()
    {
        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->assertSet('id_lembaga', $this->lembaga->id)
            ->assertSet('name', $this->lembaga->name)
            ->assertSet('email', $this->lembaga->email)
            ->assertSet('phone', $this->lembaga->phone)
            ->assertSet('alamat', $this->lembaga->alamat)
            ->assertSet('id_skpd', $this->lembaga->id_skpd)
            ->assertSet('id_urusan', $this->lembaga->id_urusan);
    }

    #[Test]
    public function component_can_update_lembaga_profile()
    {
        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('name', 'Updated Lembaga Name')
            ->set('email', 'updated@example.com')
            ->set('phone', '08123456789')
            ->set('alamat', 'Updated Address')
            ->call('update')
            ->assertHasNoErrors()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('lembagas', [
            'id' => $this->lembaga->id,
            'name' => 'Updated Lembaga Name',
            'email' => 'updated@example.com',
            'phone' => '08123456789',
            'alamat' => 'Updated Address',
        ]);
    }

    #[Test]
    public function component_validates_required_fields()
    {
        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('name', '')
            ->set('email', '')
            ->set('phone', '')
            ->set('alamat', '')
            ->set('id_skpd', '')
            ->set('id_urusan', '')
            ->call('update')
            ->assertHasErrors([
                'name',
                'email', 
                'phone',
                'alamat',
                'id_skpd',
                'id_urusan'
            ]);
    }

    #[Test]
    public function component_loads_geographical_cascade()
    {
        $component = Livewire::actingAs($this->user)
            ->test(Profile::class);

        // Test propinsi selection loads kabkotas
        $component->set('propinsi', $this->propinsi->id)
            ->call('loadKabKota')
            ->assertCount('kabkotas', 1);

        // Test kabkota selection loads kecamatans
        $component->set('kabkota', $this->kabkota->id)
            ->call('loadKecamatan')
            ->assertCount('kecamatans', 1);

        // Test kecamatan selection loads kelurahans
        $component->set('kecamatan', $this->kecamatan->id)
            ->call('loadKelurahan')
            ->assertCount('kelurahans', 1);
    }

    #[Test]
    public function component_loads_urusan_based_on_skpd()
    {
        $newSkpd = Skpd::factory()->create();
        $newUrusan1 = UrusanSkpd::factory()->create(['id_skpd' => $newSkpd->id]);
        $newUrusan2 = UrusanSkpd::factory()->create(['id_skpd' => $newSkpd->id]);

        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('id_skpd', $newSkpd->id)
            ->call('loadUrusan')
            ->assertCount('urusan', 2);
    }

    #[Test]
    public function component_validates_email_format()
    {
        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('email', 'invalid-email')
            ->call('update')
            ->assertHasErrors(['email']);
    }

    #[Test]
    public function component_only_allows_lembaga_owner_access()
    {
        $otherUser = User::factory()->create(); // User without lembaga

        Livewire::actingAs($otherUser)
            ->test(Profile::class)
            ->assertForbidden();
    }

    #[Test]
    public function component_logs_profile_update_activity()
    {
        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('name', 'Updated Lembaga Name')
            ->call('update');

        // Verify activity log was created
        $this->assertDatabaseHas('activity_log', [
            'causer_id' => $this->user->id,
            'subject_id' => $this->lembaga->id,
            'subject_type' => Lembaga::class,
            'event' => 'lembaga.update-profile',
        ]);
    }

    #[Test]
    public function component_handles_geographical_data_reset()
    {
        $component = Livewire::actingAs($this->user)
            ->test(Profile::class);

        // Set initial geographical data
        $component->set('propinsi', $this->propinsi->id)
            ->call('loadKabKota')
            ->set('kabkota', $this->kabkota->id)
            ->call('loadKecamatan');

        // Change propinsi should reset kabkota and below
        $newPropinsi = Propinsi::factory()->create();
        $component->set('propinsi', $newPropinsi->id)
            ->call('loadKabKota')
            ->assertSet('kabkota', null)
            ->assertSet('kecamatan', null)
            ->assertSet('kelurahan', null);
    }

    #[Test]
    public function component_preserves_non_geographical_data_on_update()
    {
        $originalDescription = $this->lembaga->deskripsi;

        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('name', 'Updated Name')
            ->call('update');

        $this->lembaga->refresh();
        $this->assertEquals($originalDescription, $this->lembaga->deskripsi);
    }

    #[Test]
    public function component_updates_geographical_location()
    {
        $newPropinsi = Propinsi::factory()->create();
        $newKabkota = KabKota::factory()->create(['id_propinsi' => $newPropinsi->id]);
        $newKecamatan = Kecamatan::factory()->create(['id_kabkota' => $newKabkota->id]);
        $newKelurahan = Kelurahan::factory()->create(['id_kecamatan' => $newKecamatan->id]);

        Livewire::actingAs($this->user)
            ->test(Profile::class)
            ->set('propinsi', $newPropinsi->id)
            ->set('kabkota', $newKabkota->id)
            ->set('kecamatan', $newKecamatan->id)
            ->set('kelurahan', $newKelurahan->id)
            ->call('update');

        $this->assertDatabaseHas('lembagas', [
            'id' => $this->lembaga->id,
            'propinsi' => $newPropinsi->id,
            'kabkota' => $newKabkota->id,
            'kecamatan' => $newKecamatan->id,
            'kelurahan' => $newKelurahan->id,
        ]);
    }
}
