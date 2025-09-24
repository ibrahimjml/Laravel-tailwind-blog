
@foreach($comments as $reply)
  <div  class="reply relative bg-gray-50  shadow-sm rounded-lg p-4 mb-2">
    {{-- reply user information --}}
    @include('comments.partials.reply_info',['reply' => $reply])
    {{-- relpy content --}}
    <div>
      <p id="comment-{{ $reply->id }}" class="comment-content text-gray-700 p-2">{{ $reply->content }}</p>
  
      <div class="flex flex-row-reverse justify-end items-center gap-5">
        @if($reply->replies_count > 0)
        <p class="view-all  text-sm text-gray-600 cursor-pointer  w-fit" reply-replies-count="{{$reply->replies_count}}">view {{ $reply->replies_count }} {{ Str::plural('reply', $reply->replies_count) }}</p>
        @endif
        {{-- delete | edit model --}}
        @include('comments.partials.delete-edit-comment-model',['comment'=>$reply])
        
        <p class="reply-btn text-sm text-blue-600 cursor-pointer w-fit">Reply</p>
      </div>
    </div>
      {{-- Edit form --}}
      @can('edit',$reply)
      @include('comments.partials.edit_form',['comment'=>$reply])
      @endcan

    {{-- Reply form --}}
    @include('comments.partials.reply_form',['comment'=>$reply,'reply'=>$reply])

    {{-- Display Nested Replies --}}
    <div class="nested-replies ml-4 mt-4 border-l-2  border-l-gray-200 pl-4 hidden">
    @if($reply->replies->count() > 0)
        @include('comments.replies', ['comments' => $reply->replies])
        @endif
      </div>
  </div>
@endforeach
