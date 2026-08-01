
<!-- desktop -->
<div class="search-button hidden lg:flex w-96 cursor-pointer items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm transition hover:border-slate-300 hover:shadow-md">
    <div class="flex items-center gap-3 text-slate-400">
        <i class="fas fa-search text-sm"></i>
        <span class="text-xs">
            Search posts, tags, users, categories...
        </span>
    </div>

    <div class="flex items-center gap-2 text-sm">
        <kbd class="rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 text-[11px] font-medium text-slate-500">
            Ctrl
        </kbd>
        <small>&plus;</small>
        <kbd class="rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 text-[11px] font-medium text-slate-500">
            K
        </kbd>
    </div>
</div>
<!-- mobile -->
<div class="search-button flex w-full max-w-sm cursor-pointer items-center justify-between rounded-xl border border-slate-200 bg-white px-2 py-2 text-sm shadow-sm transition hover:border-slate-300 hover:shadow-md lg:hidden">
    <div class="flex min-w-0 flex-1 items-center gap-3 text-slate-600">
        <i class="fas fa-search flex-none text-xs"></i>
    </div>
</div>
@once
@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const searchButtons = document.querySelectorAll('.search-button');
      const searchContainer = document.getElementById('search-list-container');

      if (!searchContainer) {
        return;
      }

      const openSearch = () => {
        searchContainer.classList.remove('hidden');
        document.documentElement.classList.add('no-scroll');
      };

      const closeSearch = () => {
        searchContainer.classList.add('hidden');
        document.documentElement.classList.remove('no-scroll');
      };

      searchButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
          event.preventDefault();
          openSearch();
        });
      });

      document.addEventListener('keydown', (event) => {
        if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
          event.preventDefault();
          openSearch();
        }

        if (event.key === 'Escape') {
          closeSearch();
        }
      });

      searchContainer.addEventListener('click', (event) => {
        if (event.target === searchContainer) {
          closeSearch();
        }
      });
    });
  </script>
@endpush
@endonce
