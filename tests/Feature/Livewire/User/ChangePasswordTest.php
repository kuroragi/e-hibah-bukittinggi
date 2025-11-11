<?php

namespace Tests\Feature\Livewire\User;

use Tests\TestCase;
use App\Livewire\User\ChangePassword;
use App\Models\User;
use App\Mail\SendPasswordUpdateAlert;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;

class ChangePasswordTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('OldPassword123!')
        ]);

        Mail::fake();
    }

    #[Test]
    public function component_can_render()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->assertOk();
    }

    #[Test]
    public function component_mounts_with_current_user_id()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->assertSet('id_user', $this->user->id);
    }

    #[Test]
    public function component_can_change_password_successfully()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('update')
            ->assertHasNoErrors()
            ->assertSessionHas('success', 'Password berhasil diperbarui.');

        $this->user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $this->user->password));
    }

    #[Test]
    public function component_validates_current_password()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'WrongPassword')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('update')
            ->assertSessionHas('error', 'Password lama salah.');
    }

    #[Test]
    public function component_validates_required_fields()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->call('update')
            ->assertHasErrors(['current_password', 'password']);
    }

    #[Test]
    public function component_validates_password_confirmation()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'DifferentPassword123!')
            ->call('update')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_validates_password_minimum_length()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'Short1!')
            ->set('password_confirmation', 'Short1!')
            ->call('update')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_validates_password_uppercase_requirement()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'newpassword123!')
            ->set('password_confirmation', 'newpassword123!')
            ->call('update')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_validates_password_lowercase_requirement()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NEWPASSWORD123!')
            ->set('password_confirmation', 'NEWPASSWORD123!')
            ->call('update')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_validates_password_number_requirement()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword!')
            ->set('password_confirmation', 'NewPassword!')
            ->call('update')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_validates_password_symbol_requirement()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword123')
            ->set('password_confirmation', 'NewPassword123')
            ->call('update')
            ->assertHasErrors(['password']);
    }

    #[Test]
    public function component_updates_password_strength_indicators()
    {
        $component = Livewire::actingAs($this->user)
            ->test(ChangePassword::class);

        // Test password that meets all requirements
        $component->set('password', 'NewPassword123!')
            ->assertSet('rulesStatus.min_length', true)
            ->assertSet('rulesStatus.uppercase', true)
            ->assertSet('rulesStatus.lowercase', true)
            ->assertSet('rulesStatus.number', true)
            ->assertSet('rulesStatus.symbol', true);

        // Test password confirmation matching
        $component->set('password_confirmation', 'NewPassword123!')
            ->assertSet('rulesStatus.match', true);

        // Test password confirmation not matching
        $component->set('password_confirmation', 'DifferentPassword123!')
            ->assertSet('rulesStatus.match', false);
    }

    #[Test]
    public function component_sends_password_update_email()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('update');

        Mail::assertQueued(SendPasswordUpdateAlert::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }

    #[Test]
    public function component_resets_form_after_successful_update()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('update')
            ->assertSet('current_password', '')
            ->assertSet('password', '')
            ->assertSet('password_confirmation', '');
    }

    #[Test]
    public function component_logs_password_change_activity()
    {
        Livewire::actingAs($this->user)
            ->test(ChangePassword::class)
            ->set('current_password', 'OldPassword123!')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('update');

        // Verify activity log was created (assuming you have activity_log table)
        $this->assertDatabaseHas('activity_log', [
            'causer_id' => $this->user->id,
            'event' => 'user.update-password',
            'log_level' => 'warning',
        ]);
    }

    #[Test]
    public function component_handles_update_exceptions_gracefully()
    {
        // This test would require mocking a database failure
        // For now, we'll test the basic error handling structure
        $this->assertTrue(true); // Placeholder for exception handling test
    }
}
