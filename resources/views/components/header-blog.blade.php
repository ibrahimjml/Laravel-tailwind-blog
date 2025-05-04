<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
   {{-- SEO  --}}
  <meta name="description" content="@yield('meta_description')">
  <meta name="keywords" content="@yield('meta_keywords')">
  <meta name="author" content="@yield('author')">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="{{url('style.css')}}">
  <link rel="stylesheet" href="{{url('tinymce.css')}}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <title>@yield('meta_title')</title>
</head>
<body  class="min-h-screen flex  flex-col m-0 ">
  <nav class="w-screen px-6 py-2 {{Route::is('home') ? 'bg-opacity-0 absolute z-50' : 'bg-zinc-100 border-b-2'}}  ">
    <div class="flex justify-between items-center ">
      <div class=" text-2xl font-bold">
      <span class="bg-white text-black pr-1 pl-1 rounded-l-md border border-t-3 border-b-3">Blog</span><span class="text-white bg-black pl-1 pr-1 rounded-r-md ">Post</span> 
      </div>
  
      <div class="md:flex md:items-center  space-x-6 hidden">
        <ul class="flex items-center space-x-6">
        
          {{-- Hover Menu --}}
          @auth
        <li class="{{Route::is('home') ? 'text-white' : 'text-gray-700'}} text-lg pt-2  relative" id="dropdown">
          @include('partials.hover-menu')
        <span class="cursor-pointer" >
          {{auth()->user()->name}}
        </span>
      </li>
        @endauth
        @if(!auth()->user())
        <li class="{{Route::is('home') ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg  pt-2'}} @if(Route::is('login')) font-bold text-xl  @endif">
        <a href="{{route('login')}}" 
          >Login</a></li>
          <li class="{{Route::is('home') ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('register')) font-bold text-xl  @endif">
        <a href="{{route('register')}}" 
          >Register</a></li>
        @else  
        <li class="{{Route::is('home') ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('blog')) font-bold text-xl @endif">
        <a href="/blog" 
        >Blog</a></li>
        @unless(request()->is('admin*'))
        <li id="hover-notification" class="text-lg relative pt-2 pb-1 cursor-pointer text-gray-700 ">
        <span class="absolute top-2 left-3 h-4 w-4 bg-red-500 text-white flex justify-center items-center rounded-full p-1 text-xs">
          {{ auth()->user()->unreadNotifications->count() }}
        </span>
        <i class="fa-regular fa-bell"></i>
        </li>
    
          @include('partials.notifications-menu')
        @endunless
        <li class="{{Route::is('home') ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('bookmarks')) font-bold text-xl  @endif">
          <a href="{{route('bookmarks')}}" >
            Saved</a></li>
            @if(auth()->user()->is_admin)
            <li class="{{Route::is('home') ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('admin-page')) font-bold text-xl  @endif ">
              <a href="{{route('admin-page')}}" >
                Admin Panel</a></li>
                @endif
        @endif
        @if(!Route::is('home'))
        <li class="text-gray-700   text-lg pt-2">
        <a href="/" >Home</a></li>
        @endif
        
      </ul>
      </div>
      <button id="mobile-btn" class="md:hidden @if(Route::is('home')) fill-white @endif">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          height="30"
          viewBox="0 96 960 960"
          width="30"
        >
          <path
            d="M120 816v-60h720v60H120Zm0-210v-60h720v60H120Zm0-210v-60h720v60H120Z"
          />
        </svg>
      </button>
    </div>

    {{-- Burger Menu --}}
    <div class="md:hidden">
     @include('partials.burger-menu')
    </div>
  </nav>



