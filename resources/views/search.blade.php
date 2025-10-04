<x-layout>

  <div id="search-posts">
  @include('blog.partials.posts',['posts' => $posts])
  </div>


<!-- pagination infinite scroll-->
<div id="loading-spinner" class="hidden text-center mt-4">
      <div class="inline-flex items-center">
        <i class="fas fa-spinner fa-spin text-gray-600 text-lg mr-2"></i>
      </div>
    </div>
<p id="reach-end" class="hidden container w-fit mx-auto">You've reached the end! 👋</p>
<!-- observe loading spinner -->
<div id="scroll-loading" class="h-10"></div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchContainer = document.getElementById('search-posts');
    const loadingSpinner = document.getElementById('loading-spinner');
    const reachEnd = document.getElementById('reach-end');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;

    const action = document.getElementById('scroll-loading');
    // Intersection
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading && hasMore) {
                loadMorePosts();
            }
        });
    }, {
        threshold: 0.1
    });

    observer.observe(action);

    async function loadMorePosts() {
        if (isLoading || !hasMore) return;
        
        isLoading = true;
        loadingSpinner.classList.remove('hidden');
        reachEnd.classList.add('hidden');

        try {
            const urlParams = new URLSearchParams(window.location.search);
            const sortOption = urlParams.get('sort') || 'latest';
            const searchquery = urlParams.get('search') || '';

            const response = await fetch(`/search?search=${encodeURIComponent(searchquery)}&page=${currentPage + 1}&sort=${sortOption}`, {
              method: 'GET',
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
              }
            });
            
            const data = await response.json();
            if (!response.ok) throw new Error('Network response was not ok');
            // Append posts
            searchContainer.insertAdjacentHTML('beforeend', data.html);  
            // Update pagination state
            currentPage = data.nextPage - 1;
            hasMore = data.hasMore;

            if (!hasMore) {
                observer.disconnect();
                reachEnd.classList.remove('hidden');
            }

        } catch (error) {
            console.error('Error loading more posts:', error);
        } finally {
            isLoading = false;
            loadingSpinner.classList.add('hidden');
            
        }
    }
});
</script>

@endpush
</x-layout>