<x-mail::message>
# Manual Payment Proof Received

Hello {{ $transaction->user->name }},

We have received your manual payment proof for the **{{ $transaction->plan->name }}** plan. Our team is currently reviewing your submission.

<x-mail::panel>
**Transaction Summary:**
- **Reference:** {{ $transaction->reference }}
- **Plan:** {{ $transaction->plan->name }}
- **Amount:** ${{ number_format($transaction->amount, 2) }}
- **Date:** {{ $transaction->created_at->format('M d, Y') }}
</x-mail::panel>

### What's next?
We will verify the payment within 24-48 hours. Once approved, your subscription will be activated automatically, and you will receive another email confirmation.

<x-mail::button :url="route('user.transactions')">
Track Transaction
</x-mail::button>

If you have any questions, feel free to contact our support team.

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
