<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminEnquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Enquiry $enquiry)
    {
        $this->enquiry->loadMissing(['package.destination']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Enquiry Received - SG Holidays',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry.admin-notification',
        );
    }
}
