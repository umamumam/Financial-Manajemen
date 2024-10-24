<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DataUpdatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $oldData;
    public $newData;

    /**
     * Create a new message instance.
     */
    public function __construct($oldData, $newData)
    {
        $this->oldData = $oldData;
        $this->newData = $newData;
    }

    public function build()
    {
        return $this->view('emails.data_updated') // Pastikan view ini ada di resources/views/emails/data_updated.blade.php
                    ->with([
                        'oldData' => $this->oldData,
                        'newData' => $this->newData,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Data Updated Notification',
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
