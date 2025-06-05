<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternshipRejectedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $internshipData;
    public $rejectionReason;

    public function __construct($user, $internshipData, $rejectionReason = null)
    {
        $this->user = $user;
        $this->internshipData = $internshipData;
        $this->rejectionReason = $rejectionReason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Status Pendaftaran Magang - ' . $this->internshipData['company_name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.internship-rejected',
            with: [
                'userName' => $this->user->nama,
                'companyName' => $this->internshipData['company_name'],
                'position' => $this->internshipData['position'],
                'rejectionReason' => $this->rejectionReason,
                'appliedDate' => $this->internshipData['applied_date'] ?? now()->format('d M Y'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}