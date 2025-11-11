<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use App\Services\ActivityLogService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class ActivityLogServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    #[Test]
    public function service_can_log_activity()
    {
        ActivityLogService::log(
            'test.action',
            'info',
            'Test activity description'
        );

        $this->assertDatabaseHas('activity_log', [
            'event' => 'test.action',
            'log_level' => 'info',
            'description' => 'Test activity description',
            'causer_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function service_logs_with_different_levels()
    {
        $levels = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];

        foreach ($levels as $level) {
            ActivityLogService::log(
                "test.{$level}",
                $level,
                "Test {$level} message"
            );

            $this->assertDatabaseHas('activity_log', [
                'event' => "test.{$level}",
                'log_level' => $level,
                'description' => "Test {$level} message",
            ]);
        }
    }

    #[Test]
    public function service_can_log_with_subject()
    {
        $subject = User::factory()->create();

        ActivityLogService::log(
            'user.created',
            'info',
            'User was created',
            $subject
        );

        $this->assertDatabaseHas('activity_log', [
            'event' => 'user.created',
            'subject_id' => $subject->id,
            'subject_type' => User::class,
        ]);
    }

    #[Test]
    public function service_can_log_with_properties()
    {
        $properties = [
            'old_value' => 'old',
            'new_value' => 'new',
            'field' => 'name'
        ];

        ActivityLogService::log(
            'model.updated',
            'info',
            'Model was updated',
            null,
            $properties
        );

        $this->assertDatabaseHas('activity_log', [
            'event' => 'model.updated',
            'properties' => json_encode($properties),
        ]);
    }

    #[Test]
    public function service_logs_without_authenticated_user()
    {
        $this->app['auth']->logout();

        ActivityLogService::log(
            'system.action',
            'info',
            'System action performed'
        );

        $this->assertDatabaseHas('activity_log', [
            'event' => 'system.action',
            'causer_id' => null,
        ]);
    }

    #[Test]
    public function service_handles_empty_description()
    {
        ActivityLogService::log('test.empty', 'info', '');

        $this->assertDatabaseHas('activity_log', [
            'event' => 'test.empty',
            'description' => '',
        ]);
    }

    #[Test]
    public function service_handles_null_description()
    {
        ActivityLogService::log('test.null', 'info', null);

        $this->assertDatabaseHas('activity_log', [
            'event' => 'test.null',
            'description' => null,
        ]);
    }
}
