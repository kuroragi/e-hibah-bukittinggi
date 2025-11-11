<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Livewire\User as UserLivewire;
use App\Models\User;
use App\Models\Lembaga;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;

class UserLivewireTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;
    protected $lembaga;
    protected $skpd;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'skpd']);
        Role::create(['name' => 'lembaga']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->lembaga = Lembaga::factory()->create();
        $this->skpd = \App\Models\Skpd::factory()->create();
    }

    #[Test]
    public function component_can_render_for_admin()
    {
        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->assertOk();
    }

    #[Test]
    public function component_displays_users_list()
    {
        $user1 = User::factory()->create(['name' => 'Test User 1']);
        $user2 = User::factory()->create(['name' => 'Test User 2']);

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->assertSee('Test User 1')
            ->assertSee('Test User 2');
    }

    #[Test]
    public function component_can_search_users()
    {
        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Smith']);

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->set('search', 'John')
            ->assertSee('John Doe')
            ->assertDontSee('Jane Smith');
    }

    #[Test]
    public function component_can_create_new_user()
    {
        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('selectedRole', 'lembaga')
            ->set('id_lembaga', $this->lembaga->id)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'id_lembaga' => $this->lembaga->id,
        ]);

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertTrue($user->hasRole('lembaga'));
    }

    #[Test]
    public function component_validates_required_fields()
    {
        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->call('save')
            ->assertHasErrors(['name', 'email', 'password', 'selectedRole']);
    }

    #[Test]
    public function component_validates_unique_email()
    {
        $existingUser = User::factory()->create(['email' => 'existing@example.com']);

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->set('name', 'New User')
            ->set('email', 'existing@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('selectedRole', 'admin')
            ->call('save')
            ->assertHasErrors(['email']);
    }

    #[Test]
    public function component_can_update_existing_user()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com'
        ]);

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->call('edit', $user->id)
            ->set('name', 'Updated Name')
            ->set('email', 'updated@example.com')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    #[Test]
    public function component_can_delete_user()
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->call('destroy', $user->id)
            ->assertHasNoErrors();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    #[Test]
    public function component_can_restore_deleted_user()
    {
        $user = User::factory()->create();
        $user->delete();

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->call('restore', $user->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    #[Test]
    public function component_assigns_role_correctly_on_user_creation()
    {
        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->set('name', 'SKPD User')
            ->set('email', 'skpd@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('selectedRole', 'skpd')
            ->set('id_skpd', $this->skpd->id)
            ->call('save')
            ->assertHasNoErrors();

        $user = User::where('email', 'skpd@example.com')->first();
        $this->assertTrue($user->hasRole('skpd'));
        $this->assertEquals($this->skpd->id, $user->id_skpd);
    }

    #[Test]
    public function component_resets_form_after_save()
    {
        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('selectedRole', 'admin')
            ->call('save')
            ->assertSet('name', '')
            ->assertSet('email', '')
            ->assertSet('password', '')
            ->assertSet('selectedRole', '');
    }

    #[Test]
    public function component_shows_confirmation_before_delete()
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(UserLivewire::class)
            ->call('confirmDelete', $user->id)
            ->assertSet('confirmingDeletion', true)
            ->assertSet('userToDelete', $user->id);
    }
}
