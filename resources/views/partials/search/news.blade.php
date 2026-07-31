<a data-search-link href="{{ $item->link }}" target="_blank" rel="noopener noreferrer" class="search-result-row">
  <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
    class="h-12 w-12 flex-none rounded-xl object-cover border border-slate-200">
  <div class="min-w-0 flex-1">
    <h4 class="truncate text-sm font-semibold text-slate-800">
      {{ $item->title }}
    </h4>
    <div class="mt-1 flex items-center gap-2">
      <span onclick="window.location.href='{{ route('news') }}?source={{ $item->source->name }}'"
        class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">
        {{ $item->source->name }}
      </span>
    </div>
  </div>
  <i class="fas fa-arrow-right text-xs text-slate-400" aria-hidden="true"></i>
</a>