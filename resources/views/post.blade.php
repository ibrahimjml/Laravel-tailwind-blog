<x-layout>
@push('styles')
<style>
  /*******************
   carousel latest blogs
  *******************/
.carousel-wrapper {
  position: relative;
  width: 100%;
}

.carousel {
  display: flex;
  overflow-x: auto;
  gap: 1rem;
  scroll-behavior: smooth;
  padding: 1rem 0;
}

.carousel::-webkit-scrollbar { display: none; }

.carousel-item {
  flex: 0 0 30rem;
}


.arrow-group {
  position: absolute;
  top: -2rem;
  right: 7rem;
  display: flex;
  gap: 0.5rem; 
  z-index: 10;
}
@media screen and ( 400px <= width <= 600px) {
  .arrow-group {
    right: 1rem; 
  }
}


.scroll-btn {
  width: 40px;
  height: 40px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 50%;
  font-size: 20px;
  cursor: pointer;

  display: flex;
  align-items: center;
  justify-content: center;
}

.scroll-btn:disabled {
  opacity: 0.5;
  cursor: auto;
}
  /************************
   Sticky bar nav on scroll
  *************************/
  .sticky-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 50;
    background-color: #f3f4f6; 
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    opacity: 0;          
    pointer-events: none; 
    transition: opacity 0.4s ease-in-out;
    z-index: 50;
  }
  .sticky-bar::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  height: 4px;   
  width: 0;
  background-color: #3b82f6; 
  transition: width 0.1s linear;
  width: var(--progress-width, 0%);
}
  .sticky-bar.visible {
    opacity: 1;
    pointer-events: auto;
  }
    /*************************************
   observe action bar on inseraction menu
  ***************************************/
  #action-bar.fixed-bottom {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 50;
}

#action-bar.hidden-bottom {
  transform: translateY(100%); 
  opacity: 0;
  pointer-events: none;
  transition: transform 0.3s ease, opacity 0.3s ease;
}

</style>
@endpush
{{-- 1- history links --}}
    <div class="flex  my-4 justify-center gap-3 text-blue-700 font-semibold uppercase ">
    <a href="{{route('blog')}}" class="hover:underline"><i class="fas fa-home"></i> Home</a>
    &sol;
    <a href="{{route('blog')}}" class="hover:underline">Blog</a>
  </div>
{{-- sticky trigger observer --}}
<div id="sticky-trigger"></div>
{{-- sticky bar nav --}}
<div id="stickyBar"
  class="sticky-bar  flex justify-center p-5 bg-gray-100 gap-3 text-blue-700 font-semibold uppercase">
  <a href="{{ route('blog') }}" class="hover:underline text-black">Blog</a>
  <span class="text-black">&sol;</span>
  <a href="{{ route('single.post',$post->slug) }}" class="hover:underline text-blue-700">{{ $post->slug }}</a>
</div>

{{-- 2- Post Title & user information --}}
<div class="flex flex-col items-center justify-center container   pb-2 sm:pb-6 mt-7">
  <span class="block w-full font-bold md:text-4xl text-2xl text-center capitalize">{{$post->title}}</span>

    <div class="ml-5 mt-4 flex justify-center items-center md:text-sm text-xs">
      <span class="flex justify-center items-center  font-semibold gap-2">
        
  <a href='{{route('profile',$post->user->username)}}'>
    <img src="{{$post->user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
        <a href="{{route('profile',$post->user->username)}}" class="hover:underline">{{$post->user->username}}</a>
      </span>
      
      &nbsp;&nbsp;
      <span class="md:text-lg text-xs flex items-center gap-2 ">
        <b>·</b>
        <span class="follow-status {{ !in_array($post->user->id, $authFollowings) ? 'hidden' : '' }}">
          <small>Following</small>
          <b>·</b>
        </span>
        <small>published on {{$post->created_at->format('F d, Y')}}</small>
        <b>·</b>
        <small>Last Updated on {{$post->updated_at->format('F d, Y')}}</small>
         
      </span>
    </div>
</div>
{{-- 3- post Image --}}
  <div class="relative mx-auto w-full max-w-6xl mt-2 h-[300px] md:h-[450px]">
      <img class="absolute top-0 left-0 w-full h-full object-cover rounded-none  shadow-lg hover:shadow-md" src="/storage/uploads/{{$post->image_path}}"  alt="{{$post->title}}">
    {{-- delete|edit model  --}}
      @can('view',$post)
      @include('partials.delete-edit-post-model')
      @endcan
      {{-- hashtags on post --}}
      <div class="absolute z-10 bottom-1 left-4 flex flex-wrap gap-2">
        @foreach($post->hashtags->pluck('name') as $tag)
          <span class="px-2 py-1 text-white text-xs rounded-md bg-gray-700 bg-opacity-70 font-semibold hover:bg-gray-500 transition-all">
            <a href="{{route('viewhashtag',$tag)}}"># {{ $tag }}</a>
          </span>
        @endforeach
      </div>
  </div>

{{-- 4- post description --}}

<div id="description" class="published-content max-w-4xl  md:mx-auto mx-4">
   {!! $post->description !!}
</div>

{{-- 5- Interactions menu--}}
@include('partials.interactions-post-menu')

{{-- open comments model --}}
@include('partials.comments-model')

{{-- hashtag on post  --}}
<div class="flex justify-center items-center gap-4 mt-3 mb-10">
  @foreach($post->hashtags->pluck('name') as $tag)
<span class=" p-2 text-gray-800  text-md rounded-md bg-gray-200 bg-opacity-70 font-semibold hover:bg-gray-300 transition-all">
  <a href="{{route('viewhashtag',$tag)}}">{{ $tag }}</a>
