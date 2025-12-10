<ul id="mobile-menu" class="burger-menu hidden w-[250px]">

  @guest

    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="{{route('login')}}">Login</a>
    </li>
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="{{route('register')}}">Register</a>
    </li>

  @else

    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="{{route('profile', auth()->user()->username)}}">Profile</a>
      <a href="{{route('profile', auth()->user()->username)}}">
        <img src="{{auth()->user()->avatar_url}}"
          class="w-[23px] h-[23px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
      </a>
    </li>
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between  items-center gap-2 mb-2">
      <a href="{{route('profile.account')}}">Account settings</a>
      <i class="fas fa-cog"></i>
    </li>
      @if(auth()->user()->hasAnyRole(['Admin','Moderator']) || auth()->user()->hasPermission('Access'))
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between  items-center gap-2 mb-2">
      <a href="{{route('admin.panel')}}">Admin Panel</a>
      <i class="fas fa-lock"></i>
    </li>
      @endif
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="/blog">Blog</a>
      <i class="fas fa-image "></i>
    </li>
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="{{route('createpage')}}">create post</a>
      <i class="fas fa-plus "></i>
    </li>
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="/getsavedposts">Saved</a>
      <i class="fas fa-bookmark"></i>
    </li>
  @endguest
  @unless(request()->routeIs('home'))
    <li
      class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
      <a href="/">Home</a>
      <i class="fas fa-home"></i>
    </li>
  @endunless
  <li
    class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
    <a href="{{route('logout')}}">Logout</a>
    <i class="fas fa-sign-out-alt"></i>
  </li>
</ul>