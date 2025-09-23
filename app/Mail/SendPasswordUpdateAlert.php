<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPasswordUpdateAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $datetime, $ip_address, $user_agent;

    /**
     * Create a new message instance.
     */
    public function __construct($datetime, $ip_address, $user_agent)
    {
        $this->datetime = $datetime;
        $this->ip_address = $ip_address;
        $this->user_agent = $user_agent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Perubahan Password E-Hibah Bukittinggi',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send-password-update-alert',
            with: [
                'datetime' => $this->datetime,
                'ip_address' => $this->ip_address,
                'user_agent' => $this->user_agent,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
