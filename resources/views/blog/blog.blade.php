<x-layout>
  
  <div class="pt-28 bg-white lg:border-0 border-b border-gray-200  lg:shadow-none shadow-sm"><!-- start container filters -->
    <div class="container mx-auto px-4 ">
  
      <div class="flex flex-col gap-4 lg:hidden"><!-- start mobile layout -->

        <div class="flex items-center gap-3"><!-- start sidebar button and search bar-->

            <button
              class="lg:hidden flex items-center justify-center w-10 h-10 text-gray-800 rounded-xl border border-slate-200 text-sm shadow-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent px-4 py-2.5  transition-all duration-200"
              id="open-sidebar" aria-label="Toggle menu">
              <i class="fa fa-bars text-lg"></i>
            </button>

          <div class="flex-1">
            <x-search-button :searchquer=$searchquery/>
          </div>
        </div><!-- end sidebar button and search bar-->
        
        <div class="px-0 flex items-center gap-3"><!-- start sort & news -->
          @include('blog.partials.filter')

          @if($news->isNotEmpty())
            <div class="lg:hidden  mt-5 ">
              <button id="show-news"
                class=" sm:flex  w-fit  border border-slate-200 text-sm shadow-sm py-2 px-5 rounded-lg font-bold capitalize mb-6 text-gray-800  focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent  pr-10 transition-all duration-200">
                <i class="fas fa-rss mr-2 text-sm text-yellow-400"></i>
                <span class="label">All News</span>
              </button>
            </div>
          @endif
        </div><!-- end sort & news -->

      </div><!-- end mobile layout -->

      <!-- sidebar menu -->
      @include('blog.partials.__sidebar')
      
      <div class="hidden lg:flex items-center justify-between gap-6"><!-- start desktop layout -->
        <!-- Search Bar  -->
        <div class="flex-1 max-w-md">
          <x-search-button :searchquer=$searchquery/>
        </div>
        <!-- Sort -->
        <div class="flex-shrink-0">
          @include('blog.partials.filter')
        </div>
      </div><!-- end desktop layout -->
    </div>
  </div><!-- end container filters -->

  <x-search-list />

  <div id="news-container" class="flex flex-wrap justify-center mt-5 gap-2 px-3 mb-3 w-full  max-w-full transition-all duration-500 ease-in-out h-0 overflow-hidden"><!-- start news container-->
    @foreach($news as $new)
      <a href="{{ route('news') }}?source={{ $new->name }}"
        class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-4 py-2 lg:text-sm text-xs font-medium text-slate-700 transition duration-200 hover:border-slate-900">
          <img src="{{ $new->favicon_url }}" alt="{{ $new->name }}" width="26" height="26" class="rounded-full">
          <b>{{ $new->name }}</b>
          <b>{{ '(' . $new->posts_count . ')' }}</b>

  </a>
    @endforeach
  </div><!-- end news container-->

  <hr>
  <!-- Posts feed -->
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Main Content  - Posts -->
      @if($posts->count() == 0)
        <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Posts Yet</h1>
      @else
        <div id="posts-container" class="lg:col-span-2">
          @include('blog.partials.posts-ajax', ['posts' => $posts])
        </div>
      @endif
      <!-- Sidebar content - Recent Tags & Posts -->
      <div class="hidden lg:block mt-4 transform -translate-x-16 ">
        <!-- Popular Tags Section -->
        @include('blog.popular-tags')
        <!-- Categories Section -->
        @include('blog.categories')
        <!-- latest news -->
        @include('blog.latest-news')
        <!-- Who To Follow Section -->
        @include('blog.whotofollow')
      </div>
    </div>
  </div>

  <!-- infinte scroll pagination -->
<x-infinte-scroll container="posts-container" 
                  :route="route('blog')" 
                  page-name="blog_page"
                  :current-page="$posts->currentPage()"
                  :has-more="$posts->hasMorePages()"/>

  @push('scripts')
    <script>
      const newsContainer = document.getElementById('news-container');
      const showNews = document.getElementById('show-news');
      const label = showNews.querySelector('.label');
      let expanded = false;

      showNews.addEventListener('click', () => {
        if (!expanded) {
          newsContainer.style.height = `${newsContainer.scrollHeight}px`;
          expanded = true;
          label.textContent = 'Hide News';
        } else {
          newsContainer.style.height = '0';
          expanded = false;
          label.textContent = 'All News';
        }
      });

    </script>
  @endpush
</x-layout>
