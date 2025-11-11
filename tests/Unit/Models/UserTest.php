<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Permission;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_correct_fillable_attributes()
    {
        $expectedFillable = [
            'name',
            'email',
            'password',
            'id_role',
            'id_skpd',
            'id_urusan',
            'id_lembaga',
        ];

        $this->assertModelHasFillable(User::class, $expectedFillable);
    }

    #[Test]
    public function it_hides_sensitive_attributes()
    {
        $user = User::factory()->create();
        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    #[Test]
    public function it_casts_password_to_hashed_value()
    {
        $user = User::factory()->make();
        $casts = $user->getCasts();

        $this->assertEquals('hashed', $casts['password']);
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }

    #[Test]
    public function it_belongs_to_role()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['id_role' => $role->id]);

        $this->assertModelHasRelationship($user, 'has_role', BelongsTo::class);
        $this->assertEquals($role->id, $user->has_role->id);
    }

    #[Test]
    public function it_belongs_to_skpd()
    {
        $skpd = Skpd::factory()->create();
        $user = User::factory()->create(['id_skpd' => $skpd->id]);

        $this->assertModelHasRelationship($user, 'skpd', BelongsTo::class);
        $this->assertEquals($skpd->id, $user->skpd->id);
    }

    #[Test]
    public function it_belongs_to_lembaga()
    {
        $lembaga = Lembaga::factory()->create();
        $user = User::factory()->create(['id_lembaga' => $lembaga->id]);

        $this->assertModelHasRelationship($user, 'lembaga', BelongsTo::class);
        $this->assertEquals($lembaga->id, $user->lembaga->id);
    }

    #[Test]
    public function it_can_be_created_with_factory()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    #[Test]
    public function it_can_be_created_as_admin()
    {
        $user = User::factory()->admin()->create();

        $this->assertEquals('Admin User', $user->name);
        $this->assertEquals('admin@example.com', $user->email);
    }

    #[Test]
    public function it_can_be_created_as_lembaga_user()
    {
        $user = User::factory()->lembaga()->create();

        $this->assertEquals('Lembaga User', $user->name);
        $this->assertEquals('lembaga@example.com', $user->email);
        $this->assertNotNull($user->id_lembaga);
    }

    #[Test]
    public function it_can_be_created_as_skpd_user()
    {
        $user = User::factory()->skpd()->create();

        $this->assertEquals('SKPD User', $user->name);
        $this->assertEquals('skpd@example.com', $user->email);
        $this->assertNotNull($user->id_skpd);
    }

    #[Test]
    public function it_uses_spatie_permission_traits()
    {
        $user = User::factory()->create();

        $this->assertTrue(method_exists($user, 'assignRole'));
        $this->assertTrue(method_exists($user, 'hasRole'));
        $this->assertTrue(method_exists($user, 'givePermissionTo'));
        $this->assertTrue(method_exists($user, 'hasPermissionTo'));
    }

    #[Test]
    public function it_uses_soft_deletes()
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $userId]);
        $this->assertNotNull($user->fresh()->deleted_at);
    }

    #[Test]
    public function it_uses_blameable_trait()
    {
        $creator = User::factory()->create();
        $this->actingAs($creator);

        $user = User::factory()->create();

        $this->assertNotNull($user->created_by);
        // Note: Blameable trait should set created_by to current user
    }

    #[Test]
    public function email_should_be_unique()
    {
        $email = 'test@example.com';
        User::factory()->create(['email' => $email]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        User::factory()->create(['email' => $email]);
    }

    #[Test]
    public function it_requires_name_and_email()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        User::create([
            'password' => bcrypt('password'),
        ]);
    }
}
