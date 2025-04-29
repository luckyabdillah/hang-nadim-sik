<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ApprovalStageMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $letter, $stage;

    /**
     * Create a new message instance.
     */
    public function __construct($letter, $stage)
    {
        $this->letter = $letter;
        $this->stage = $stage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Approval: ' . $this->letter->letter_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return (new Content)
                    ->markdown('emails.approval-stage')
                    ->with([
                        'letter' => $this->letter,
                        'stage' => $this->stage,
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
