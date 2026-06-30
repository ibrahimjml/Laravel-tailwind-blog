<x-layout>

  <div class="container mx-auto w-[90%] my-4">
      <button onclick="window.location.href='{{ route('blog') }}'" class="inline-flex items-center gap-3 rounded-full bg-black px-4 py-2 text-white transition hover:bg-slate-800">
        <i class="fas fa-arrow-left"></i>
        Back to blog
      </button>
  </div>

<!-- sliders -->
<x-sliders :model="$currentCategory" :sliders="$sliders" type="Category"/>

  <div class="container mx-auto w-[90%] flex justify-between items-center mb-6">
      <p class="text-xl font-bold tracking-[.2rem]">Articles</p>
      <div>
        @include('blog.partials.filter')
      </div>
    </div>

    @if($posts->count() == 0)
      <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center text-slate-600">
        @if($currentCategory->posts_count === 0)
          <h2 class="text-2xl font-semibold">No posts yet in {{ $currentCategory->name }}</h2>
          <p class="mt-3">Check back later for new articles in this category.</p>
        @elseif(request()->has('sort') && request('sort') !== 'latest')
          <h2 class="text-2xl font-semibold">No posts match your filter</h2>
          <p class="mt-3">Try another filter or clear the selection to see all category posts.</p>
          <div class="mt-6 inline-flex items-center justify-center gap-3">
            <a href="{{ route('viewcategory', $currentCategory) }}" class="rounded-full bg-black px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Clear filter</a>
            <span class="text-sm text-slate-500">or choose a different sort option.</span>
          </div>
        @else
          <h2 class="text-2xl font-semibold">No posts available</h2>
        @endif
      </div>
    @else
      <div id="categories-container">
        @include('categories.categories-ajax')
      </div>
    @endif
    
<!-- infinte scroll pagination -->
<x-infinte-scroll container="categories-container" 
                  :route="route('viewcategory', $currentCategory)" 
                  page-name="categories_page"
                  :current-page="$posts->currentPage()"
                  :has-more="$posts->hasMorePages()"/>
  
</x-layout>