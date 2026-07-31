@php
    $sections = $type === \App\Enums\SearchType::ALL
        ? $results
        : [strtolower($type->value) => $results];

    $labels = [
        'posts' => \App\Enums\SearchType::POSTS->label(),
        'users' => \App\Enums\SearchType::USERS->label(),
        'tags' => \App\Enums\SearchType::TAGS->label(),
        'categories' => \App\Enums\SearchType::CATEGORIES->label(),
        'news' => \App\Enums\SearchType::NEWS->label(),
    ];
    $icons = [
        'tags' => 'fa-hashtag',
        'categories' => 'fa-tag',
    ];
    $hasResults = collect($sections)->contains(fn ($items) => $items->isNotEmpty());
@endphp

<div class="space-y-3" data-search-results>
  <div class="flex gap-2 overflow-x-auto px-2 py-3 border-b border-slate-100">

@foreach(\App\Enums\SearchType::cases() as $tab)

<button
    type="button"
    class="search-type-tab rounded-full px-3 py-1 text-xs font-semibold
    {{ $type === $tab ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600' }}"
    data-type="{{ $tab->value }}"
>
    {{ $tab->label() }}
</button>

@endforeach

</div>
  @forelse($sections as $section => $items)
    @continue($items->isEmpty())

    <section class="overflow-hidden rounded-2xl border border-slate-100 bg-white p-1 shadow-sm">
      <div class="px-2 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $labels[$section] }}</div>
      <div role="group" aria-label="{{ $labels[$section] }}">
        @foreach($items as $item)
          @if($section === 'posts')
          @include('partials.search.posts',['item' => $item])
          @elseif($section === 'users')
            @include('partials.search.users',['item' => $item])
          @elseif($section === 'tags')
            @include('partials.search.tags',['item' => $item,'icon' => $icons[$section]])
          @elseif($section === 'news')
            @include('partials.search.news',['item' => $item])
          @else
            @include('partials.search.categories',['item' => $item, 'icon' => $icons[$section]])
          @endif
        @endforeach
      </div>
    </section>
  @empty
    <div></div>
  @endforelse

  @if(!$hasResults)
    <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-10 text-center text-sm text-slate-500">
      No results found for <span class="font-semibold text-slate-700">{{ $searchquery }}</span>.
    </div>
  @endif
</div>
