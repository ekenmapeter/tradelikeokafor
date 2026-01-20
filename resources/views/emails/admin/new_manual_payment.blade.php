<x-mail::message>
# New Manual Payment Proof Submitted

An admin review is required for a new manual payment submission.

**User Selection:**
- **User:** {{ $transaction->user->name }} ({{ $transaction->user->email }})
- **Plan:** {{ $transaction->plan->name }}
- **Amount:** ${{ number_format($transaction->amount, 2) }}
- **Reference:** {{ $transaction->reference }}
- **Submitted On:** {{ $transaction->created_at->format('M d, Y H:i') }}

<x-mail::button :url="route('admin.transactions.index')">
Review in Dashboard
</x-mail::button>

Please verify the payment against the bank statement and approve or reject the request accordingly.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
