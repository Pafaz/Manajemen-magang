<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $internshipData;

    public function __construct($user, $internshipData = null)
    {
        $this->user = $user;
        $this->internshipData = $internshipData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Magang Berhasil - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-success',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'registrationDate' => now()->format('d M Y H:i'),
                'internshipData' => $this->internshipData,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}