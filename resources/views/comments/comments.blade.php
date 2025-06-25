<div id="wrapper" class="sm:max-w-2xl  max-w-xl ml-2">
@foreach($comments as $comment)
  @if($comment->parent_id == null)
  <div class="comment relative bg-white shadow-md rounded-lg p-4 mb-4 z sm:w-[700px]">
      {{-- Comment user info --}}
      @include('comments.partials.comment_info',['comment' => $comment])
      <div>
        {{-- comment content & delete|edit comment --}}
        <p id="comment-{{ $comment->id }}" class="comment-content text-gray-700 p-2">{{ $comment->content }}</p>
        <div class="flex flex-row-reverse justify-end items-center gap-5">
          @if($comment->replies_count > 0)
          <p class="show-all reply-count text-sm text-gray-600 cursor-pointer w-fit" 
             data-reply-count="{{ $comment->replies_count }}">view {{ $comment->replies_count }} {{ Str::plural('reply', $comment->replies_count) }}
          </p>
          @endif
          {{-- delete | edit model --}}
          @can('edit',$comment)
          @include('partials.delete-edit-comment-model',['comment'=>$comment])
          @endcan
          <p class="reply-btn text-sm text-blue-600 cursor-pointer w-fit">Reply</p>

        </div>
      </div>

      {{-- Edit form --}}
      @can('edit',$comment)
      @include('comments.partials.edit_form',['comment' => $comment])
      @endcan
      {{-- Reply form --}}
      @include('comments.partials.reply_form',['comment' => $comment])

      {{-- Display Replies --}}
      <div class="reply-content ml-5 mt-4   border-l-gray-200 pl-4 hidden " id="wrapper-{{ $comment->id }}">
      @if($comment->replies->count() > 0)
          @include('comments.replies', ['comments' => $comment->replies])
          @endif
        </div>
    </div>
  @endif
@endforeach
</div>
