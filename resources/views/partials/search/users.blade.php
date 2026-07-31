<a data-search-link href="{{ route('profile.home', $item->username) }}" class="search-result-row">
  <img src="{{ $item->avatar_url }}" alt="" class="h-10 w-10 rounded-full object-cover">
  <span class="min-w-0 flex-1">
    <span class="block truncate text-sm font-semibold text-slate-800">{{ $item->name }}</span>
    <span class="block truncate text-xs text-slate-500">{{ '@' . $item->username }}</span>
  </span>
  <i class="fas fa-arrow-right text-xs text-slate-400" aria-hidden="true"></i>
</a>