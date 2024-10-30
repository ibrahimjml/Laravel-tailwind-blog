<ul id="hiddenul2" style="display: none;" class="w-[200px]">
        
  <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between gap-2 mb-2">
    <a href="{{route('profile',auth()->user()->username)}}" >
      {{-- checking if image has default.jpg --}}
      @if($authUser->avatar !== "default.jpg")
    
      <img src="{{Storage::url(auth()->user()->avatar)}}"   class="w-[23px] h-[23px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full " >
  
    @else
    <img src="/storage/avatars/{{auth()->user()->avatar}}"   class="w-[23px] h-[23px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full mr-9">
    @endif
    </a>
    <span>
      <a href="{{route('profile',auth()->user()->username)}}"  >profile</a>
    </span></li>
  <li class="border-b-2 text-gray-500 hover:text-black hover:font-semibold transition duration-300 hover:border-b-red-500 flex justify-between items-center mb-2 ">
    <i class="fa fa-edit "></i>
    <a href="/edit-avatar/{{auth()->user()->id}}" class="ml-2">change image</a>

  </li>
  <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between gap-2 mb-2">
    <img src="{{url('setting.png')}}" width="30px" alt="" class="mr-8">
    <a href="/edit-profile/{{auth()->user()->id}}">edit profile</a>

  </li>
  <li class="border-b-2 hover:border-b-red-500 text-gray-500 hover:text-black hover:font-semibold transition duration-300 flex justify-between gap-8">
    <img src="{{url('logout.png')}}" width="30px" alt="" class="mr-8">
  <a href="{{route('logout')}}" >Logout</a>
  </li>
</ul>