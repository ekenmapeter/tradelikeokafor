<?php

namespace App\Mail\Admin;

use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $amount;
    public $plan;
    public $reference;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $amount, SubscriptionPlan $plan = null, $reference = null)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->plan = $plan;
        $this->reference = $reference;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Payment Received - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new_payment',
        );
    }
}
