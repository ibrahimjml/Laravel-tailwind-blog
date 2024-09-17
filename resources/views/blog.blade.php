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
<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold text-center pb-5">POSTS</h1>
</div>

<div class="flex flex-row-reverse justify-center">
  @auth
  <a class="hidden sm:flex ml-0 mr-2 sm:ml-auto w-36   bg-gray-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6" href="{{route('create')}}">create post</a>

  <a href="{{route('create')}}" class="mr-2 ml-auto active:scale-90" title="create post">
    <svg class="flex sm:hidden w-[40px] h-[40px] ml-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#45494f" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
  </a>
  @endauth

  
  {{-- search bar --}}
  
  <form action="{{route('blog.search')}}" class="w-[200px] sm:w-[350px] relative flex justify-center    translate-x-[12vw]  sm:translate-x-[30vw]  mb-5" method="GET">
    @csrf
    <input type="search" class="peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none text-black placeholder:text-black dautofill:shadow-autofill peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0" placeholder="Search" name="search" id="search" />
    <label for="search" class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[3rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-400 dark:peer-focus:text-primary">
      Search
  </label>
  <button class="relative z-[2] -ms-0.5 flex items-center rounded-e bg-gray-500 px-5  text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"  type="submit"  id="button-addon1"  >
    <span class="[&>svg]:h-5 [&>svg]:w-5">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
      </svg>
    </span>
  </button>
  </form>

  {{-- sort type posts --}}
<div class="ml-3 ">
  <form  action="/blog" method="GET">
    @csrf
    <select id="sort" name="sort" class="cursor-pointer bg-gray-50 border border-gray-300 block text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="this.form.submit()">
      <option value="latest" {{$sorts == 'latest' ? 'selected' : ''}}>Latest</option> 
      <option value="oldest" {{$sorts == 'oldest' ? 'selected' : ''}}>Oldest</option>
    </select>
  </form>
</div>
  
</div>
<hr>

{{-- posts --}}

@if($posts->count() == 0)

  <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Posts Yet</h1>

@else
@foreach ($posts as $post)
    

<div class="container mx-auto sm:grid grid-cols-2 gap-16 py-5 px-5 border-b border-gray-300">

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
        {{Str::limit($post->description,300)}}
      </p>
    </div>
    <button saved-post-id="{{$post->id}}" onclick="savedTo({{$post->id}})" class=" block bg-transparent border-2 text-gray-700 py-2 p-10 rounded-lg font-bold capitalize  hover:border-gray-700 transition duration-300 ">{{in_array($post->id,session('saved-to',[])) ? 'saved' : 'save'}}</button>
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