</span>
@endforeach
</div>

{{-- 6- More Articles --}}
<hr class="w-[80%] ml-auto mr-auto my-10 bg-slate-200">
<p class="text-gray-500 text-xl text-center font-semibold mt-5 uppercase ">More Articles</p>
<div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
  @foreach($morearticles as $article)
<div class=" p-3 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">
<div class="flex gap-2 items-center">
  <a href='{{route('profile',$article->user->username)}}'>
    <img loading="lazy" src="{{$article->user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
    <a href='{{route('profile',$article->user->username)}}' class="hover:underline">
      {{$article->user->username}}
    </a>
</div>
<a href="{{route('single.post',$article->slug)}}">
<img src="/storage/uploads/{{$article->image_path}}"  alt="" class="w-full h-[270px] object-cover mt-2">
<div class="flex justify-between text-sm text-gray-400 my-3">
                <p>{{$article->comments()->count()}} comments</p>
                <p>{{$article->created_at->format('F d, Y')}}</p>
               </div>
<div class="flex flex-col">
  <p class="text-xl font-bold mt-1">{{$article->title}}</p>
</div>
</a>
</div>
@endforeach
</div>
{{-- 7- Latest blogs --}}
<hr class="w-[80%] ml-auto mr-auto my-10 bg-slate-200">
<p class="text-gray-500 text-xl text-center font-semibold mt-5 uppercase ">Latest Blogs</p>
{{-- arrows --}}
<div class="carousel-wrapper">
  <div class="arrow-group">
    <button id="prevBtn" class="scroll-btn" onclick="scrollCarousel(-1)">
      <i class="fas fa-arrow-left"></i>
    </button>
    <button id="nextBtn" class="scroll-btn" onclick="scrollCarousel(1)">
      <i class="fas fa-arrow-right"></i>
    </button>
  </div>

  <div class="carousel" id="carousel">
    @foreach($latestblogs as $blogs)
      <div class="carousel-item p-3 flex-shrink-0">
        <div class="flex gap-2 items-center">
          <a href="{{ route('profile',$blogs->user->username) }}">
            <img loading="lazy"
                 src="{{ $blogs->user->avatar_url }}"
                 class="w-[40px] h-[40px] rounded-full object-cover">
          </a>
          <a href="{{ route('profile',$blogs->user->username) }}" class="hover:underline">
            {{ $blogs->user->username }}
          </a>
        </div>
        <a href="{{ route('single.post',$blogs->slug) }}">
          <img src="/storage/uploads/{{ $blogs->image_path }}"
               alt="{{$blogs->title}}"
               class="w-full h-[270px] object-cover mt-2">
               <div class="flex justify-between text-sm text-gray-400 my-3">
                <p>{{$blogs->comments()->count()}} comments</p>
                <p>{{$blogs->created_at->format('F d, Y')}}</p>
               </div>
          <p class="text-xl font-bold mt-1">{{ $blogs->title }}</p>
        </a>
      </div>
    @endforeach
  </div>
</div>
<div class="flex justify-center my-10">
  <button onclick="window.location.href='{{route('blog')}}'"
   class="p-3 text-center text border border-black hover:text-white hover:bg-black transition-all duration-150 ease-in">
    View all blogs <i class="fas fa-arrow-right ml-2"></i>
  </button>
</div>
{{-- contianer random hearts--}}
<div id="containerheart"></div>

{{-- open Toc model  --}}
@include('partials.table-of-contents-model')
{{-- open view who liked model  --}}
@include('partials.view-who-liked-model')
{{-- open views model  --}}
@include('partials.who-viewedpost-model')
{{-- open reports model  --}}
@include('partials.reports-model')

@push('scripts')
{{-- fetch follow --}}
<script>
    async function follows(eo) {
    const userId = eo.dataset.id;
    const followStatus = document.getElementsByClassName('follow-status')[0];
    let options = {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        "Accept": "application/json"
      },
    };
  
    try {
      const res = await fetch(`/user/${userId}/togglefollow`, options);
      const data = await res.json();
  
     eo.textContent = data.attached ? "unfollow" : "follow";
    eo.classList.toggle("text-red-500", data.attached);
    eo.classList.toggle("text-blue-500", !data.attached);

    if (followStatus) {
      followStatus.classList.toggle("hidden", !data.attached);
    }
  
    } catch (error) {
      console.error(error);  
    }
  }
</script>
<script>
function scrollCarousel(direction) {
  const carousel = document.getElementById('carousel');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const scrollspeed = 490; 

   prevBtn.disabled = carousel.scrollLeft <= 0;
   nextBtn.disabled = carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 1;

  carousel.scrollBy({ 
    left: scrollspeed * direction,
    behavior: 'smooth' 
  });
}
</script>
{{-- observe sticky bar  --}}
<script>
  const stickyBar = document.getElementById('stickyBar');
  const trigger = document.getElementById('sticky-trigger');

  const observer = new IntersectionObserver(
    ([entry]) => {
      
      if (!entry.isIntersecting) {
        stickyBar.classList.add('visible');
      } else {
        stickyBar.classList.remove('visible');
      }
    },
    { threshold: 0 }
  );

  observer.observe(trigger);
</script>
{{-- progress bar on sticky --}}
<script>
  const bar = document.getElementById('stickyBar');
  const desc = document.getElementById('description');

window.addEventListener('scroll', () => {
  const scrollTop = window.scrollY - desc.offsetTop;
  const maxScroll = desc.scrollHeight - window.innerHeight;
  const progress = Math.min(Math.max(scrollTop / maxScroll, 0), 1) * 100;
  bar.style.setProperty('--progress-width', progress + '%');
});
</script>
@endpush
</x-layout>
  
  
  

