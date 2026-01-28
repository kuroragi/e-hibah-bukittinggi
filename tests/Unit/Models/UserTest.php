<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Role;
use App\Models\Skpd;
use App\Models\Lembaga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user dapat dibuat dengan data yang benar
     */
    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test user memiliki fillable attributes yang benar
     */
    public function test_user_has_correct_fillable_attributes(): void
    {
        $user = new User();
        
        $expectedFillable = [
            'name',
            'email',
            'password',
            'id_role',
            'id_skpd',
            'id_urusan',
            'id_lembaga',
        ];
        
        $this->assertEquals($expectedFillable, $user->getFillable());
    }

    /**
     * Test user memiliki hidden attributes yang benar
     */
    public function test_user_has_correct_hidden_attributes(): void
    {
        $user = new User();
        
        $expectedHidden = [
            'password',
            'remember_token',
        ];
        
        $this->assertEquals($expectedHidden, $user->getHidden());
    }

    /**
     * Test password di-hash secara otomatis
     */
    public function test_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'plainpassword',
        ]);

        $this->assertNotEquals('plainpassword', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('plainpassword', $user->password));
    }

    /**
     * Test relasi user dengan role
     */
    public function test_user_belongs_to_role(): void
    {
        // Create role first
        $role = Role::firstOrCreate(
            ['name' => 'test-role'],
            ['guard_name' => 'web']
        );
        
        $user = User::factory()->create([
            'id_role' => $role->id,
        ]);

        $this->assertInstanceOf(Role::class, $user->has_role);
        $this->assertEquals($role->id, $user->has_role->id);
    }

    /**
     * Test relasi user dengan SKPD
     */
    public function test_user_belongs_to_skpd(): void
    {
        $skpd = Skpd::factory()->create();
        
        $user = User::factory()->create([
            'id_skpd' => $skpd->id,
        ]);

        $this->assertInstanceOf(Skpd::class, $user->skpd);
        $this->assertEquals($skpd->id, $user->skpd->id);
    }

    /**
     * Test relasi user dengan Lembaga
     */
    public function test_user_belongs_to_lembaga(): void
    {
        $lembaga = Lembaga::factory()->create();
        
        $user = User::factory()->create([
            'id_lembaga' => $lembaga->id,
        ]);

        $this->assertInstanceOf(Lembaga::class, $user->lembaga);
        $this->assertEquals($lembaga->id, $user->lembaga->id);
    }

    /**
     * Test soft delete pada user
     */
    public function test_user_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        
        $userId = $user->id;
        $user->delete();

        // User tidak ditemukan di query normal
        $this->assertNull(User::find($userId));
        
        // User masih ada di database dengan deleted_at
        $this->assertNotNull(User::withTrashed()->find($userId));
        $this->assertNotNull(User::withTrashed()->find($userId)->deleted_at);
    }

    /**
     * Test user dapat di-restore setelah soft delete
     */
    public function test_user_can_be_restored_after_soft_delete(): void
    {
        $user = User::factory()->create();
        
        $userId = $user->id;
        $user->delete();
        
        // Restore user
        User::withTrashed()->find($userId)->restore();
        
        // User dapat ditemukan kembali
        $restoredUser = User::find($userId);
        $this->assertNotNull($restoredUser);
        $this->assertNull($restoredUser->deleted_at);
    }

    /**
     * Test email harus unik
     */
    public function test_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);
    }
}
