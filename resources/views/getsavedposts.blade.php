<x-header-blog/>

@if($posts->count() == 0)

  <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Saved Posts </h1>

@else
@foreach ($posts as $post)
    

<div class=" container mx-auto sm:grid grid-cols-2 gap-16 py-5 px-5 border-b border-gray-300">

  <div class="flex flex-col gap-4">
    <div class=" flex gap-4">
      
  {{-- checkin if image has default.jpg --}}  
  @if($post->user->avatar !== "default.jpg")
    <img src="{{Storage::url($post->user->avatar)}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    @else
  <img src="storage/avatars/{{$post->user->avatar}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
 @endif
  

<div class="flex flex-col">
  <span class="text-lg ">
    <a href='/user/{{$post->user->id}}' class="hover:underline font-bold">{{$post->user->name}}</a>
  </span>
  <span class="text-sm font-semibold sm:text-lg flex items-center ">
    {{$post->created_at->format('F d, Y ')}}
  </span>
</div>
  </div>
    
      <img class="object-cover" src="/images/{{$post->image_path}}"  alt="">
      <div class="flex gap-10">
        <span class=" text-xl">&#128420;{{$post->likes()->count()}}</span>
        @if($post->comments()->count() !== 0)
        <span class=" text-xl w-18 flex gap-1" ><svg class="w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#000000" d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/></svg>{{ $post->comments()->count() }}</span>
        @endif
      </div>
      
    
    
  </div>

  <div class=" break-words text-pretty " >
    <h2 class="text-xl md:text-2xl font-bold text-gray-700 mt-6 md:mt-10 text-center">{{$post->title}}</h2>
    <div>
      
      <p class="text-gray-500  truncate text-pretty text-l text-center sm:text-xl py-8 leading-6 font-medium">
        {{$post->description}}
      </p>
    </div>
    <button saved-post-id="{{$post->id}}" onclick="savedTo({{$post->id}})" class=" block bg-transparent border-2 text-gray-700 py-2 p-10 rounded-lg font-bold capitalize  hover:border-gray-700 transition duration-300">{{in_array($post->id,session('saved-to',[])) ? 'saved' : 'save'}}</button>
    <a class="bg-transparent border-2 text-gray-700 py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300 mt-2" href="/post/{{$post->slug}}">read more</a>
  </div>
  </div>
</div>
@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
<x-footer/>