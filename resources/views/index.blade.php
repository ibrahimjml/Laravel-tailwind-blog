<x-layout>

  
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
<p class="text-center text-3xl font-bold text-white p-3 bg-yellow-500 w-fit rounded-lg container m-auto mt-5">Featured Posts</p>
<div class="container sm:grid md:flex  py-[30px] h-fit justify-center gap-4">
@foreach($featuredPosts as $posts)
<div class="flex flex-col justify-center items-center">
  <div class="mx-4 md:mx-6 relative group  md:w-[400px] md:h-[250px] w-xl h-[250px]">
    <span class="absolute top-4 left-4 p-2 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70">Featured</span>

    <img loading="lazy" class="object-cover shadow-lg rounded-md w-full h-full" src="/images/{{$posts->image_path}}" alt="">

    <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition duration-300 rounded-md flex items-center justify-center">
      <a href="/post/{{$posts->slug}}" class="bg-white text-black font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 transition">
        View Post
      </a>
    </div>
  </div>
  <div class="flex flex-col items-center justify-center m-10 sm:m-0">
    <h2 class="font-bold text-gray-700 text-4xl capitalize">{{$posts->title}}</h2>
  </div>
</div>
  @endforeach
</div>
<hr>

{{-- latest posts --}}
<p class="text-center text-3xl font-bold text-white p-3 bg-slate-500 w-fit rounded-lg container m-auto mt-5">Most Trending </p>
<div class="container sm:grid md:flex  py-[30px] h-fit justify-center gap-4">
@foreach($latestPosts as $latest)
<div class="flex flex-col justify-center">
    <div class="mx-2 md:mx-6 relative group">
      <span class="absolute top-4 left-4 p-2 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70"># {{$trendingHashtag->name}}</span>
  
      <img loading="lazy" class="object-cover shadow-lg rounded-md max-w-l md:max-w-[400px] md:max-h-[200px]" src="/images/{{$latest->image_path}}" alt="">
  
      <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition duration-300 rounded-md flex items-center justify-center">
        <a href="/post/{{$latest->slug}}" class="bg-white text-black font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 transition">
          View Post
        </a>
      </div>
    </div>
    <div class="flex flex-col items-center justify-center m-10 sm:m-0">
      <h2 class="font-bold text-gray-700 text-4xl capitalize">{{$latest->title}}</h2>
    </div>
</div>
  @endforeach
</div>
</x-layout>
