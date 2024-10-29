<x-header-blog/>
@if(session()->has('success'))
  <div id="parag3" class="fixed  bg-green-500 p-[10px] text-center top-[100px] left-[150px] sm:left-[40%] transform translate-y-[30px] sm:transform sm:translate-y-0 z-20">
  <p  class="text-center font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif
  @if(session()->has('error'))
  <div id="parag3" class="fixed  bg-red-500 p-[10px] text-center top-[100px] left-[150px] sm:left-[40%] transform translate-y-[30px] sm:transform sm:translate-y-0 z-20">
  <p  class="text-center font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif

{{-- posts --}}

@if($posts->count() == 0)

  <h1 class=" text-4xl p-36 font-semibold text-center w-54">No Posts Yet</h1>

@else
<h1 class=" text-4xl  p-5 font-semibold text-center text-gray-500 w-54">Showing recent posts with hashtag <span class="text-black">{{$hashtag->name}}</span></h1>
@foreach ($posts as $post)
    
<div class="container mx-auto sm:grid grid-cols-2  gap-x-8 py-5 px-5 border-b border-gray-300">

  <div class="flex flex-col gap-4">
    <div class=" flex gap-4">
      
  {{-- checkin if image has default.jpg --}}  
  @if($post->user->avatar !== "default.jpg")
  <a href='/user/{{$post->user->id}}'>
    <img src="{{Storage::url($post->user->avatar)}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
  </a>
    @else
    <a href='/user/{{$post->user->id}}'>
  <img src="storage/avatars/{{$post->user->avatar}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
 @endif
  

<div class="flex flex-col">
  <span class="text-lg ">
    <a href='{{route('profile',$post->user->username)}}' class="hover:underline font-bold">{{$post->user->username}}</a>
  </span>
  <span class="text-sm font-semibold sm:text-lg flex items-center ">
    {{$post->created_at->diffForHumans()}}
  </span>
</div>
  </div>
    
      <img class="object-cover shadow-lg rounded-md h-4/6 max-w-3xl" src="/images/{{$post->image_path}}"  alt="">
      <div class="flex gap-10 justify-between items-center">
        <div class="flex gap-4">
          <span class="text-xl  font-normal">&#128420;{{$post->likes()->count()}}</span>
          @if($post->comments()->count() !== 0)
          <span class=" text-xl w-18 flex gap-1" ><svg class="w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#000000" d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/></svg>{{ $post->comments()->count() }}</span>
          @endif
        </div>
        <div class="flex gap-2 justify-end">
          <button saved-post-id="{{$post->id}}" onclick="savedTo({{$post->id}})" class=" bg-transparent border-2 text-gray-700 py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300 mt-2">{{in_array($post->id,session('saved-to',[])) ? 'saved' : 'save'}}</button>
          <a class="bg-transparent border-2 text-gray-700 py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300 mt-2" href="/post/{{$post->slug}}">read more</a>
        </div>
        
      </div>
      
    
    
  </div>

  <div class="max-h-[460px] break-words" >
    <h1 class="text-xl md:text-2xl font-bold text-gray-700 mt-8 md:mt-14 ">{{$post->title}}</h1>
    <div class="py-12 max-h-[300px] overflow-y-auto">


  {!! Str::words($post->description,40) !!}


      
    </div>
    <span>
      @foreach($post->hashtags as $hashtag)
      <span class="b bg-yellow-200 rounded-lg p-1 text-sm text-slate-500" >
        #{{ $hashtag->name }}</span>
  @endforeach
    </span>
  </div>
  </div>
</div>
@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>

<x-footer/>
