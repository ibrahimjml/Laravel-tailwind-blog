<div class=" flex items-center gap-2 mb-2 mt-2">

    <img src="{{$comment->user->avatar_url}}"  class="w-8 h-8 overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
  
  <div class="flex flex-col">
    <div class="flex items-center gap-2">
      <a href="{{route('profile',$comment->user->username)}}" class="hover:underline">
        <strong>{{ $comment->user->name }}</strong>
      </a>
      <div>
        @if($comment->user->hasRole('Admin'))
        <b>·</b>
       <small class=" px-1 rounded-full bg-green-500 text-white font-semibold">Admin</small>
       @elseif($comment->user->hasRole('Moderator'))
       <b>·</b>
       <small class=" px-1 rounded-full bg-green-500 text-white font-semibold">Moderator</small>
       @elseif($comment->user_id === auth()->id())
       <b>·</b>
       <small class=" px-1 rounded-full bg-green-500 text-white font-semibold">Author</small>
       @endif
      </div>
    </div>
    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans()}}</span>
  </div>
</div>