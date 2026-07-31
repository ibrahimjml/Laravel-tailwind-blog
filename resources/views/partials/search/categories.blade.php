<a data-search-link href="{{ route('viewcategory', $item->name) }}" class="search-result-row">
  <span class="search-result-icon"><i class="fas {{$icon}}" aria-hidden="true"></i></span>
  <span class="min-w-0 flex-1 truncate text-sm font-semibold text-slate-800">{{ $item->name }}</span>
  <i class="fas fa-arrow-right text-xs text-slate-400" aria-hidden="true"></i>
</a>