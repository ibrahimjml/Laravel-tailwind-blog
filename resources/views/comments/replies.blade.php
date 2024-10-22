
@foreach($comments as $reply)
  <div class="reply bg-gray-50 shadow-sm rounded-lg p-4 mb-2">
    <div class="flex items-center gap-2 mb-2">
      @if($reply->user->avatar !== "default.jpg")
        <img src="{{Storage::url($reply->user->avatar)}}"  class="w-8 h-8 overflow-hidden flex justify-center items-center shrink-0 grow-0 rounded-full ">
      @else
        <img src="/storage/avatars/{{$reply->user->avatar}}" class="w-8 h-8 overflow-hidden flex justify-center items-center shrink-0 grow-0 rounded-full ">
      @endif
      <div class="flex flex-col">
        <div class="flex gap-3 items-center">
          <a href="/user/{{$reply->user->id}}" class="hover:underline">
            <strong>{{ $reply->user->name }}</strong>
          </a>
          @if($reply->parent)
          <p class="text-sm text-gray-600">  > {{ $reply->parent->user->name }} </p>
          @endif
        </div>
        <span class="text-xs">{{ $reply->created_at }}</span>
      </div>
    </div>
    <div>
      <p class="text-l font-semibold">{{ $reply->content }}</p>
  
      <div class="flex flex-row-reverse justify-end items-center gap-5">
        @can('delete',$reply)
        <form class="w-fit rounded-lg" action="{{route('delete.comment',$reply->id)}}" method="POST">
          @csrf
          @method('delete')
          <button type="submit" class="text-red-600 rounded-r-lg p-1 text-sm ml-auto">delete</button>
        </form>
        @endcan
        <p class="text-sm text-blue-600 reply-btn cursor-pointer w-fit">Reply</p>
      </div>
    </div>

    {{-- Reply form --}}
    <form class="relative reply-form hidden w-fit mb-4 p-1 rounded-lg px-5" action="/comment/{{ $reply->post_id }}" method="POST">
      @csrf
      <input type="hidden" name="parent_id" value="{{ $reply->id }}">
      <textarea class="border-2 bg-gray-100 rounded-l-lg placeholder-gray-400 pl-2 placeholder-opacity-100" placeholder="Reply to {{ $reply->user->name }}" name="content" cols="40"></textarea>
      <button type="submit" class="absolute top-1 right-[-28px] h-12 w-12 block text-white rounded-r-lg p-1 text-sm ml-auto bg-blue-500">Reply</button>
    </form>

    {{-- Display Nested Replies --}}
    @if($reply->replies->count() > 0)
      <div class="ml-4 mt-4 border-l-2 border-gray-200 pl-4">
        @include('comments.replies', ['comments' => $reply->replies])
      </div>
    @endif
  </div>
@endforeach
