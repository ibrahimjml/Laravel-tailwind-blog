<x-layout>
  {{-- hero --}}
  <div class="relative w-screen h-[90vh]">
    <div class="swiper h-full">
      <div class="swiper-wrapper h-full">
        @foreach($slides as $slide)
          <div class="swiper-slide relative flex flex-col items-center justify-center h-full bg-cover bg-center"
            style="background-image: url('{{ asset('slides/' . $slide->image_path) }}');">

            <!-- Dark overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Content -->
            <div class="absolute inset-0 flex flex-col items-center justify-center z-10 text-center px-4">
              @guest
                <h1 class="text-gray-100 text-4xl uppercase font-bold pb-10 sm:text-center">Sign in to start posting</h1>
                <a class="bg-gray-100 text-gray-700 py-2 px-5 font-bold uppercase rounded-lg mt-3 inline-block"
                  href="/login">Sign in</a>
              @else
                <h1 class="text-gray-100 text-4xl uppercase font-bold pb-10 sm:text-center">{{$slide->title}}</h1>
                @if($slide->description)
                  <p class="text-blueGray-500 text-md uppercase font-bold pb-10 sm:text-center">{{$slide->description}}</p>
                @endif
                @if($slide->link)
                  <a class="bg-gray-100 text-gray-700 py-4 px-5 font-bold uppercase rounded-lg inline-block"
                    href="{{$slide->link}}" target="_blank">visit</a>
                @else
                  <a class="bg-gray-100 text-gray-700 py-4 px-5 font-bold uppercase rounded-lg inline-block"
                    href="{{route('blog')}}">See Blog</a>
                @endif
              @endguest
            </div>

          </div>
        @endforeach
      </div>

      <!-- Controls -->
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev custom-swiper-btn"></div>
      <div class="swiper-button-next custom-swiper-btn"></div>
    </div>
  </div>
  {{-- Featured Posts --}}
  <p class="text-gray-500 text-xl text-center font-semibold mt-10 uppercase ">Featured Blogs</p>
{{-- arrows --}}
<div class="carousel-wrapper lg:px-0 px-4">
  <div class="arrow-group">
    <button id="prevBtn" class="scroll-btn" onclick="scrollCarousel(-1)">
      <i class="fas fa-arrow-left"></i>
    </button>
    <button id="nextBtn" class="scroll-btn" onclick="scrollCarousel(1)">
      <i class="fas fa-arrow-right"></i>
    </button>
  </div>

  <div class="carousel" id="carousel">
    @foreach($featuredPosts as $post)
      <div class="carousel-item relative p-3 flex-shrink-0">
        <a href="{{ route('single.post',$post->slug) }}">
          <img src="{{ $post->image_url }}"
               alt="{{$post->title}}"
               class="w-full h-[270px] object-cover mt-2">
               <div class="flex justify-between text-sm text-gray-400 my-3">
                <p>{{$post->totalcomments_count}} {{Str::plural('comment',$post->totalcomments_count)}}</p>
                <p>{{$post->created_at->format('F d, Y')}}</p>
               </div>
          <p class="text-sm font-bold mt-1">{{ $post->title }}</p>
          <p class="absolute top-7 left-4 text-sm font-bold mt-1 p-2 rounded bg-orange-400 text-blueGray-200">Featured</p>
        </a>
      </div>
    @endforeach
  </div>
</div>
  <hr class="w-[80%] ml-auto mr-auto my-10 bg-slate-200">
  {{-- oldest Posts --}}
  <p class="text-gray-700 text-lg md:text-2xl text-center font-semibold mt-5 capitalize">Oldest Posts</p>
  <div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
    @foreach($oldestPosts as $oldest)
      <div class=" p-3 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">
        <div class="flex gap-2 items-center">
          <a href='{{route('profile', $oldest->user->username)}}'>
            <img loading="lazy" src="{{$oldest->user->avatar_url}}"
              class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
          </a>
          <a href='{{route('profile', $oldest->user->username)}}' class="hover:underline">
            {{$oldest->user->username}}
          </a>
        </div>
        <a href="{{route('single.post', $oldest->slug)}}">
          <div class="relative rounded-md">
            <span
              class="absolute top-4 left-4 px-2 py-1 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70">#
              {{$trendingHashtag->name}}</span>
            <img src="{{$oldest->image_url}}" alt="" class="w-full h-[270px] object-cover mt-2">
          </div>
          <div class="flex justify-between text-sm text-gray-400 my-3">
                <p>{{$post->totalcomments_count}} comments</p>
                <p>{{$post->created_at->format('F d, Y')}}</p>
               </div>
          <div class="flex flex-col">
            <p class="text-sm font-bold mt-1">{{$oldest->title}}</p>
          </div>
        </a>
      </div>
    @endforeach
  </div>
  <div class="flex justify-center my-10">
  <button onclick="window.location.href='{{route('blog')}}'"
   class="p-3 text-center text border border-black hover:text-white hover:bg-black transition-all duration-150 ease-in">
    View all blogs <i class="fas fa-arrow-right ml-2"></i>
  </button>
</div>
  @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
      new Swiper('.swiper', {
        loop: true,
        autoplay: { delay: 5000 },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
      });
    </script>
    <!-- controll buttons on featured -->
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
  @endpush
</x-layout>