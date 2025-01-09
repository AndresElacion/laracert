<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AnnouncementMail extends Mailable
{
    public $content; // Add property

    /**
     * Create a new message instance.
     */
    public function __construct($content)
    {
        $this->content = $content; // Assign value
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Announcement Created'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.announcements',
            with: ['content' => $this->content] // Pass variable to the view
        );
    }
}
