<ul id="hiddenul2" style="display: none;" class="w-[200px]">
        
  <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between gap-2 mb-2">
    <a href="{{route('profile',auth()->user()->username)}}" >
      <img src="{{auth()->user()->avatar_url}}"   class="w-[23px] h-[23px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full " >
    </a>
    <span>
      <a href="{{route('profile',auth()->user()->username)}}"  >profile</a>
    </span></li>
  <li class="border-b-2 text-gray-500 hover:text-black hover:font-semibold transition duration-300 hover:border-b-red-500 flex justify-between items-center mb-2 ">
    <i class="fa-solid fa-edit "></i>
    <a href="/edit-avatar/{{auth()->user()->id}}" class="ml-2">change image</a>

  </li>
  <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-2 mb-2">
    <i class="fa-solid fa-gear"></i>
    <a href="/edit-profile/{{auth()->user()->username}}" class="ml-2">edit profile</a>

  </li>
  <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between items-center gap-8">
    <i class="fa-solid fa-arrow-right-from-bracket" class="ml-2"></i>
  <a href="{{route('logout')}}" >Logout</a>
  </li>
</ul>