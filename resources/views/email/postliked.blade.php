@component('mail::message')
<h2>Hey,{{$postowner->name}}</h2>
<p>{{$user->name}} Liked Your Post</p>
@component('mail::button',['url'=>url(env('APP_URL').'/post/'.$post->slug)])
View Post
@endcomponent
Thanks<br>
{{config('app.name')}}
@endcomponent