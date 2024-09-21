@component('mail::message')

<h2>Hey,{{$user->name}}</h2>
@component('mail::button',['url'=>url('reset/'.$token)])
Reset your Password
@endcomponent
<p>Thanks</p>
@endcomponent