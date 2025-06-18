<x-layout>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
  <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-10">Create Post</h1>


<div class="flex justify-center ">
  <form action="{{route('create')}}" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('POST')
  
    <div class="flex flex-wrap">
      <label for="title" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
        title:
      </label>
  
      <input id="title" type="text" class="rounded-sm p-2 border-2 form-input w-full placeholder:text-gray-300 @error('title')  border-red-500 @enderror"
          name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="type title..">
  
      @error('title')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
  </div>
    <div>
      <label for="textarea" class="mt-2 block text-gray-700 text-sm font-bold mb-2 sm:mb-4">description :</label>
      <textarea id="textarea" name="description" placeholder="type your description..." class="rounded-sm p-2 border-2 placeholder:text-gray-300 form-input w-full @error('description')  border-red-500 @enderror"></textarea>
      @error('description')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
    </div>
    <div>
      <label for="image" class="mt-2 block text-gray-700 text-sm font-bold mb-2 sm:mb-4">image :</label>
      <input type="file" id="imageSelected" name="image" class="rounded-sm p-2 border-2 form-input w-full @error('image')  border-red-500 @enderror">
      {{-- image preview --}}
      <div class="mt-4 relative w-fit" id="imageContainer">
        <img id="imagePreview" src="#" alt="Image Preview" class="hidden max-w-[200px] rounded-md mb-2 shadow border-4 border-blue-700 shadow-border">
        <span id="cancelPreview" class="absolute hidden top-3 right-3 w-6 h-6 bg-red-500 text-white rounded-full text-sm font-bold flex items-center justify-center hover:bg-red-600 cursor-pointer">x</span>
        <span id="fileSize" class="absolute top-2 left-2 text-bold text-white text-sm hidden"></span>
      </div>
      @error('image')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
    </div>
    <div class="flex flex-col space-y-2 w-full">
      <label for="hashtagInput" class="block text-gray-700 text-sm font-bold mb-1">Hashtags:</label>
    
      <!-- Hidden input to store comma-separated tags -->
      <input type="hidden" name="hashtag" id="hashtagsHidden">
    
      <!-- Tag container -->
      <div id="tagContainer" class="flex flex-wrap gap-2 mb-2"></div>
    
      <!-- Input for adding new tags -->
      <input
        type="text"
        id="hashtagInput"
        placeholder="Type a hashtag and press Enter"
        class="rounded-sm p-2 border-2 w-full"
      />
      @error('hashtag')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      @if($allhashtags->isNotEmpty())
      <div class="flex items-center my-6">
        <hr class="flex-grow border-t border-gray-300">
        <span class="mx-4 text-gray-500 text-sm capitalize">or press Ctrl to select more</span>
        <hr class="flex-grow border-t border-gray-300">
      </div>
      <select id="selectedHashtag" multiple class="border p-2 rounded w-full mt-2">
        @foreach($allhashtags as $all)
          <option value="{{ $all }}">{{ $all }}</option>
        @endforeach
      </select>
      <button type="button" onclick="addSelectedHashtags()" class="mt-2 bg-gray-500 hover:bg-gray-600 w-fit text-white px-3 py-1 rounded">
        Add Selected Hashtags
      </button>
    @endif
    <div class="bg-gray-600  rounded-md p-2 h-11 w-fit">
      <input type="checkbox" name="enabled" id="enabled" value="1" {{ old('enabled') ? 'checked' : '' }}>
        <label class="text-white font-semibold" for="enabled">Enable comments</label>
        @error('enabled')
        <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
        </p>
        @enderror
    </div>
    </div>
    <div class="mt-4 flex justify-center">
      <button type="submit"
      class="w-[200px]  select-none font-bold  p-3 rounded-lg text-xl  no-underline text-gray-100 bg-gray-700 hover:bg-gray-500 sm:py-4">
      create
      </button>
    </div>
  </form>
</div>
  </div>
@php
  $initialTags =  old('hashtag') ? explode(',', old('hashtag')) : [];
@endphp

@push('scripts')
<script>
  window.initialTags = @json($initialTags ?? []);
  </script>
  
  <script>
    const imageSelected = document.getElementById('imageSelected');
    const imagePreview = document.getElementById('imagePreview');
    const imageContainer = document.getElementById('imageContainer');
    const cancelPreview = document.getElementById('cancelPreview');
    const fileSize = document.getElementById('fileSize');
  
    imageSelected.addEventListener('change',event=>{
        const file = event.target.files[0];
        if(file){
          const reader = new FileReader();
  
          reader.onload = eo =>{
            imagePreview.src = eo.target.result;
            imagePreview.classList.remove('hidden');
            cancelPreview.classList.remove('hidden');
            imageContainer.classList.remove('hidden');
            fileSize.classList.remove('hidden');
            fileSize.textContent = `${(file.size / (1024 * 1024)).toFixed(2)} MB / 5MB`; 
          }
          reader.readAsDataURL(file);
        }else{
          imagePreview.src = '#';
          imagePreview.classList.add('hidden');
        }
  
    })
    cancelPreview.addEventListener('click', function () {
      imageSelected.value = ''; 
      imagePreview.src = '#';
      cancelPreview.classList.add('hidden');
      fileSize.classList.add('hidden');
      imageContainer.classList.add('hidden');
    });
  </script>
@endpush
</x-layout>