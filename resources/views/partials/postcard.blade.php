<div class="container mx-auto max-w-7xl border rounded-md my-4 border-gray-200 bg-white shadow-md hover:shadow-xl transition-shadow duration-300 py-6 px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 gap-8">


  <!-- Left Section: User Info + Image + Buttons -->
  <div class="flex flex-col gap-5">
    <!-- User Info -->
    <div class="flex items-center gap-4">
      <a href="{{ route('profile', $post->user->username) }}">
        <img src="{{ $post->user->avatar_url }}" class="w-10 h-10 rounded-full object-cover border" alt="avatar">
      </a>
      <div>
        <a href="{{ route('profile', $post->user->username) }}" class="text-lg font-semibold hover:underline">
          {{ $post->user->username }}
        </a>
        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
      </div>
    </div>

    <!-- Post Image -->
    <div class="relative h-64 sm:h-72 w-full rounded-lg overflow-hidden">
      <img loadind="lazy" src="/images/{{ $post->image_path }}" alt="{{ $post->title }}" class="w-full h-full object-cover shadow-md">
      @if($post->is_featured)
      <span class="absolute top-4 left-4 bg-amber-400 bg-opacity-80 text-white text-sm font-medium px-3 py-1 rounded-md">
        Featured
      </span>
      @endif
    </div>

    <!-- Interactions -->
    <div class="flex justify-between items-center">
      <div class="flex gap-5 text-lg text-gray-600">
        @if($post->likes_count)
        <span><i class="fa-solid fa-heart text-red-500"></i> {{ $post->likes_count }}</span>
        @endif
        @if($post->comments_count)
        <span><i class="fa-solid fa-comment text-blue-500"></i> {{ $post->comments_count }}</span>
        @endif
      </div>
      <div class="flex gap-3">
        @if (!empty($showSaveButton))
        <button onclick="unsavedposts({{ $post->id }})" class="border-2 border-red-600 text-red-600 font-semibold px-4 py-1 rounded-md hover:bg-red-50 transition">
          Remove
        </button>
        @endif
        <a href="/post/{{ $post->slug }}" class="border-2 border-gray-600 text-gray-700 font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition">
          Read More
        </a>
      </div>
    </div>
  </div>

  <!-- Right Section: Title + Description + Hashtags -->
  <div class="flex flex-col gap-4 md:mt-12 mt-0">
    <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $post->title }}</h2>
    <div class="text-gray-600 leading-relaxed max-h-52 overflow-y-auto">
      {!! Str::words(strip_tags($post->description), 90) !!}
    </div>

    @if($post->hashtags->isNotEmpty())
    <div class="flex flex-wrap gap-2 mt-4">
      @foreach($post->hashtags as $hashtag)
      <a href="{{ route('viewhashtag', $hashtag->name) }}" class="bg-gray-700 text-white px-2 py-1 text-sm rounded-md">
        #{{ $hashtag->name }}
      </a>
      @endforeach
    </div>
    @endif
  </div>
</div>
