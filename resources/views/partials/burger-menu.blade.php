<div
id="mobile-menu"
class="absolute z-[20] hidden flex flex-col py-8 left-6 right-6 top-16 items-center space-y-2 font-bold bg-gray-50 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">


@if(!auth()->user())
<a href="{{route('login')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Login</a>
<a href="{{route('register')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Register</a>
@else

<a href="{{route('profile',auth()->user()->username)}}" >
  {{-- checking if image has default.jpg --}}
  @if(auth()->user()->avatar =="default.jpg")
  <img src="/storage/avatars/{{auth()->user()->avatar}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
  @else
  <img src="{{Storage::url(auth()->user()->avatar)}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
  @endif
</a>

<span class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300"><a href="{{route('profile',auth()->user()->username)}}" >profile</span>
  <a href="{{route('create')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">create post</a>
<a href="{{route('logout')}}" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Logout</a>
<a href="/blog" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Blog</a>
<a href="/getsavedposts" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Saved</a>
@endif
<a href="/" class="hover:scale-110 border-b-2 hover:border-b-black text-xl text-gray-600 hover:text-black transition-all duration-300">Home</a>

</div>