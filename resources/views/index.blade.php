<x-layout>
  {{-- Hero Slides --}}
  <div class="relative w-screen h-[90vh]">
    <div class="swiper hero-swiper h-full">
      <div class="swiper-wrapper h-full">
        @foreach($slides as $slide)
          <div class="swiper-slide relative flex flex-col items-center justify-center h-full bg-cover bg-center"
            style="background-image: url('{{$slide->image}}');">

            <!-- Dark overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Content -->
            <div class="absolute inset-0 flex flex-col items-center justify-center z-10 text-center px-4">
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

  {{-- Latest News --}}

  <span class="flex items-center gap-4 p-2 rounded-lg bg-black/70 text-xl font-bold text-gray-300 mb-2 ml-4 pb-1  w-fit  my-6">
    <i class="fas fa-rss text-yellow-400"></i>
    <p >Latest News</p>
</span>
  <div class="flex flex-col lg:flex-row gap-6 mt-10 mb-6 px-4 lg:px-8">
    {{-- Latest News Slider --}}
    <div class="lg:w-2/3 w-full">

      <div>
        <div class="swiper latest-news-swiper">
          <div class="swiper-wrapper">
            @foreach($latestNews as $news)
              <div class="relative swiper-slide">
                <a href="{{ $news->link }}" class="block">
                  <img src="{{ $news->image_url }}"
                       alt="{{ $news->title }}"
                       class="w-full h-[300px] md:h-[380px] object-cover rounded-md">
                  <span class="absolute bottom-20 left-2 bg-white p-1 rounded-lg text-sm">{{ $news->category }}</span>     
                  <p class="absolute bottom-7 left-2 text-sm font-bold mt-2 text-white">{{ $news->title }}</p>
                  <span class="absolute top-2 left-2 bg-black/40 text-gray-300 p-1 rounded-lg text-sm"><i class="fas fa-clock mr-2"></i>{{ $news->created_at->diffForHumans() }} </span>
                </a>
              </div>
            @endforeach
          </div>

          <!-- Controls -->
          <div class="swiper-pagination latest-news-pagination"></div>
          <div class="swiper-button-prev latest-news-prev custom-swiper-btn"></div>
          <div class="swiper-button-next latest-news-next custom-swiper-btn"></div>
        </div>
      </div>
    </div>

    {{-- More News - aside  --}}
    <div class="lg:w-1/3 w-full flex flex-col gap-3 ">

      @foreach($moreNews as $more)
        <div class="border p-4 w-full rounded-xl bg-card shadow-sm flex gap-4 hover:shadow-md transition-shadow">
          <img
            class="w-24 h-24 object-cover rounded-md border shrink-0"
            src="{{ $more->image_url }}"
            alt="Preview">

          <div class="flex-1 min-w-0 flex flex-col">
            <h4 class="font-bold text-sm truncate">
              {{ $more->title }}
            </h4>

            <p class="text-xs mt-1 line-clamp-2">
              {{ $more->description }}
            </p>

            <div class="flex justify-between mt-auto pt-3 border-t">
              <a href="{{ $more->link }}"
                target="_blank"
                class="text-xs text-blue-500 hover:underline">
                {{ $more->source->name }}
              </a>
 
              @if ($more->category)
              <div class="flex justify-end gap-3">
              @foreach (explode(',', $more->category) as $cat)
               <span class="text-[10px] bg-gray-300 text-primary px-2 py-1 rounded-full">
                 {{ trim($cat) }}
               </span>
            
             @endforeach
             </div>
             @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>

  </div>
  <div class="flex justify-center my-10">
  <button onclick="window.location.href='{{route('news')}}'"
   class="p-3 text-center text border border-black hover:text-white hover:bg-black transition-all duration-150 ease-in">
    More News <i class="fas fa-arrow-right ml-2"></i>
  </button>
</div>
 

  {{-- Featured Posts --}}
<span class="flex items-center gap-4 p-2 rounded-lg bg-black/70 text-xl font-bold text-gray-300 mb-2 ml-4 pb-1  w-fit  my-6">
    <i class="fas fa-star text-yellow-400"></i>
    <p >Featured Articles</p>
</span>  
<div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
    @foreach($featuredPosts as $post)
      <div class=" p-3 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">
        <a href="{{ route('single.post',$post->slug) }}">
          <img src="{{ $post->image_url }}"
               alt="{{$post->title}}"
               class="w-full h-[270px] object-cover mt-2">
               <div class="flex justify-between text-sm text-gray-400 my-3">
                <p>{{$post->totalcomments_count}} {{Str::plural('comment',$post->totalcomments_count)}}</p>
                <p>{{$post->created_at->format('F d, Y')}}</p>
               </div>
          <p class="text-sm font-bold mt-1">{{ $post->title }}</p>
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

  <hr class="w-[80%] ml-auto mr-auto my-10 bg-slate-200">
  {{-- latest trend tag Posts --}}
  @if($trendingHashtag)
  <span class="flex items-center gap-4 p-2 rounded-lg bg-black/70 text-xl font-bold text-gray-300 mb-2 ml-4 pb-1  w-fit  my-6">
    <i class="fas fa-tag text-yellow-400"></i>
    <p >Trending <b class="text-amber-300">{{ '# '.$trendingHashtag->name }}</b></p>
</span>  
  @endif
  <div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
    @foreach($latestTrend as $latest)
      <div class=" p-3 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">
        <div class="flex gap-2 items-center">
          <a href='{{route('profile.home', $latest->user->username)}}'>
            <img loading="lazy" src="{{$latest->user->avatar_url}}"
              class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
          </a>
          <a href='{{route('profile.home', $latest->user->username)}}' class="hover:underline">
            {{$latest->user->username}}
          </a>
        </div>
        <a href="{{route('single.post', $latest->slug)}}">
          <div class="relative rounded-md">
            <span
              class="absolute top-4 left-4 px-2 py-1 text-white text-sm rounded-md bg-amber-300 font-semibold bg-opacity-70">#
              {{$trendingHashtag->name}}</span>
            <img src="{{$latest->image_url}}" alt="" class="w-full h-[270px] object-cover mt-2">
          </div>
          <div class="flex justify-between text-sm text-gray-400 my-3">
                <p>{{$latest->totalcomments_count}} {{ Str::plural('comment', $latest->totalcomments_count) }}</p>
                <p>{{$latest->created_at->format('F d, Y')}}</p>
               </div>
          <div class="flex flex-col">
            <p class="text-sm font-bold mt-1">{{$latest->title}}</p>
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
      // Hero slider
      new Swiper('.hero-swiper', {
        loop: true,
        autoplay: { delay: 4000 },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
      });

      // Latest News slider
      new Swiper('.latest-news-swiper', {
        loop: true,
        autoplay: { delay: 4000 },
        pagination: { el: '.latest-news-pagination', clickable: true },
        navigation: { nextEl: '.latest-news-next', prevEl: '.latest-news-prev' }
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