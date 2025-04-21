<form  edit-comment="{{$comment->id}}" class="edit-form hidden relative w-fit mb-4 p-1 rounded-lg px-5" action="{{route('edit.comment',$comment)}}" method="POST">
  @csrf
  @method('PUT')
  @if($comment->parent_id)
  <input type="hidden" name="parent_id" value="{{ $comment->parent_id }}">
  @endif
  <textarea name="content" id="content" cols="40" class="border-2 bg-gray-100 rounded-l-lg placeholder-gray-400  placeholder-opacity-100 @error('content') border-red-500 @enderror" >
    {{$comment->content}}
  </textarea>
  @error('content')
  <p class="text-red-500 text-xs italic mt-4">
      {{ $message }}
  </p>
  @enderror
  <button type="submit" class="absolute top-1 right-[-28px] h-12 w-12 block text-white rounded-r-lg p-1 text-sm ml-auto bg-blue-500">Save</button>
</form>