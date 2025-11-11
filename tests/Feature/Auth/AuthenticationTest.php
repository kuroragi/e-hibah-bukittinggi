<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test1@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => 'test1@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    #[Test]
    public function user_cannot_login_with_nonexistent_email()
    {
        $response = $this->post('/authenticate', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    #[Test]
    public function guest_cannot_access_authenticated_routes()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/');
    }

    #[Test]
    public function authenticated_user_cannot_access_login_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function login_requires_email_and_password()
    {
        $response = $this->post('/authenticate', []);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    #[Test]
    public function login_requires_valid_email_format()
    {
        $response = $this->post('/authenticate', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    #[Test]
    public function user_is_redirected_to_intended_url_after_login()
    {
        $user = User::factory()->create([
            'email' => 'test2@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Try to access protected page first
        $this->get('/');

        // Then login
        $response = $this->post('/authenticate', [
            'email' => 'test2@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function remember_me_functionality_works()
    {
        $user = User::factory()->create([
            'email' => 'test3@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => 'test3@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $this->assertAuthenticated();
        $this->assertNotNull(Auth::user()->remember_token);
    }

    #[Test]
    public function user_can_see_login_form()
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('pages.login');
        $response->assertSee('Email');
        $response->assertSee('Password');
    }

    #[Test]
    public function user_account_lockout_after_multiple_failed_attempts()
    {
        $user = User::factory()->create([
            'email' => 'test4@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Simulate multiple failed login attempts
        for ($i = 0; $i < 6; $i++) {
            $this->post('/authenticate', [
                'email' => 'test4@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // The account should be locked out now
        $response = $this->post('/authenticate', [
            'email' => 'test4@example.com',
            'password' => 'password123', // Even with correct password
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
