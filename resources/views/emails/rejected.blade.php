@component('mail::message')

Dear {{ $letter->vendor->name }},

We regret to inform you that your work permit application has been rejected. Kindly review the remarks provided by our internal approver for further details.

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