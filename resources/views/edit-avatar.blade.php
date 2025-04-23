<x-layout>
<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold text-center py-5 capitalize">edit avatar</h1>
</div>

<div class="flex justify-center ">
  {{-- delete user avatar --}}
  @if($user->avatar !== "default.jpg")
  @can('delete',$user)
  <div class="absolute z-10">
    <form action="{{route('delete.avatar',$user->id)}}" method="POST">
      @csrf
      @method("DELETE")
      <button type="submit" class="p-2 rounded-full bg-red-200 flex items-center mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ee4811" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></button>
    </form>
  </div>
  @endcan
  @endif
  <form action="/edit-avatar/{{$user->id}}/edit" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('PUT')
     
    <span class=" w-[180px] h-[180px] flex justify-center items-center ml-20">
      @if($user->avatar !== "default.jpg")
      <img  src="{{Storage::url($user->avatar)}}" alt=""  class="relative w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-blue-500">
      @else
      <img  src="/storage/avatars/{{$user->avatar}}" alt=""  class="w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-blue-500">
      @endif
    </span>
    
  
  
    <div>
      <label for="avatar">image</label>
      <input  type="file" name="avatar" class="block border-2">
      @error('avatar')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
    </div>
    @can('update', $user)
    <div>
      <input type="submit" value="update avatar" class="block cursor-pointer w-36 mx-auto bg-blue-700  text-slate-200 py-2  rounded-lg font-bold capitalize mb-6 mt-6 text-center">
    </div>
    @endcan
  </form>

  <div>
  
  </div>

</div>
</x-layout>