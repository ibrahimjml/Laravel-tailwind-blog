<div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
  <h3 class="text-xl font-bold text-gray-800 mb-2">Latest News</h3>
  <div class="w-20 h-1 bg-red-600 mb-4"></div>
  <div class="flex flex-wrap gap-2">
    @foreach($news as $new)
      <a href="{{ route('news') }}?source={{ $new->name }}"
        class="flex items-center gap-3 px-3 py-1 text-sm rounded-xl  border-2 border-gray-300 bg-white text-blueGray-500">
          <img src="{{ $new->favicon_url }}" alt="{{ $new->name }}" width="26" height="26" class="rounded-full">
          <b>{{ $new->name }}</b>
          <b>{{ '(' . $new->posts_count . ')' }}</b>

  </a>
    @endforeach
  </div>
</div>