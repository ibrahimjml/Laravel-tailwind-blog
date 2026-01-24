<!DOCTYPE html>
<html lang="en">

<head>
  @include('components.head')
</head>

<body class="min-h-screen m-0 ">
  <nav @class([
    'w-screen px-6 py-5 h-20',
    'bg-opacity-0 absolute z-50' => Route::is(['profile', 'home']),
    'bg-white shadow-[0_2px_5px_rgba(0,0,0,0.1)]' => !Route::is(['profile', 'home']),
    'bg-white shadow-[0_2px_5px_rgba(0,0,0,0.1)] fixed top-0 z-50' => Route::is(['blog']),
  ])>
    <div class="flex justify-between items-center ">
      <div class=" text-2xl font-bold flex">
        <span class="bg-white text-black pr-1 pl-1 rounded-l-md border border-t-3 border-b-3">Blog</span>
        <span class="text-white bg-black pl-1 pr-1 rounded-r-md ">Post</span>
      </div>

      <div class="md:flex md:items-center  space-x-6 {{ hasCompleted2FA() ? 'hidden' : '' }}">
        <ul class="flex items-center space-x-6">

          {{-- Hover Menu --}}
          @auth
            @if(hasCompleted2FA())
              <li id="dropdown" @class([
                'text-lg pt-2  relative',
                'text-white' => Route::is(['profile', 'home']),
                'text-gray-700' => !Route::is(['profile', 'home'])
              ])>
                @include('partials.hover-menu')
                <span class="cursor-pointer">
                  {{auth()->user()->name}}
                  <i class="fas fa-angle-down ml-1"></i>
                </span>
              </li>
            @endif
          @endauth
          @if(!auth()->user())
            <li @class([
              'font-bold text-xl' => Route::is('login'),
              'text-white text-lg pt-2' => Route::is(['profile', 'home']),
              'text-gray-700 text-lg  pt-2' => !Route::is(['profile', 'home'])
            ])>
              <a href="{{route('login')}}">Login</a>
            </li>
            <li @class([
              'font-bold text-xl' => Route::is('register'),
              'text-white text-lg pt-2' => Route::is(['profile', 'home']),
              'text-gray-700 text-lg  pt-2' => !Route::is(['profile', 'home'])
            ])>
              <a href="{{route('register')}}">Register</a>
            </li>
          @else
            @if(hasCompleted2FA())
              <li @class([
                'font-bold text-xl' => Route::is('blog'),
                'text-white text-lg pt-2' => Route::is(['profile', 'home']),
                'text-gray-700 text-lg  pt-2' => !Route::is(['profile', 'home'])
              ])>
                <a href="/blog">Blog</a>
              </li>
              @unless(request()->is('admin*'))
                <li id="hover-notification" class="text-lg relative pt-2 cursor-pointer text-gray-700 ">
                  <span
                    class="absolute top-2 left-3 h-4 w-4 bg-red-500 text-white flex justify-center items-center rounded-full p-1 text-xs font-semibold">
                    {{ auth()->user()->unreadNotifications->count() }}
                  </span>
                  <i class="fas fa-bell {{Route::is(['profile', 'home']) ? 'text-white' : 'text-gray-700'}}"></i>
                </li>

                @include('partials.notifications-menu')
              @endunless
              <li @class([
                'font-bold text-xl' => Route::is('bookmarks'),
                'text-white text-lg pt-2' => Route::is(['profile', 'home']),
                'text-gray-700 text-lg  pt-2' => !Route::is(['profile', 'home'])
              ])>
                <a href="{{route('bookmarks')}}"><i class="far fa-bookmark"></i></a>
              </li>
              @if(auth()->user()->hasAnyRole(['Admin', 'Moderator']) || auth()->user()->hasPermission('Access'))
                <li @class([
                  'text-white text-lg pt-2' => Route::is(['profile', 'home']),
                  'text-gray-700 text-lg  pt-2' => !Route::is(['profile', 'home'])
                ])>
                  <a href="{{route('admin.panel')}}">Admin Panel</a>
                </li>
              @endif
              @unless(request()->routeIs('home'))
                <li @class([
                  'text-white text-lg pt-2' => Route::is(['profile', 'home']),
                  'text-gray-700 text-lg pt-2' => !Route::is(['profile', 'home'])
                ])>
                  <a href="/">Home</a>
                </li>
              @endunless
            @else
              <form id="logoutFRM" action="{{ route('logout') }}" method="POST">@csrf</form>
              <button form="logoutFRM" type="submit"
                class="bg-red-500/80 mt-3 text-white  font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                Logout
              </button>
            @endif
          @endif
        </ul>
      </div>
      @if(hasCompleted2FA())
      <button id="mobile-btn" class="md:hidden @if(Route::is(['profile', 'home'])) text-white @endif">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    {{-- Burger Menu --}}
    <div class="md:hidden">
      @include('partials.burger-menu')
    </div>
    @endif
  </nav>