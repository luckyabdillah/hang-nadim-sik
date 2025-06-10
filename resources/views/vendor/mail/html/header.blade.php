@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://github-production-user-asset-6210df.s3.amazonaws.com/94025775/438147755-749989ea-bcec-4b1a-b2f8-c5fb6cf2a25e.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20250428%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20250428T100642Z&X-Amz-Expires=300&X-Amz-Signature=28a8286c10742410deccd10267cf44429d248723ccda870d2b29fdce983cda3d&X-Amz-SignedHeaders=host" class="logo" alt="{{ $slot }} Logo">
@endif
</a>
</td>
</tr>
