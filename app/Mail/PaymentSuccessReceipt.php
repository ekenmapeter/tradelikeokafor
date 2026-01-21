<?php

namespace App\Mail;

use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $amount;
    public $plan;
    public $tempPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $amount, SubscriptionPlan $plan = null, $tempPassword = null)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->plan = $plan;
        $this->tempPassword = $tempPassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Receipt - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_receipt',
        );
    }
}
