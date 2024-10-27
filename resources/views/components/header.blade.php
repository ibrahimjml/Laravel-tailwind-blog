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
            <ul id="hiddenul2" style="display: none;" class="w-[200px]">
              <li class="flex gap-4 border-b-2 text-gray-500 hover:border-red-500 hover:text-black hover:font-semibold transition duration-300 justify-between mb-2">
                <a href="/user/{{auth()->user()->id}}" >
                  {{-- checking if image has default.jpg --}}
                  @if($authUser->avatar !== "default.jpg")
                
                  <img src="{{Storage::url($authUser->avatar)}}"   class="w-[23px] h-[23px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full mr-6" >
              
                @else
                <img src="/storage/avatars/{{auth()->user()->avatar}}"   class="w-[23px] h-[23px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full mr-6">
                @endif
                </a>
                <span>
                  <a href="/profile/{{auth()->user()->username}}" >profile</a>
                </span></li>
              <li class="border-b-2 text-gray-500 hover:text-black hover:font-semibold transition duration-300 hover:border-b-red-500 flex justify-between items-center mb-2">
                <i class="fa fa-edit"></i>
                <a href="/edit-avatar/{{auth()->user()->id}}">change image</a>

              </li>
              <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between gap-2 mb-2">
                <img src="{{url('setting.png')}}" width="30px" alt="" class="mr-2">
                <a href="/edit-profile/{{auth()->user()->id}}">edit profile</a>

              </li>
              <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between gap-8">
                <img src="{{url('logout.png')}}" width="30px" alt="" class="mr-2">
              <a href="{{route('logout')}}" >Logout</a>
              </li>
            </ul>
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
      <div
        id="mobile-menu"
        class="absolute hidden flex flex-col py-8 left-6 right-6 top-16 items-center space-y-2 font-bold bg-gray-50 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300"
      >
      @if(!auth()->user())
        <a href="{{route('login')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Login</a>
        <a href="{{route('register')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Register</a>
        @else
        
          <a href="/user/{{auth()->user()->id}}" >
            {{-- checking if image has default.jpg --}}
            @if(auth()->user()->avatar =="default.jpg")
            <img src="/storage/avatars/{{auth()->user()->avatar}}" class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
            @else
            <img src="{{Storage::url(auth()->user()->avatar)}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
            @endif
          </a>
          
        <span class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300"><a href="/user/{{auth()->user()->id}}" >profile</span>
        <a href="{{route('logout')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Logout</a>
        <a href="/blog" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Blog</a>
        <a href="/getsavedposts" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Saved</a>
        @endif
        <a href="/" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Home</a>
        
      </div>
    </div>
  </nav>


