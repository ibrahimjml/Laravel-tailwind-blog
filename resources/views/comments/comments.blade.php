<div class="sm:max-w-2xl  max-w-xl mx-auto  p-6">
@foreach($post->comments as $comment)
  @if($comment->parent_id == null)
  <div class="comment bg-white shadow-md rounded-lg p-4 mb-4 z sm:w-[700px]">
      {{-- Comment content --}}
      <div class=" flex items-center gap-2 mb-2 mt-2">
        @if($comment->user->avatar !== "default.jpg")
          <img src="{{Storage::url($comment->user->avatar)}}"  class="w-8 h-8 overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
        @else
          <img src="/storage/avatars/{{$comment->user->avatar}}" class="w-8 h-8 overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
        @endif
        <div class="flex flex-col">
          <a href="/profile/{{$comment->user->username}}" class="hover:underline">
            <strong>{{ $comment->user->name }}</strong>
          </a>
          <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans()}}</span>
        </div>
      </div>
    
      <div>
        <p class="text-gray-700 p-2">{{ $comment->content }}</p>
        <div class="flex flex-row-reverse justify-end items-center gap-5">
          @if($comment->replies->count())
          <p class="show-all text-sm text-gray-600 cursor-pointer  w-fit" data-reply-count="{{ $comment->getTotalRepliesCount() }}">view {{$comment->getTotalRepliesCount()}} {{ $comment->getTotalRepliesCount() == 1 ? 'reply' : 'replies' }}</p>
          @endif
          @can('delete',$comment)
          <form class="w-fit rounded-lg" action="{{route('delete.comment',$comment->id)}}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="text-red-600 rounded-r-lg p-1 text-sm ml-auto">delete</button>
          </form>
          @endcan
          <p class="text-sm text-blue-600 reply-btn cursor-pointer w-fit">Reply</p>

        </div>
      </div>

      {{-- Reply form --}}
      <form class="relative reply-form hidden w-fit mb-4 p-1 rounded-lg px-5" action="/comment/{{ $post->id }}" method="POST">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea class="border-2 bg-gray-100 rounded-l-lg placeholder-gray-400 pl-2 placeholder-opacity-100 @error('content') border-red-500 @enderror" placeholder="Reply with Comment" name="content" id="content" cols="40"></textarea>
        @error('content')
        <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
        </p>
        @enderror
        <button type="submit" class="absolute top-1 right-[-28px] h-12 w-12 block text-white rounded-r-lg p-1 text-sm ml-auto bg-blue-500">Reply</button>
      </form>

      {{-- Display Replies --}}
      @if($comment->replies->count() > 0)
        <div class="reply-content ml-5 mt-4   border-l-gray-200 pl-4 hidden ">
          @include('comments.replies', ['comments' => $comment->replies])
        </div>
      @endif
    </div>
  @endif
@endforeach
</div>