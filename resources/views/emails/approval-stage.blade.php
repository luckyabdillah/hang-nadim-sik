@component('mail::message')

Dear {{ $stage->name }},

You have a pending work permit letter approval. Please approve the letter at your earliest convenience.

@component('mail::button', ['url' => config('app.url') . "/dashboard/approvals/$stage->id"])
Approve Now
@endcomponent

{{-- This quotation will expire in hours. --}}

If you did not initiate this action or suspect any email misuse, please contact our support team immediately at [info@sik.bthairport.com](mailto:info@sik.bthairport.com).

Regards,<br>
{{ config('app.name') }}

@component('mail::subcopy')
If you're having trouble clicking the "Approve Now" button, copy and paste the URL below into your web browser: [{{ config('app.url') }}/dashboard/approvals/{{ $stage->id }}]({{ config('app.url') }}/dashboard/approvals/{{ $stage->id }})
@endcomponent

@endcomponent