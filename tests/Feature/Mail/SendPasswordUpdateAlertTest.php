<?php

namespace Tests\Feature\Mail;

use Tests\TestCase;
use App\Mail\SendPasswordUpdateAlert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendPasswordUpdateAlertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mail_can_be_built()
    {
        $timestamp = now();
        $ipAddress = '192.168.1.1';
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';

        $mail = new SendPasswordUpdateAlert($timestamp, $ipAddress, $userAgent);

        $this->assertNotNull($mail);
        $this->assertEquals($timestamp, $mail->datetime);
        $this->assertEquals($ipAddress, $mail->ip_address);
        $this->assertEquals($userAgent, $mail->user_agent);
    }

    /** @test */
    public function mail_has_correct_subject()
    {
        $mail = new SendPasswordUpdateAlert(now(), '192.168.1.1', 'Test User Agent');
        
        $this->assertEquals('Password Update Alert', $mail->build()->subject);
    }

    /** @test */
    public function mail_contains_required_information()
    {
        $timestamp = now();
        $ipAddress = '192.168.1.1';
        $userAgent = 'Mozilla/5.0 Test Agent';

        $mail = new SendPasswordUpdateAlert($timestamp, $ipAddress, $userAgent);
        $rendered = $mail->build()->render();

        $this->assertStringContainsString($timestamp->format('Y-m-d H:i:s'), $rendered);
        $this->assertStringContainsString($ipAddress, $rendered);
        $this->assertStringContainsString($userAgent, $rendered);
    }

    /** @test */
    public function mail_can_be_sent_to_user()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);
        $mail = new SendPasswordUpdateAlert(now(), '192.168.1.1', 'Test Agent');

        $this->assertTrue($mail->hasTo($user->email));
    }
}