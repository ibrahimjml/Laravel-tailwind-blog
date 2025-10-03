<div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
  <h3 class="text-xl font-bold text-gray-800 mb-2">Popular Tags</h3>
  <div class="w-20 h-1 bg-red-600 mb-4"></div>
  <div class="flex flex-wrap gap-2">
    @foreach($tags as $tag)
      <a href="{{ route('viewhashtag', $tag->name) }}"
        class="px-3 py-2 text-sm rounded-md font-semibold {{ $tag->is_featured ? 'bg-[#f5b576] text-gray-700' : 'bg-blueGray-200 text-blueGray-500' }}">
        @if($tag->is_featured) &#x1F525; @else &#x23; @endif {{ $tag->name }}
      </a>
    @endforeach
  </div>
</div>