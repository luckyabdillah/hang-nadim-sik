@component('mail::message')

Dear {{ $letter->vendor->name }},

Your work permit letter has been successfully approved. Kindly check the PDF version or download QR code.

@component('mail::button', ['url' => config('app.url') . "/dashboard/my/work-permit-letters/$letter->uuid"])
View Letter
@endcomponent

If you did not initiate this action or suspect any email misuse, please contact our support team immediately at [info@sik.bthairport.com](mailto:info@sik.bthairport.com).

Regards,<br>
{{ config('app.name') }}

@component('mail::subcopy')
If you're having trouble clicking the "View Letter" button, copy and paste the URL below into your web browser: [{{ config('app.url') }}/dashboard/my/work-permit-letters/{{ $letter->uuid }}]({{ config('app.url') }}/dashboard/my/work-permit-letters/{{ $letter->uuid }})
@endcomponent

@endcomponent