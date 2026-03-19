<?php

namespace App\Mail;

use App\Models\EbookOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EbookDeclined extends Mailable
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
            subject: 'Order Update - ' . $this->order->ebook->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ebook_declined',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
