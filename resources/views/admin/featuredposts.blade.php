@extends('admin.partials.layout')
@section('title','Featured | Dashboard')
@section('content')
    <div class="relative md:ml-64 bg-blueGray-50">
    <form action="{{route('admin.featured')}}" method="POST" enctype="multipart/form-data" class="p-6">
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
        <input type="file" name="image" class="rounded-sm p-2 border-2 form-input w-full @error('image')  border-red-500 @enderror">
        @error('image')
        <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
        </p>
        @enderror
      </div>
      <div class="flex flex-col space-y-2 w-full">
        <label for="hashtagInput" class="block text-gray-700 text-sm font-bold mb-1">Hashtags:</label>
      
        <input type="hidden" name="hashtag" id="hashtagsHidden">
      
        <!-- Tag container -->
        <div id="tagContainer" class="flex flex-wrap gap-2 mb-2"></div>
      
        <input  type="text" id="hashtagInput" placeholder="Type a hashtag and press Enter" class="rounded-sm p-2 border-2 w-full"/>
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
      </div>
    <div class="flex flex-col  items-start ">
      <label for="featured" class="block text-gray-700 text-sm font-bold mb-2 mt-2 sm:mb-4">
        Featured:
      </label>
  <div class="flex  items-center justify-center gap-3">
    <input id="featured" type="checkbox" class="rounded-sm p-2 border-2 form-input  placeholder:text-gray-300 @error('featured')  border-red-500 @enderror"
    name="featured" value="1"    {{ old('featured') ? 'checked' : '' }} autocomplete="featured" autofocus placeholder="[laravel,php] with comma separated">Featured
  </div>
      
      @error('featured')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
  </div>
    <div class="bg-gray-600  rounded-md p-2 h-11 w-fit">
      <input type="checkbox" name="enabled" id="enabled" value="1" {{ old('enabled') ? 'checked' : '' }}>
        <label class="text-white font-semibold" for="enabled">Enable comments</label>
        @error('enabled')
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
@php
  $initialTags =  old('hashtag') ? explode(',', old('hashtag')) : [];
@endphp
<script>
  window.initialTags = @json($initialTags ?? []);
  </script>
@endsection

  

