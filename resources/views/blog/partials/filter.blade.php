<div class="flex-1  lg:w-auto">
  <form action="{{url()->current()}}" method="GET" class="w-full">
    @if(request()->has('search'))
      <input type="hidden" name="search" value="{{ request('search') }}">
    @endif
    <div class="relative w-full">
      <select id="sort" name="sort" onchange="this.form.submit()"
        class="appearance-none cursor-pointer w-full lg:w-auto bg-white text-gray-800 border border-gray-300 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent px-4 py-2.5 pr-10 transition-all duration-200 font-medium">
        <option value="latest" {{ $sorts == 'latest' ? 'selected' : '' }}>⏰ Latest</option>
        <option value="oldest" {{ $sorts == 'oldest' ? 'selected' : '' }}>📜 Oldest</option>
        <option value="mostliked" {{ $sorts == 'mostliked' ? 'selected' : '' }}>👍 Most Liked</option>
        <option value="mostviewed" {{ $sorts == 'mostviewed' ? 'selected' : '' }}>👁️ Most Viewed</option>
        <option value="followings" {{ $sorts == 'followings' ? 'selected' : '' }}>👤 Following</option>
        <option value="featured" {{ $sorts == 'featured' ? 'selected' : '' }}>⭐ Featured</option>
        <option value="hashtagtrend" {{ $sorts == 'hashtagtrend' ? 'selected' : '' }}>#️⃣ Hashtag Trend</option>
      </select>
      <!-- Custom dropdown arrow -->
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
  </form>
</div>