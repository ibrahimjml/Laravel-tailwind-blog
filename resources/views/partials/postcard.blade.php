<div id="post-{{ $post->id }}" class="container mx-auto  max-h-[580px] sm:max-h-[540px] sm:grid grid-cols-2  gap-x-8 py-5 px-5 border-b border-gray-300">

  <div class="flex flex-col gap-4">
    <div class=" flex gap-4">
      
  {{-- checkin if image has default.jpg --}}  
  <a href='{{route('profile',$post->user->username)}}'>
    <img src="{{$post->user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
  

<div class="flex flex-col">
  <span class="text-lg ">
    <a href='{{route('profile',$post->user->username)}}' class="hover:underline font-bold">{{$post->user->username}}</a>
  </span>
  <span class="text-sm font-semibold sm:text-lg flex items-center ">
    {{$post->created_at->diffForHumans()}}
  </span>
</div>
  </div>
    
        <div class="relative md:max-h-[300px] h-200px max-w-3xl">
        <img loading="lazy" class="object-cover  shadow-lg rounded-md w-full md:h-full h-100px " src="/images/{{$post->image_path}}"  alt="{{$post->title}}">
        @if($post->is_featured)
        <span class="absolute top-4 left-4 p-2 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70">Featured</span>
        @endif
      </div>

      <div class="flex md:gap-10 sm:gap-0 justify-between items-center">
        <div class="flex gap-4">
          <span class="text-xl  font-normal">&#128420;{{$post->likes_count}}</span>
          @if($post->comments_count !== 0)
          <span class=" text-xl w-18 flex gap-1" ><svg class="w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#000000" d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/></svg>{{ $post->comments_count }}</span>
          @endif
        </div>
        <div class="flex gap-2 justify-end">
          @if (!empty($showSaveButton))
          <button saved-post-id="{{$post->id}}" onclick="unsavedposts({{$post->id}})" class=" bg-transparent border-2 text-red-700 py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-red-700 transition duration-300 mt-2">remove</button>
          @endif
          <a class="bg-transparent border-2 text-gray-700 py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300 mt-2" href="/post/{{$post->slug}}">read more</a>
        </div>
      </div>
      
    
    
  </div>

  <div class=" sm:max-h-[460px] break-words">
    <h1 class=" capitalize text-xl md:text-2xl font-bold text-gray-700 mt-8 md:mt-16 ">{{ $post->title }}</h1>
    <div class="  max-h-[100px] sm:max-h-[300px] overflow-y-auto">

        {!! Str::words(strip_tags($post->description), 90) !!}
        
    </div>

    @if($post->hashtags->isNotEmpty())
    <span class="md:mt-6 sm:mt-0 flex flex-wrap md:gap-2 gap-4 md:flex-nowrap h-fit">
      @foreach($post->hashtags as $hashtag)
      <span >
        <a href="{{route('viewhashtag',$hashtag->name)}}" class=" font-medium bg-gray-700 rounded-lg text-white p-1"># {{ $hashtag->name }}</a></span>
    @endforeach
    </span>
    @endif
</div>
  </div>