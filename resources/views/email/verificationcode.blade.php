@component('mail::message')

<h2>Hey,{{$user->email}}</h2>
<p>On {{ \Carbon\Carbon::now()->format('D, d M Y H:i:s') }} you attempted a new verification code</p>
<p>If this was you, please use the code below.</p>
<p>Your verification code is: <b>{{$code}}</b></p>
Thanks,<br>
{{config('app.name')}}
@endcomponent