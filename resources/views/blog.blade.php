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
  
    <input type="search" value="{{old('search',$searchquery ?? '')}}" class="peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none text-black placeholder:text-black dautofill:shadow-autofill peer-focus:text-primary " placeholder="Search" name="search" id="search" />

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
  
    <select id="sort" name="sort" class="cursor-pointer bg-gray-700 text-white border border-gray-300 block  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="this.form.submit()">
      <option value="latest" {{$sorts == 'latest' ? 'selected' : ''}}>Latest</option> 
      <option value="oldest" {{$sorts == 'oldest' ? 'selected' : ''}}>Oldest</option>
      <option value="mostliked" {{ $sorts == 'mostliked' ? 'selected' : '' }}>Most Liked</option>
      <option value="hashtagtrend" {{ $sorts == 'hashtagtrend' ? 'selected' : '' }}>Hashtag Trend</option>
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
    

<x-postcard :post="$post"/>

@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>

<x-footer/>
