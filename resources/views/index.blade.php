<x-layout>
  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)
  @section('meta_description',$meta_description)
  @section('author',$author)
  
{{-- hero --}}
<div class="relative top-0 hero-bg-image flex flex-col items-center justify-center">
  @if(!auth()->user())
  <h1 class="text-center text-gray-100 text-4xl uppercase font-bold pb-10 sm:text-center"> sign in to start posting</h1>
  <a class="bg-gray-100 text-gray-700 py-2 px-5 font-bold uppercase rounded-lg mt-3" href="/login">sign in</a>
  @else
  <h1  class="text-center text-gray-100 text-4xl uppercase font-bold pb-10 sm:text-center">welcome to blog post</h1>
  <a class="bg-gray-100 text-gray-700 py-4 px-5 font-bold uppercase rounded-lg" href="/blog">See Blog</a>
  @endif
</div>

{{-- Featured Posts --}}
<p class="text-gray-700 text-lg md:text-2xl text-center font-semibold mt-5 capitalize">Featured Posts</p>
<div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
  @foreach($featuredPosts as $posts)
<div class="rounded-lg p-3 border-2 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">

<a href="{{route('single.post',$posts->slug)}}">
  <div class="relative rounded-md">
    <span class="absolute top-4 left-4 px-2 py-1 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70">Featured</span>
<img src="/storage/uploads/{{$posts->image_path}}"  alt="" class="w-full rounded-md h-[270px] object-cover mt-2">
  </div>
<div class="flex flex-col">
  <p class="text-xl font-bold mt-1">{{$posts->title}}</p>
  <p class="text-sm text-gray-500 font-semibold line-clamp-3 mt-2">{!! Str::words(strip_tags($posts->description), 20) !!}</p>
</div>
</a>
</div>
@endforeach
</div>


{{-- oldest Posts --}}
<p class="text-gray-700 text-lg md:text-2xl text-center font-semibold mt-5 capitalize">Oldest Posts</p>
<div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
  @foreach($oldestPosts as $oldest)
<div class="rounded-lg p-3 border-2 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">
<div class="flex gap-2 items-center">
  <a href='{{route('profile',$oldest->user->username)}}'>
    <img loading="lazy" src="{{$oldest->user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
    <a href='{{route('profile',$oldest->user->username)}}' class="hover:underline">
      {{$oldest->user->username}}
    </a>
</div>
<a href="{{route('single.post',$oldest->slug)}}">
  <div class="relative rounded-md">
    <span class="absolute top-4 left-4 px-2 py-1 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70"># {{$trendingHashtag->name}}</span>
<img src="/storage/uploads/{{$oldest->image_path}}"  alt="" class="w-full rounded-md h-[270px] object-cover mt-2">
  </div>
<div class="flex flex-col">
  <p class="text-xl font-bold mt-1">{{$oldest->title}}</p>
  <p class="text-sm text-gray-500 font-semibold line-clamp-3 mt-2">{!! Str::words(strip_tags($oldest->description), 20) !!}</p>
</div>
</a>
</div>
@endforeach
</div>
</x-layout>
