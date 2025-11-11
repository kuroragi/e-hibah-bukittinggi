<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Livewire\Authenticate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

class AuthenticateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function component_can_render()
    {
        Livewire::test(Authenticate::class)
            ->assertOk();
    }

    #[Test]
    public function component_can_authenticate_valid_user()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123')
        ]);

        Livewire::test(Authenticate::class)
            ->set('email', 'user@example.com')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }

    #[Test]
    public function component_rejects_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123')
        ]);

        Livewire::test(Authenticate::class)
            ->set('email', 'user@example.com')
            ->set('password', 'wrongpassword')
            ->call('authenticate')
            ->assertSessionHas('error', 'Invalid credentials.');

        $this->assertFalse(Auth::check());
    }

    #[Test]
    public function component_validates_required_fields()
    {
        Livewire::test(Authenticate::class)
            ->call('authenticate')
            ->assertHasErrors(['email', 'password']);
    }

    #[Test]
    public function component_validates_email_format()
    {
        Livewire::test(Authenticate::class)
            ->set('email', 'invalid-email')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertHasErrors(['email']);
    }

    #[Test]
    public function component_validates_password_minimum_length()
    {
        Livewire::test(Authenticate::class)
            ->set('email', 'user@example.com')
            ->set('password', '123')
            ->call('authenticate')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_can_remember_user()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123')
        ]);

        Livewire::test(Authenticate::class)
            ->set('email', 'user@example.com')
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('authenticate')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(Auth::check());
        $this->assertNotNull(Auth::user()->getRememberToken());
    }

    #[Test]
    public function component_regenerates_session_on_successful_login()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123')
        ]);

        $originalSessionId = session()->getId();

        Livewire::test(Authenticate::class)
            ->set('email', 'user@example.com')
            ->set('password', 'password123')
            ->call('authenticate');

        $this->assertNotEquals($originalSessionId, session()->getId());
    }

    #[Test]
    public function component_rejects_non_existent_user()
    {
        Livewire::test(Authenticate::class)
            ->set('email', 'nonexistent@example.com')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertSessionHas('error', 'Invalid credentials.');

        $this->assertFalse(Auth::check());
    }

    #[Test]
    public function component_initializes_properties_correctly()
    {
        Livewire::test(Authenticate::class)
            ->assertSet('email', '')
            ->assertSet('password', '')
            ->assertSet('remember', false);
    }
}
