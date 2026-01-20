<x-mail::message>
# Payment Update

Hello {{ $transaction->user->name }},

We were unable to verify your manual payment proof for the **{{ $transaction->plan->name }}** plan, and your request has been declined.

<x-mail::panel>
**Reason for Rejection:**
{{ $transaction->admin_notes ?? 'The uploaded proof was insufficient or invalid. Please ensure the screenshot clearly shows the transaction details and reference.' }}
</x-mail::panel>

### What can you do?
You can re-upload a valid proof of payment through your transaction history or try a different payment method.

**Transaction Info:**
- **Reference:** {{ $transaction->reference }}
- **Plan:** {{ $transaction->plan->name }}

<x-mail::button :url="route('user.subscriptions')">
Try Again
</x-mail::button>

If you believe this is a mistake or need further assistance, please contact our support team.

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
