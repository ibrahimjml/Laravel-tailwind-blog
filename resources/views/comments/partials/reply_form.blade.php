<form comment-id={{$comment->id}} class=" reply-form hidden relative w-fit mb-4 p-1 rounded-lg px-5" action="/reply/{{ $comment->id }}" method="POST">
  @csrf
  @method('POST')
  <input type="hidden" name="parent_id" value="{{isset($reply->id) ? $reply->id : $comment->id }}">
  <textarea class="border-2 bg-gray-100 rounded-l-lg placeholder-gray-400 pl-2  placeholder-opacity-100 @error('content') border-red-500 @enderror" placeholder="{{ isset($reply->user->username) ? 'Reply To ' . $reply->user->username : 'Reply with Comment' }}" name="content" id="content" cols="40"></textarea>
  @error('content')
  <p class="text-red-500 text-xs italic mt-4">
      {{ $message }}
  </p>
  @enderror
  <button type="submit" class="absolute top-1 right-[-28px] h-12 w-12 block text-white rounded-r-lg p-1 text-sm ml-auto bg-blue-500">Reply</button>
</form>