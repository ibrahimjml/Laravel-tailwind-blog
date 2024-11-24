@component('mail::message')

<h2>Hey,{{$user->name}}</h2>
@component('mail::button',['url'=>url('reset/'.$token)])
Reset your Password
@endcomponent
Thanks<br>
{{config('app.name')}}
@endcomponent