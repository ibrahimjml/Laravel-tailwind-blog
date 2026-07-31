<a data-search-link href="{{ route('single.post', $item->slug) }}" class="search-result-row">
  <img src="{{ $item->image_url }}" alt="" class="h-10 w-10 rounded-lg object-cover">
  <span class="min-w-0 flex-1">
    <span class="block truncate text-sm font-semibold text-slate-800">{{ $item->title }}</span>
    <span class="block truncate text-xs text-slate-500">{{ $item->user->username ?? 'Unknown author' }}</span>
  </span>
  <i class="fas fa-arrow-right text-xs text-slate-400" aria-hidden="true"></i>
</a>