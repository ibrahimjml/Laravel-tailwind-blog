<form comment-form="{{$post->id}}" action="/comment/{{$post->id}}" method="POST">
  @csrf
  <h5 class="text-gray-500 mb-2">Add a new comment</h5>
  <textarea class="border-2 bg-gray-100  rounded-lg placeholder-gray-400 pl-2 placeholder-opacity-100 @error('content') border-red-500 @enderror" placeholder="Write a thoughtful comment" name="content" id="content" cols="40" ></textarea>
  @error('content')
  <p class="text-red-500 text-xs italic mt-4">
      {{ $message }}
  </p>
  @enderror
  <button type="submit" class="block text-white rounded-lg p-1 text-sm ml-auto bg-blue-500">post a comment</button>
</form>