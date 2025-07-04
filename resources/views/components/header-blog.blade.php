<!DOCTYPE html>
<html lang="en">
<head>
@include('components.head')
</head>
<body  class="min-h-screen flex  flex-col m-0 ">
  <nav class="w-screen px-6 py-2 {{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'bg-opacity-0 absolute z-50' : 'bg-zinc-100 border-b-2'}}  ">
    <div class="flex justify-between items-center ">
      <div class=" text-2xl font-bold">
      <span class="bg-white text-black pr-1 pl-1 rounded-l-md border border-t-3 border-b-3">Blog</span><span class="text-white bg-black pl-1 pr-1 rounded-r-md ">Post</span> 
      </div>
  
      <div class="md:flex md:items-center  space-x-6 hidden">
        <ul class="flex items-center space-x-6">
        
          {{-- Hover Menu --}}
          @auth
        <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white' : 'text-gray-700'}} text-lg pt-2  relative" id="dropdown">
          @include('partials.hover-menu')
        <span class="cursor-pointer" >
          {{auth()->user()->name}}
        </span>
      </li>
        @endauth
        @if(!auth()->user())
        <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg  pt-2'}} @if(Route::is('login')) font-bold text-xl  @endif">
        <a href="{{route('login')}}" 
          >Login</a></li>
          <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('register')) font-bold text-xl  @endif">
        <a href="{{route('register')}}" 
          >Register</a></li>
        @else  
        <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('blog')) font-bold text-xl @endif">
        <a href="/blog" 
        >Blog</a></li>
        @unless(request()->is('admin*'))
        <li id="hover-notification" class="text-lg relative pt-2 pb-1 cursor-pointer text-gray-700 ">
        <span class="absolute top-2 left-3 h-4 w-4 bg-gray-500 text-white flex justify-center items-center rounded-full p-1 text-xs">
          {{ auth()->user()->unreadNotifications->count() }}
        </span>
        <i class="fas fa-bell {{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white' : 'text-gray-700'}}"></i>
        </li>
    
          @include('partials.notifications-menu')
        @endunless
        <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('bookmarks')) font-bold text-xl  @endif">
          <a href="{{route('bookmarks')}}" >
            Saved</a></li>
            @if(auth()->user()->hasAnyRole(['Admin','Moderator']) || auth()->user()->hasPermission('Access'))
            <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white text-lg pt-2' : 'text-gray-700 text-lg pt-2'}} @if(Route::is('admin-page')) font-bold text-xl  @endif ">
              <a href="{{route('admin-page')}}" >
                Admin Panel</a></li>
                @endif
        @endif
        @if(!Route::is('home'))
        <li class="{{Route::is(['profile','home','profile.aboutme','profile.activity']) ? 'text-white text-lg pt-2' : 'text-gray-700   text-lg pt-2'}}">
        <a href="/" >Home</a></li>
        @endif
        
      </ul>
      </div>
      <button id="mobile-btn" class="md:hidden @if(Route::is(['profile','home','profile.aboutme','profile.activity'])) text-white @endif">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    {{-- Burger Menu --}}
    <div class="md:hidden">
     @include('partials.burger-menu')
    </div>
  </nav>



