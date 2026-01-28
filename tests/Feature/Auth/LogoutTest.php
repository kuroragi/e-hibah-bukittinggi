<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user dapat logout
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test session ter-invalidate setelah logout
     */
    public function test_session_is_invalidated_after_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        // Check user authenticated
        $this->assertAuthenticatedAs($user);
        
        // Logout
        $response = $this->delete('/logout');
        
        // Check guest
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test guest tidak dapat mengakses logout route
     */
    public function test_guest_cannot_access_logout(): void
    {
        $response = $this->delete('/logout');

        $response->assertRedirect('/');
    }
}
