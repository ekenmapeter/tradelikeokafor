<?php

namespace App\Mail;

use App\Models\EbookOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EbookApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(EbookOrder $order)
    {
        $this->order = $order->load('ebook');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Ebook is Ready! - ' . $this->order->ebook->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ebook_approved',
        );
    }

    public function attachments(): array
    {
        $pdfPath = Storage::disk('public')->path($this->order->ebook->pdf_file);

        if (file_exists($pdfPath)) {
            return [
                Attachment::fromPath($pdfPath)
                    ->as($this->order->ebook->title . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
