<x-header-blog/>
<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold text-center py-5 capitalize">edit avatar</h1>
</div>

<div class="flex justify-center ">
  <form action="/edit-avatar/{{auth()->user()->id}}" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('PUT')
     
    <span class=" w-[180px] h-[180px] flex justify-center items-center ml-20">
      @if(auth()->user()->avatar !== "default.jpg")
      <img  src="{{Storage::url(auth()->user()->avatar)}}" alt=""  class="w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-blue-500">
      @else
      <img  src="/storage/avatars/{{auth()->user()->avatar}}" alt=""  class="w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-blue-500">
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
    <div>
      <input type="submit" value="update post" class="block cursor-pointer w-36 mr-auto ml-auto bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
    </div>
  </form>

  <div>
  
  </div>

</div>

<x-footer/>