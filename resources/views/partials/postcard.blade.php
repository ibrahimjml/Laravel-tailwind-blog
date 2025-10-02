<article class="container mx-auto max-h-[20%] max-w-4xl border rounded-2xl my-4 border-gray-200 bg-white py-6 px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 gap-8 group">

  <!-- Left Section: User Info + Image + Buttons -->
  <section class="flex flex-col gap-5 h-full">
    <!-- User Info -->
    <div class="flex items-center gap-4">
      <a href="{{ route('profile', $post->user->username) }}">
        <img src="{{ $post->user->avatar_url }}" class="w-10 h-10 rounded-full object-cover border" alt="avatar">
      </a>
      <div>
          <div class="flex items-center justify-center gap-3">
          <a href="{{ route('profile', $post->user->username) }}" class="text-lg font-semibold hover:underline">
            {{ $post->user->username }}
          </a>
          @php
           $isFollowing = in_array($post->user_id, $authFollowings);
           @endphp
          @if(auth()->user()->id !== $post->user_id)
          <strong>·</strong>
  
        <button class="follow px-3 py-1 {{$isFollowing ? 'bg-gray-200' : 'bg-gray-600'}} text-white rounded-lg text-center text-sm font-bold"
         onclick="fetchfollow(this)"
          data-id="{{$post->user_id}}">
          {{$isFollowing ? 'Following' : 'Follow'}}
        </button>
        @endif
         </div>
        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
      </div>
    </div>

    <!-- Post Image -->
    <div class="relative h-64 sm:h-56 w-full rounded-lg overflow-hidden">
      <a href="{{route('single.post',$post->slug)}}">
        <img loading="lazy" 
             src="{{ $post->image_url }}" 
             alt="{{ $post->title }}" 
             class=" w-full h-full object-fill blur-md bg-gray-200 shadow-md transition-all duration-700 ease-out group-hover:scale-110"
             onload="this.classList.remove('blur-md', 'bg-gray-200')">
      </a>
      @if($post->is_featured)
      <span class="absolute top-4 left-4 bg-amber-400 bg-opacity-80 text-white text-sm font-medium px-3 py-1 rounded-md">
        Featured
      </span>
      @endif
    </div>

    <!-- Interactions -->
    @if($post->categories->isNotEmpty())
    <div class="flex items-center gap-2 text-md text-gray-600">
      <b>in :</b>
      @foreach($post->categories as $category)
      @php
      $isActive = isset($currentCategory) && $currentCategory->name == $category->name;
      @endphp
       <a href="{{route('viewcategory',$category->name)}}"
          @class([
            'px-2 py-1 text-sm rounded-md',
            'bg-[#f5b576] text-gray-700 font-semibold' => $category->is_featured,
            'bg-gray-600 text-white' => !$category->is_featured,
            'bg-yellow-500' => $isActive
          ])> 
       @if($category->is_featured) &#x1F525; @endif {{ $category->name }}
    </a>
    @endforeach
    </div>
    @endif
    <div class="flex justify-between items-center ">
        <div class="flex gap-2 text-md text-gray-600">
          @if($post->likes_count)
          <span>{{ $post->likes_count }} {{ Str::plural('like',$post->likes_count) }}</span>
          <b>·</b>
          @endif
          @if($post->totalcomments_count)
          <span>{{$post->totalcomments_count}} {{ Str::plural('comment',$post->totalcomments_count) }}</span>
          <b>·</b>
          @endif
          <span>{{$post->views}} {{ Str::plural('view',$post->views)}}</span>
        </div>
      <div class="flex items-center">
        @if (!empty($showSaveButton))
        <button onclick="unsavedposts({{ $post->id }})" class="border-2 border-red-600 text-red-600 font-semibold px-4 py-1 rounded-md hover:bg-red-50 transition">
          Remove
        </button>
        @endif
        <b class="text-gray-500">&plus;</b><i class="far fa-bookmark text-gray-500"></i>
      </div>
    </div>
  </section>
  <!-- Right Section: Title + Description + Hashtags -->
  <section class="flex flex-col gap-4 md:mt-12 mt-0 h-full">
    <a href="{{route('single.post',$post->slug)}}">
    <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $post->title }}</h2>
    <div class="text-gray-600 leading-relaxed">
      {!! Str::words(strip_tags($post->description), 20) !!}
    </div>
    </a>
    @if($post->hashtags->isNotEmpty())
    <div class="flex flex-wrap gap-2 mt-4">
      @foreach($post->hashtags as $hashtag)
        @php
        $isActive = isset($currentHashtag) && $currentHashtag->name == $hashtag->name;
        @endphp
      <a href="{{ route('viewhashtag', $hashtag->name) }}" 
         @class([
          'px-2 py-1 text-sm rounded-md font-semibold', 
          'bg-[#f5b576] text-gray-700' => $hashtag->is_featured,
          'bg-gray-600 text-white' => !$hashtag->is_featured,
          'bg-yellow-400' => $isActive
           ])>
        @if($hashtag->is_featured) &#x1F525; @else &#x23; @endif {{ $hashtag->name }}
      </a>
      @endforeach
    </div>
    @endif
  </section>
</article>
