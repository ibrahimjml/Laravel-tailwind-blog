<div class=" flex items-center gap-2 mb-2 mt-2">

    <img src="{{$comment->user->avatar_url}}"  class="w-8 h-8 overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
  
  <div class="flex flex-col">
    <a href="{{route('profile',$comment->user->username)}}" class="hover:underline">
      <strong>{{ $comment->user->name }}</strong>
    </a>
    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans()}}</span>
  </div>
</div>