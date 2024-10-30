<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{url('style.css')}}">
  @vite('resources/css/app.css')
  <title>home</title>
</head>
<body>
  <nav  class="absolute z-50 container mx-auto px-6 py-2 md:bg-indigo-600 md:bg-opacity-0">
    <div class="flex justify-between items-center ">
      <div class=" text-2xl font-bold">
      <span class="bg-white text-black pr-1 pl-1 rounded-l-md">Blog</span><span class="text-white bg-black pl-1 pr-1 rounded-r-md">Post</span> 
      </div>
  
      <div class="md:flex md:items-center-center space-x-6 hidden">
        <ul class="md:flex md:items-center space-x-6">
          @auth
          <li class="text-white text-lg pt-2  relative" id="dropdown">
            @include('partials.hover-menu')
          <span class="cursor-pointer" >
            {{auth()->user()->name}}
          </span>
        </li>
          @endauth
        @if(!auth()->user())
        <a href="{{route('login')}}" class="text-white hover:scale-125 transition duration-300  text-lg  pt-2"
          >Login</a  >
        <a href="{{route('register')}}" class="text-white hover:scale-125 transition duration-300    text-lg pt-2"
          >register</a>
        @else  
        @if(auth()->user()->is_admin)
        <a href="/admin-panel" class="text-white hover:scale-125 transition duration-300  text-lg pt-2"
        >Admin Panel</a>
        @endif
        <a href="/blog" class="text-white hover:scale-125 transition duration-300  text-lg pt-2"
        >Blog</a>
        <a href="/getsavedposts" class="text-white hover:scale-125 transition duration-300 text-lg  pt-2">Saved</a>
        @endif
    
      </div>
      <button id="mobile-btn" class="md:hidden">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          height="30"
          viewBox="0 96 960 960"
          width="30"
          class="fill-white active:scale-90"
        >
          <path
            d="M120 816v-60h720v60H120Zm0-210v-60h720v60H120Zm0-210v-60h720v60H120Z"
          />
        </svg>
      </button>
    </div>
    <div class="md:hidden">
      @include('partials.burger-menu')
    </div>
  </nav>


