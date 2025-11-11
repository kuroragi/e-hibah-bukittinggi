<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Permission;

class AuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    protected $adminRole;
    protected $skpdRole;
    protected $lembagaRole;
    protected $createPermohonanPermission;
    protected $viewPermohonanPermission;
    protected $editPermohonanPermission;
    protected $deletePermohonanPermission;
    protected $approvePermohonanPermission;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        $this->adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->skpdRole = Role::create(['name' => 'skpd', 'guard_name' => 'web']);
        $this->lembagaRole = Role::create(['name' => 'lembaga', 'guard_name' => 'web']);
        
        // Create permissions
        $this->createPermohonanPermission = Permission::create(['name' => 'create permohonan', 'guard_name' => 'web']);
        $this->viewPermohonanPermission = Permission::create(['name' => 'view permohonan', 'guard_name' => 'web']);
        $this->editPermohonanPermission = Permission::create(['name' => 'edit permohonan', 'guard_name' => 'web']);
        $this->deletePermohonanPermission = Permission::create(['name' => 'delete permohonan', 'guard_name' => 'web']);
        $this->approvePermohonanPermission = Permission::create(['name' => 'approve permohonan', 'guard_name' => 'web']);
        
        // Assign permissions to roles
        $this->adminRole->givePermissionTo([
            'view permohonan',
            'edit permohonan', 
            'delete permohonan',
            'approve permohonan'
        ]);
        
        $this->skpdRole->givePermissionTo([
            'view permohonan',
            'edit permohonan',
            'approve permohonan'
        ]);
        
        $this->lembagaRole->givePermissionTo([
            'create permohonan',
            'view permohonan',
            'edit permohonan'
        ]);
    }

    #[Test]
    public function admin_can_access_all_permohonan_functions()
    {
        $admin = User::factory()->create();
        $admin->assignRole($this->adminRole);

        $this->assertTrue($admin->hasPermissionTo('view permohonan'));
        $this->assertTrue($admin->hasPermissionTo('edit permohonan'));
        $this->assertTrue($admin->hasPermissionTo('delete permohonan'));
        $this->assertTrue($admin->hasPermissionTo('approve permohonan'));
        $this->assertFalse($admin->hasPermissionTo('create permohonan'));
    }

    #[Test]
    public function skpd_user_can_view_and_approve_permohonan()
    {
        $skpdUser = User::factory()->create();
        $skpdUser->assignRole($this->skpdRole);

        $this->assertTrue($skpdUser->hasPermissionTo('view permohonan'));
        $this->assertTrue($skpdUser->hasPermissionTo('edit permohonan'));
        $this->assertTrue($skpdUser->hasPermissionTo('approve permohonan'));
        $this->assertFalse($skpdUser->hasPermissionTo('create permohonan'));
        $this->assertFalse($skpdUser->hasPermissionTo('delete permohonan'));
    }

    #[Test]
    public function lembaga_user_can_create_and_edit_permohonan()
    {
        $lembagaUser = User::factory()->create();
        $lembagaUser->assignRole($this->lembagaRole);

        $this->assertTrue($lembagaUser->hasPermissionTo('create permohonan'));
        $this->assertTrue($lembagaUser->hasPermissionTo('view permohonan'));
        $this->assertTrue($lembagaUser->hasPermissionTo('edit permohonan'));
        $this->assertFalse($lembagaUser->hasPermissionTo('delete permohonan'));
        $this->assertFalse($lembagaUser->hasPermissionTo('approve permohonan'));
    }

    #[Test]
    public function user_has_correct_role()
    {
        $adminUser = User::factory()->create();
        $adminUser->assignRole($this->adminRole);

        $skpdUser = User::factory()->create();
        $skpdUser->assignRole($this->skpdRole);

        $lembagaUser = User::factory()->create();
        $lembagaUser->assignRole($this->lembagaRole);

        $this->assertTrue($adminUser->hasRole('admin'));
        $this->assertFalse($adminUser->hasRole('skpd'));
        $this->assertFalse($adminUser->hasRole('lembaga'));

        $this->assertTrue($skpdUser->hasRole('skpd'));
        $this->assertFalse($skpdUser->hasRole('admin'));
        $this->assertFalse($skpdUser->hasRole('lembaga'));

        $this->assertTrue($lembagaUser->hasRole('lembaga'));
        $this->assertFalse($lembagaUser->hasRole('admin'));
        $this->assertFalse($lembagaUser->hasRole('skpd'));
    }

    #[Test]
    public function user_can_be_assigned_multiple_roles()
    {
        $user = User::factory()->create();
        $user->assignRole([$this->adminRole, $this->skpdRole]);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasRole('skpd'));
        $this->assertFalse($user->hasRole('lembaga'));
    }

    #[Test]
    public function user_can_be_given_direct_permissions()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('create permohonan');

        $this->assertTrue($user->hasPermissionTo('create permohonan'));
        $this->assertFalse($user->hasPermissionTo('delete permohonan'));
    }

    #[Test]
    public function role_permissions_can_be_revoked()
    {
        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);
        $role->givePermissionTo('view permohonan');
        
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasPermissionTo('view permohonan'));

        $role->revokePermissionTo('view permohonan');
        $user->refresh(); // Refresh to clear cached permissions

        $this->assertFalse($user->hasPermissionTo('view permohonan'));
    }

    #[Test]
    public function user_direct_permissions_can_be_revoked()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('create permohonan');

        $this->assertTrue($user->hasPermissionTo('create permohonan'));

        $user->revokePermissionTo('create permohonan');

        $this->assertFalse($user->hasPermissionTo('create permohonan'));
    }

    #[Test]
    public function user_permissions_include_role_and_direct_permissions()
    {
        $user = User::factory()->create();
        $user->assignRole($this->lembagaRole); // Has 'create permohonan' via role
        $user->givePermissionTo('delete permohonan'); // Direct permission

        $this->assertTrue($user->hasPermissionTo('create permohonan')); // From role
        $this->assertTrue($user->hasPermissionTo('delete permohonan')); // Direct
        $this->assertFalse($user->hasPermissionTo('approve permohonan')); // Neither
    }

    #[Test]
    public function middleware_can_check_permissions()
    {
        // Create test route with permission middleware
        Route::get('/test-permission-route', function () {
            return 'success';
        })->middleware(['auth', 'permission:view permohonan']);

        $userWithPermission = User::factory()->create();
        $userWithPermission->assignRole($this->adminRole);

        $userWithoutPermission = User::factory()->create();

        // User with permission should access the route
        $response = $this->actingAs($userWithPermission)->get('/test-permission-route');
        $response->assertOk();

        // User without permission should be forbidden
        $response = $this->actingAs($userWithoutPermission)->get('/test-permission-route');
        $response->assertStatus(403);
    }

    #[Test]
    public function middleware_can_check_roles()
    {
        // Create test route with role middleware
        Route::get('/test-role-route', function () {
            return 'success';
        })->middleware(['auth', 'role:admin']);

        $adminUser = User::factory()->create();
        $adminUser->assignRole($this->adminRole);

        $regularUser = User::factory()->create();

        // Admin should access the route
        $response = $this->actingAs($adminUser)->get('/test-role-route');
        $response->assertOk();

        // Regular user should be forbidden
        $response = $this->actingAs($regularUser)->get('/test-role-route');
        $response->assertStatus(403);
    }

    #[Test]
    public function super_admin_has_all_permissions()
    {
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole($superAdminRole);

        // Super admin should have all permissions even without explicit assignment
        $this->assertTrue($superAdmin->hasPermissionTo('create permohonan'));
        $this->assertTrue($superAdmin->hasPermissionTo('view permohonan'));
        $this->assertTrue($superAdmin->hasPermissionTo('edit permohonan'));
        $this->assertTrue($superAdmin->hasPermissionTo('delete permohonan'));
        $this->assertTrue($superAdmin->hasPermissionTo('approve permohonan'));
        
        // Even non-existent permissions
        $this->assertTrue($superAdmin->hasPermissionTo('any random permission'));
    }
}
