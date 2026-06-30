<x-layout>

  <div id="search-container">
  @include('blog.partials.posts-ajax',['posts' => $posts])
  </div>


  <!-- infinte scroll pagination -->
<x-infinte-scroll container="search-container" 
                  :route="route('blog.search')"
                  page-name="search_page"
                  :current-page="$posts->currentPage()"
                  :has-more="$posts->hasMorePages()"/>


</x-layout>