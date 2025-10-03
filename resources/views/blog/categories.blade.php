<div class="bg-white border border-gray-200 rounded-2xl p-6">
  <h3 class="text-xl font-bold text-gray-800 mb-2">categories</h3>
  <div class="w-20 h-1 bg-red-600 mb-4"></div>
  <div class="flex flex-wrap gap-2">
    @foreach($categories->take(6) as $category)
      <a href="{{ route('viewhashtag', $category->name) }}"
        class="px-3 py-2 text-sm rounded-md font-semibold {{ $category->is_featured ? 'bg-[#f5b576] text-gray-700' : 'bg-blueGray-200 text-blueGray-500' }}">
        @if($category->is_featured) &#x1F525; @endif {{ $category->name . ' (' . $category->posts_count . ')'}}
      </a>
    @endforeach
  </div>
</div>