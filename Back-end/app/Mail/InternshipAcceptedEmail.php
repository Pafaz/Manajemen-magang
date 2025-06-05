<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class InternshipAcceptedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $internshipData;
    public $pdfPath;

    public function __construct($user, $internshipData, $pdfPath = null)
    {
        $this->user = $user;
        $this->internshipData = $internshipData;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Kamu Diterima Magang - ' . $this->internshipData['company_name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.internship-accepted',
            with: [
                'userName' => $this->user->nama,
                'companyName' => $this->internshipData['company_name'],
                'position' => $this->internshipData['position'],
                'startDate' => $this->internshipData['start_date'],
                'endDate' => $this->internshipData['end_date'],
                'contactPerson' => $this->internshipData['contact_person'] ?? null,
                'contactEmail' => $this->internshipData['contact_email'] ?? null,
                'contactPhone' => $this->internshipData['contact_phone'] ?? null,
                'address' => $this->internshipData['address'] ?? null,
                'additionalInfo' => $this->internshipData['additional_info'] ?? null,
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $attachments[] = Attachment::fromPath($this->pdfPath)
                ->as('Surat_Penerimaan_Magang.pdf')
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }
}