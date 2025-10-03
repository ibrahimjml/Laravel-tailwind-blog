<form comment-form="{{$post->id}}" action="/comment/{{$post->id}}" method="POST">
  @csrf
  <div class="flex gap-3 items-center mb-10">
    <img src="{{auth()->user()->avatar_url}}" alt="" class="rounded-full w-10 h-10">
    <p class="font-semibold text-xs text-blueGray-500">{{auth()->user()->name}}</p>
  </div>
  <textarea class="border-0 placeholder-gray-700 pl-2 focus:ring-0 focus:outline-none resize-none placeholder-opacity-100 @error('content') border-red-500 @enderror" placeholder="Write a thoughtful comment" name="content" id="content" rows="4" cols="80" ></textarea>
  @error('content')
  <p class="text-red-500 text-xs italic mt-4">
      {{ $message }}
  </p>
  @enderror
  <button type="submit" class="block text-white font-bold rounded-lg p-2 text-sm ml-auto my-3 bg-blue-500">Comment</button>
</form>