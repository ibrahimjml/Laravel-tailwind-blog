<div class="flex items-center gap-2 mb-2">
  <img src="{{$reply->user->avatar_url}}"  class="w-8 h-8 overflow-hidden flex justify-center items-center shrink-0 grow-0 rounded-full ">

<div class="flex flex-col">
  <div class="flex gap-1 items-center">
    <a href="{{route('profile',$reply->user->username)}}" class="hover:underline">
      <strong>{{ $reply->user->name }}</strong>
    </a>
      <div>
        @if($reply->user->hasRole('Admin'))
        <b>·</b>
       <small class=" px-1 rounded-full bg-green-500 text-white font-semibold">Admin</small>
       @elseif($reply->user->hasRole('Moderator'))
       <b>·</b>
       <small class=" px-1 rounded-full bg-green-500 text-white font-semibold">Moderator</small>
       @elseif($reply->user_id === $comment->post->user_id)
       <b>·</b>
       <small class=" px-1 rounded-full bg-green-500 text-white font-semibold">Author</small>
       @endif
      </div>
    @if($reply->parent)
    <p class="text-sm text-gray-600">&gt; {{ $reply->parent->user->name }} </p>
    @endif
  </div>
  <span class="text-xs">{{ $reply->created_at->diffForHumans() }}</span>
</div>
</div>