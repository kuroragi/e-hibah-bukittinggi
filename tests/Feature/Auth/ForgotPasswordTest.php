<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserPassword;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test halaman forgot password dapat diakses
     */
    public function test_forgot_password_page_can_be_rendered(): void
    {
        $response = $this->get('/forgot_password');

        $response->assertStatus(200);
    }

    /**
     * Test reset password berhasil dengan email terdaftar
     */
    public function test_password_reset_with_registered_email(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $oldPassword = $user->password;

        $response = $this->post('/reset_password', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        // Verify email was sent
        Mail::assertQueued(SendUserPassword::class, function ($mail) {
            return true;
        });

        // Verify password was changed
        $user->refresh();
        $this->assertNotEquals($oldPassword, $user->password);
    }

    /**
     * Test reset password gagal dengan email tidak terdaftar
     */
    public function test_password_reset_fails_with_unregistered_email(): void
    {
        $response = $this->post('/reset_password', [
            'email' => 'notregistered@example.com',
        ]);

        $response->assertRedirect('/forgot_password');
        $response->assertSessionHas('danger');
    }

    /**
     * Test email wajib diisi untuk reset password
     */
    public function test_email_is_required_for_password_reset(): void
    {
        $response = $this->post('/reset_password', [
            'email' => '',
        ]);

        // Controller tidak memvalidasi, langsung redirect ke forgot_password dengan pesan danger
        // karena email kosong tidak akan ditemukan di database
        $response->assertRedirect('/forgot_password');
        $response->assertSessionHas('danger');
    }
}
