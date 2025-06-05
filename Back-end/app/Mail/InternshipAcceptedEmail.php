<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        
        if ($this->pdfPath) {
            Log::info('Attempting to attach PDF', ['pdf_path' => $this->pdfPath]);
            
            try {
                // Gunakan disk public langsung
                $attachments[] = Attachment::fromStorageDisk('public', $this->pdfPath)
                    ->as('Surat-Penerimaan-Magang.pdf')
                    ->withMime('application/pdf');
                
                Log::info('PDF attachment added successfully from public disk');
            } catch (\Exception $e) {
                Log::error('Failed to attach PDF', [
                    'error' => $e->getMessage(),
                    'pdf_path' => $this->pdfPath
                ]);
                
                // Fallback: coba dengan path langsung
                $fullPath = storage_path('app/public/' . $this->pdfPath);
                if (file_exists($fullPath)) {
                    $attachments[] = Attachment::fromPath($fullPath)
                        ->as('Surat-Penerimaan-Magang.pdf')
                        ->withMime('application/pdf');
                    
                    Log::info('PDF attachment added via fallback method');
                }
            }
        }
        
        return $attachments;
    }
}