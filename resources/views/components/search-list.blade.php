<div id="search-list-container" class="hidden fixed inset-0 z-[60] flex items-start justify-center bg-black/55 p-4 sm:p-6 md:p-8">
  <div data-slot="command-list" class="w-full max-w-2xl overflow-hidden rounded-[24px] border border-slate-200 bg-white/95 shadow-[0_20px_60px_rgba(15,23,42,0.18)] backdrop-blur" role="listbox" tabindex="-1" aria-label="Suggestions">
    <div class="flex items-center gap-3 border-b border-slate-100 bg-slate-50/80 px-4 py-3">
      <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-sm text-white">
        <i class="fas fa-search" aria-hidden="true"></i>
      </div>
      <div class="flex-1">
      <form action="{{ route('blog.search') }}" id="search-form" method="GET" class="w-full">
      <div class="relative">
        <input type="text" name="search" 
        id="search-input"
        placeholder="Search posts, tags, users, categories..."
        value="{{ $searchquery ?? '' }}"
        autocomplete="off"
        aria-controls="search-results"
        class="w-full rounded-lg px-4 py-2.5 border-0 placeholder:text-gray-400 placeholder:text-xs text-sm transition-all duration-200"
        />
      </div>
    </form>
      </div>
      <button type="button" data-search-close
              class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] font-semibold text-slate-500">
        Esc
     </button>
    </div>

    <div class="max-h-[72vh] overflow-y-auto scroll-py-1 p-2 sm:p-3">
      <div id="search-default-state">
      <div class="flex items-center gap-3 px-3 py-2 text-sm text-slate-500">
        <span><kbd class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-sm text-slate-700">#</kbd> Tags</span>
        <span><kbd class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-sm text-slate-700">@</kbd> Users</span>
      </div>
      <!-- pages -->
      <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white p-1 shadow-sm">
        <div class="px-2 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Pages</div>
        <div role="group">
          <div class="search-list-item" role="option" data-value="Home feed" onclick="window.location.href='{{ route('home') }}'"><i class="fas fa-home" aria-hidden="true"></i>Home feed</div>
          <div class="search-list-item" role="option" data-value="Write a post" onclick="@redirectUrl(fn() => route('createpage'))"><i class="fas fa-pen" aria-hidden="true" ></i>Write a post</div>
          <div class="search-list-item" role="option" data-value="Blog" onclick="window.location.href='{{ route('blog') }}'"><i class="fas fa-image" aria-hidden="true"></i>Blog</div>
          <div class="search-list-item" role="option" data-value="Bookmarks" onclick="@redirectUrl(fn() => route('bookmarks'))"><i class="far fa-bookmark" aria-hidden="true"></i>Bookmarks</div>
          <a class="search-list-item" role="option" data-value="Latest News" href="{{ route('news') }}" rel="nofollow"><i class="fas fa-rss" aria-hidden="true"></i>Latest News</a>
          <div class="search-list-item" role="option" data-value="Profile" onclick="@redirectUrl(fn() => route('profile.home', auth()->user()->username))"><i class="far fa-user" aria-hidden="true" ></i>Profile</div>
          <div class="search-list-item" role="option" data-value="Settings" onclick="@redirectUrl(fn() => route('info'))"><i class="fas fa-cog" aria-hidden="true"></i>Settings</div>
        </div>
      </div>

      <div class="mx-2 my-2 h-px bg-slate-100"></div>

      <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white p-1 shadow-sm">
        <div class="px-2 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Other</div>
        <div role="group">
          @foreach($footerPages as $page)
          <div class="search-list-item" role="option" data-value="{{ $page->slug }}" onclick="window.location.href='{{ route('custom.page', $page->slug) }}'"><i class="fas fa-palette" aria-hidden="true"></i>{{ $page->title }}</div>
          @endforeach
        </div>
      </div>
      </div>

      <div id="search-results" class="hidden" role="status" aria-live="polite"></div>
    </div>
  </div>
</div>



@once
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('search-list-container');
    const form = document.getElementById('search-form');
    const input = document.getElementById('search-input');
    const defaultState = document.getElementById('search-default-state');
    const results = document.getElementById('search-results');

    if (!modal || !form || !input || !defaultState || !results) return;

    let timer;
    let controller;
    let currentType = 'all';

    const showDefaultState = () => {
      defaultState.classList.remove('hidden');
      results.classList.add('hidden');
      results.innerHTML = '';
    };

    const renderLoading = () => {
      defaultState.classList.add('hidden');
      results.classList.remove('hidden');
      results.innerHTML = '<div class="px-3 py-8 text-center text-sm text-slate-500"><i class="fas fa-spinner fa-spin mr-2" aria-hidden="true"></i>Searching...</div>';
    };

    const closeSearch = () => {
    modal.classList.add('hidden');
    document.documentElement.classList.remove('no-scroll');
    input.value = '';
    showDefaultState();
};

    const search = async () => {
      const query = input.value.trim();
       if (!query || query.length < 2) {
       controller?.abort();
       showDefaultState();
       return;
     }
      
      controller?.abort();
      controller = new AbortController();
      renderLoading();

      const url = new URL(form.action, window.location.origin);
      url.searchParams.set('search', query);
      url.searchParams.set('type', currentType);

      try {
        const response = await fetch(url, {
          headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
          signal: controller.signal,
        });

        if (!response.ok) throw new Error('Search request failed');

        const data = await response.json();
        results.innerHTML = data.html;
      } catch (error) {
        if (error.name === 'AbortError') return;
        results.innerHTML = '<div class="px-3 py-8 text-center text-sm text-rose-600">Unable to load search results. Please try again.</div>';
      }
    };

    // fetch by type
    results.addEventListener('click', (event) => {
    
        const tab = event.target.closest('.search-type-tab');
    
        if (!tab) return;
    
        currentType = tab.dataset.type;
    
        search();
    });
    
    input.addEventListener('input', () => {
      window.clearTimeout(timer);
      timer = window.setTimeout(search, 250);
    });

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      window.clearTimeout(timer);
      search();
    });

    // Close and empty search on Esc key
    modal.querySelector('[data-search-close]')?.addEventListener('click', closeSearch);

   // Close search modal when clicking outside the modal content or on result link
    modal.addEventListener('click', (event) => {
      const link = event.target.closest('[data-search-link]');

      if (link) {
          closeSearch();
          return;
      }
  
      if (event.target === modal) {
          closeSearch();
      }
    });
  });
</script>
@endpush
@endonce
