<x-mail::message>
# Payment Approved! 🎉

Hello {{ $transaction->user->name }},

Great news! Your manual payment for the **{{ $transaction->plan->name }}** plan has been successfully verified and approved.

Your subscription is now **Active**. You can now enjoy full access to all the benefits of your chosen plan.

<x-mail::panel>
**Subscription Details:**
- **Plan:** {{ $transaction->plan->name }}
- **Price:** ${{ number_format($transaction->amount, 2) }}
- **Start Date:** {{ now()->format('M d, Y') }}
- **Reference:** {{ $transaction->reference }}
</x-mail::panel>

<x-mail::button :url="route('user.dashboard')">
Go to Dashboard
</x-mail::button>

Thank you for choosing **{{ config('app.name') }}**. We're excited to have you on board!

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
