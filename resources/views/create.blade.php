<x-header-blog/>


<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold text-center py-5 capitalize">create post</h1>
</div>

<div class="flex justify-center pt-9">
  <form action="{{route('create')}}" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('POST')
  
    <div class="flex flex-wrap">
      <label for="title" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
        title:
      </label>
  
      <input id="title" type="text" class="rounded-sm p-2 border-2 form-input w-full @error('title')  border-red-500 @enderror"
          name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
  
      @error('title')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
  </div>
    <div>
      <label for="textarea" class="mt-2 block text-gray-700 text-sm font-bold mb-2 sm:mb-4">description :</label>
      <textarea id="textarea" name="description" class="rounded-sm p-2 border-2 form-input w-full @error('description')  border-red-500 @enderror"></textarea>
      @error('description')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
    </div>
    <div>
      <label for="image" class="mt-2 block text-gray-700 text-sm font-bold mb-2 sm:mb-4">image :</label>
      <input type="file" name="image" class="rounded-sm p-2 border-2 form-input w-full @error('image')  border-red-500 @enderror">
      @error('image')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
    </div>
    <div class="flex flex-wrap">
      <label for="hashtag" class="block text-gray-700 text-sm font-bold mb-2 mt-2 sm:mb-4">
        hashtag:
      </label>
  
      <input id="hashtag" type="text" class="rounded-sm p-2 border-2 form-input w-full @error('hashtag')  border-red-500 @enderror"
          name="hashtag" value="{{ old('hashtag') }}"  autocomplete="hashtag" autofocus>
  
      @error('hashtag')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
  </div>
    <div class="mt-4 flex justify-center">
      <button type="submit"
      class="w-[200px]  select-none font-bold  p-3 rounded-lg text-xl  no-underline text-gray-100 bg-gray-700 hover:bg-gray-500 sm:py-4">
      create
      </button>
    </div>
  </form>
</div>
