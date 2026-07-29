<x-layout>
  
  <div class="pt-28 bg-white lg:border-0 border-b border-gray-200  lg:shadow-none shadow-sm"><!-- start container filters -->
    <div class="container mx-auto px-4 ">
  
      <div class="flex flex-col gap-4 lg:hidden"><!-- start mobile layout -->

        <div class="flex items-center gap-3"><!-- start sidebar button and search bar-->

            <button
              class="lg:hidden flex items-center justify-center w-10 h-10 text-gray-800 border border-gray-300 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent px-4 py-2.5  transition-all duration-200"
              id="open-sidebar" aria-label="Toggle menu">
              <i class="fa fa-bars text-lg"></i>
            </button>

          <div class="flex-1">
            @include('partials.search-bar', ['searchquery' => $searchquery ?? ''])
          </div>
        </div><!-- end sidebar button and search bar-->
        
        <div class="px-0 flex items-center gap-3"><!-- start sort & tags -->
          @include('blog.partials.filter')

          @if($tags->count() > 0)
            <div class="lg:hidden  mt-5">
              <button id="showtags"
                class=" sm:flex  w-fit  py-2 px-5 rounded-lg font-bold capitalize mb-6 text-gray-800 border border-gray-300 text-sm  focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent  pr-10 transition-all duration-200">
                <i class="fas fa-tag mr-2 text-sm text-yellow-400"></i>
                <span class="label">Tags</span>
              </button>
            </div>
          @endif
        </div><!-- end sort & tags -->

      </div><!-- end mobile layout -->

      <!-- sidebar menu -->
      @include('blog.partials.__sidebar')
      
      <div class="hidden lg:flex items-center justify-between gap-6"><!-- start desktop layout -->
        <!-- Search Bar  -->
        <div class="flex-1 max-w-md">
          @include('partials.search-bar', ['searchquery' => $searchquery ?? ''])
        </div>
        <!-- Sort -->
        <div class="flex-shrink-0">
          @include('blog.partials.filter')
        </div>
      </div><!-- end desktop layout -->
    </div>
  </div><!-- end container filters -->

  <div id="tagcontainer" class="flex flex-wrap justify-center mt-5 gap-2 px-3 mb-3 w-full max-w-full transition-all duration-500 ease-in-out h-0 overflow-hidden"><!-- start tags container-->
    @foreach ($tags as $tag)
      <a href="{{ route('viewhashtag', $tag->name) }}" class="px-2 py-1 text-sm text-white rounded-lg flex items-center justify-center whitespace-nowrap
         {{$tag->is_featured ?
      'bg-black border-2 border-yellow-400' :
      'bg-gray-600 border-none'}}
         ">
        @if($tag->is_featured) 🔥 @else &#x23; @endif
        {{ $tag->name }} ({{ $tag->posts_count }})
      </a>
    @endforeach
  </div><!-- end tags container-->

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
      const tagContainer = document.getElementById('tagcontainer');
      const showTags = document.getElementById('showtags');
      const label = showTags.querySelector('.label');
      let expanded = false;

      showTags.addEventListener('click', () => {
        if (!expanded) {
          tagContainer.style.height = `${tagContainer.scrollHeight}px`;
          expanded = true;
          label.textContent = 'Hide Tags';
        } else {
          tagContainer.style.height = '0';
          expanded = false;
          label.textContent = 'Tags';
        }
      });

    </script>
  @endpush
</x-layout>