<x-layout>
  <div class="pt-4 pb-16 bg-slate-50">
    <div class="container mx-auto px-4">
      <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
          <div>
            <h1 class="text-3xl font-semibold text-slate-900"><i class="fas fa-rss mr-3"></i>Latest News</h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-600">
              Browse recent stories from all active sources.
            </p>
          </div>
          <div class="text-sm text-slate-500">
            {{ $news->total() }} stories · {{ $sources->count() }} sources
          </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-2">
          <button type="button" data-source=""
            class="source-filter-btn rounded-full border border-slate-200 bg-white px-4 py-2 lg:text-sm text-xs font-medium text-slate-700 transition duration-200 hover:border-slate-900">
            All
          </button>

          @foreach($sources as $source)
            <button type="button" data-source="{{ $source->name }}"
              class="source-filter-btn flex items-center gap-3 rounded-full border border-slate-200 bg-white px-4 py-2 lg:text-sm text-xs font-medium text-slate-700 transition duration-200 hover:border-slate-900">
              <img src="{{ $source->favicon_url }}" alt="{{ $source->title }}" width="26" height="26"
                class="rounded-full">
              {{ $source->name }}
              <span
                class="ml-2 inline-flex h-6 min-w-[2rem] items-center justify-center rounded-full bg-slate-100 px-2 text-xs text-slate-700">{{ $source->posts_count ?? 0 }}</span>
            </button>
          @endforeach
        </div>
      </section>

      <div id="news-grid-container" class="mt-8">
        @include('latest-news.partials.news-ajax', ['news' => $news])
      </div>
    </div>
    <!-- load more ajax -->
    <x-load-more button-id="load-more-news"
                 container="news-grid-container" 
                 :route="route('news')" 
                  page-name="news_page"
                 :current-page="$news->currentPage()" 
                 :has-more="$news->hasMorePages()" 
                 button-text="Load More News" />
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const newsGridContainer = document.getElementById('news-grid-container');
        const sourceFilterButtons = document.querySelectorAll('.source-filter-btn');

        const newsRoute = new URL('{{ route('news') }}', window.location.origin).toString();
        const currentSource = '{{ $sourceName ?? '' }}';

        function setActiveSourceButton(source) {
          sourceFilterButtons.forEach((button) => {
            const buttonSource = button.dataset.source || '';
            const isActive = buttonSource === source;

            button.classList.toggle('border-slate-900', isActive);
            button.classList.toggle('bg-slate-900', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('shadow-sm', isActive);

            button.classList.toggle('border-slate-200', !isActive);
            button.classList.toggle('bg-white', !isActive);
            button.classList.toggle('text-slate-700', !isActive);
          });
        }

        function buildNewsUrl(source, pageUrl = null) {
          if (pageUrl) {
            const parsed = new URL(pageUrl, window.location.origin);
            return parsed.toString();
          }
          const url = new URL(newsRoute);
          if (source) {
            url.searchParams.set('source', source);
          } else {
            url.searchParams.delete('source');
          }
          url.searchParams.delete('news_page');
          return url.toString();
        }

        async function loadNews(url, source) {
          try {
            const response = await fetch(url, {
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
              },
            });

            if (!response.ok) {
              const text = await response.text();
              console.error('News fetch error', response.status, text);
              throw new Error('Unable to load news.');
            }

                const json = await response.json();
                newsGridContainer.innerHTML = json.html;
                setActiveSourceButton(source ?? '');

                
                const loadMoreButton = document.getElementById('load-more-news');
                const loadMoreWrapper = document.getElementById('load-more-news-container');
                const loadMoreSpinner = document.getElementById('load-more-news-spinner');
                const reachEnd = document.getElementById('reach-end');

                if (json.hasMore) {
                  if (loadMoreButton) loadMoreButton.dataset.nextPage = json.nextPage;
                  if (loadMoreWrapper) loadMoreWrapper.classList.remove('hidden');
                  if (reachEnd) reachEnd.classList.add('hidden');
                } else {
                  if (loadMoreWrapper) loadMoreWrapper.classList.add('hidden');
                  if (reachEnd) reachEnd.classList.remove('hidden');
                }

                const cleanUrl = new URL(url, window.location.origin);
                history.replaceState(null, '', cleanUrl.toString());
          } catch (error) {
            console.error(error);
            newsGridContainer.innerHTML = `<div class="rounded-3xl border border-red-200 bg-red-50 p-6 text-red-700">Unable to load news. Please refresh the page.</div>`;
          }
        }
         sourceFilterButtons.forEach((button) => {
          button.addEventListener('click', () => {
            const source = button.dataset.source || '';
            const url = buildNewsUrl(source);
            loadNews(url, source);
          });
        });

        setActiveSourceButton(currentSource);
      });
    </script>
  @endpush
</x-layout>