@component('mail::message')

Dear Team,

New work permit letter has been submitted. Kindly check and verify the application.

@component('mail::button', ['url' => config('app.url') . "/dashboard/work-permit-letters/$letter->uuid"])
View Letter
@endcomponent

@component('mail::subcopy')
If you're having trouble clicking the "View Letter" button, copy and paste the URL below into your web browser: [{{ config('app.url') }}/dashboard/work-permit-letters/{{ $letter->uuid }}]({{ config('app.url') }}/dashboard/work-permit-letters/{{ $letter->uuid }})
@endcomponent

@endcomponent