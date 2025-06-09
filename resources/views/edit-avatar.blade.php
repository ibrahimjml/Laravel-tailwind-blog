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
      <button type="submit" class="p-2 rounded-full bg-red-200 flex items-center mb-2"><i class="fas fa-trash text-red-500"></i></button>
    </form>
  </div>
  @endcan
  @endif
  <form action="{{route('edit.avatar',$user->id)}}" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('PUT')
     
    <span class=" w-[180px] h-[180px] flex justify-center items-center ml-20">
      <img  src="{{$user->avatar_url}}" alt=""  class="relative w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-blue-500">
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