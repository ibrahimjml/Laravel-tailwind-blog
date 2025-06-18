<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{url('/img/icon.png')}}" type="image/png" />
<link rel="apple-touch-icon" href="{{url('/img/apple-touch-icon.png')}}" />
<meta name="theme-color" content="#000000" />
{{-- SEO --}}
<meta 
    name="description" 
    content="@yield('meta_description',
    config('app.name'). '- welcome to our platform where all users share their posts and connect with each other')" 
  >
<meta 
     name="keywords"
     content="@yield('meta_keywords',
     'laravel, blogpost, post, links, link, cv, portfolio, aggregation, platform, social, media, profile, bio, tree')" 

 >
<meta 
    name="author" 
    content="@yield('author',config('app.name'))"
>
<meta 
     content="BlogPost"
     property="og:site_name"
      />
<meta 
    property="og:url" 
    content="{{ url()->current() }}" 
/>
<meta 
    property="og:type" 
    content="@yield('og_type', 'website')" 
/>
<meta 
    property="og:title" 
    content="@yield('meta_title',
     config('app.name').'- The platform that let users connect with each others and share their ideas .')" 
/>
<meta 
    property="og:description" 
    content="@yield('meta_description',
    config('app.name'). '- welcome to our platform where all users share their posts and connect with each other')" 
/>
<meta 
    property="og:image" 
    content="@yield('og_image', url('/img/logo.png'))" 
/>

<meta 
     property="og:image:width" 
     content="200" 
/>
<meta
     property="og:image:height" 
     content="200" 
 />

<title>@yield('meta_title',config('app.name').'- The platform that let users connect with each others and share their ideas .')</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="{{url('style.css')}}">
<link rel="stylesheet" href="{{url('tinymce.css')}}">
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('styles')