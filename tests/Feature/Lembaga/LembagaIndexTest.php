<?php

namespace Tests\Feature\Lembaga;

use App\Models\User;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role as SpatieRole;
use Tests\TestCase;

class LembagaIndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create necessary roles
        SpatieRole::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'Admin SKPD', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'Admin Lembaga', 'guard_name' => 'web']);
    }

    /**
     * Test halaman lembaga tidak dapat diakses oleh guest
     */
    public function test_lembaga_index_requires_authentication(): void
    {
        $response = $this->get('/lembaga');

        $response->assertRedirect('/');
    }

    /**
     * Test user yang login dapat mengakses halaman lembaga
     */
    public function test_authenticated_user_can_access_lembaga_index(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $response = $this->actingAs($user)->get('/lembaga');

        $response->assertStatus(200);
    }

    /**
     * Test halaman create lembaga dapat diakses
     */
    public function test_lembaga_create_page_can_be_accessed(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $response = $this->actingAs($user)->get('/lembaga/create');

        $response->assertStatus(200);
    }
}
