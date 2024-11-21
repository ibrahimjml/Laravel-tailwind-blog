<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{url('style.css')}}">
  @vite('resources/css/app.css')
  @vite(['resources/js/app.js'])
  <title>home</title>
</head>
<body id="body" class="min-h-screen flex  flex-col m-0 ">
  <nav class="w-screen px-6 py-2 bg-zinc-100  border-b-2">
    <div class="flex justify-between items-center ">
      <div class=" text-2xl font-bold">
      <span class="bg-white text-black pr-1 pl-1 rounded-l-md border border-t-3 border-b-3">Blog</span><span class="text-white bg-black pl-1 pr-1 rounded-r-md ">Post</span> 
      </div>
  
      <div class="md:flex md:items-center  space-x-6 hidden">
        <ul class="md:flex md:items-center space-x-6">
          {{-- Hover Menu --}}
          @auth
        <li class="text-black text-lg pt-2  relative" id="dropdown">
          @include('partials.hover-menu')
        <span class="cursor-pointer" >
          {{auth()->user()->name}}
        </span>
      </li>
        @endauth
        @if(!auth()->user())
        <li class="text-black hover:scale-125 transition duration-300  text-lg  pt-2 lemon">
        <a href="{{route('login')}}" 
          >Login</a></li>
          <li class="text-black hover:scale-125 transition duration-300  lemon  text-lg pt-2">
        <a href="{{route('register')}}" 
          >register</a></li>
        @else  
        <li class="text-black hover:scale-125 transition duration-300  text-lg pt-2 lemon">
        <a href="/blog" 
        >Blog</a></li>
        <li class="text-black hover:scale-125 transition duration-300 text-lg  pt-2 lemon">
          <a href="/getsavedposts" >
            Saved</a></li>
            @if(auth()->user()->is_admin)
            <li class="text-black hover:scale-125 transition duration-300 text-lg  pt-2 lemon">
              <a href="{{route('admin-page')}}" >
                Admin Panel</a></li>
                @endif
        @endif
        <li class="text-black hover:scale-125 transition duration-300  text-lg pt-2 lemon">
        <a href="/" >Home</a></li>
      
      </ul>
      </div>
      <button id="mobile-btn" class="md:hidden">
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


