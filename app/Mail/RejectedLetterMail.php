<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectedLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $letter;

    /**
     * Create a new message instance.
     */
    public function __construct($letter)
    {
        $this->letter = $letter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if (!$this->letter->letter_number) {
            return new Envelope(
                subject: 'SIK Rejected',
            );
        }
        return new Envelope(
            subject: 'SIK Rejected: ' . $this->letter->letter_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return (new Content)
                    ->markdown('emails.rejected')
                    ->with([
                        'letter' => $this->letter,
                    ]);
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
