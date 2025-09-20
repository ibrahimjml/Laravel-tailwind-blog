<x-layout>

<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold  text-center pb-5">POSTS</h1>
</div>

<div class="flex items-center justify-between  md:mx-8 mx-0">
<div>
    @auth
    <a href="{{ route('createpage') }}"
       class="bg-black hover:bg-gray-800 text-white font-semibold text-sm px-4 py-2 rounded-lg transition duration-150 ease-in-out hidden sm:inline-block">
      <i class="fas fa-plus text-sm mr-2"></i>    
       Create Post
    </a>
  
    <a href="{{route('createpage')}}" 
       class="bg-black hover:bg-gray-800 text-white font-semibold h-10 w-10 text-sm px-4 py-2 rounded-lg transition duration-150 ease-in-out flex items-center justify-center sm:hidden ml-2" 
       title="create post">
    <i class="fas fa-plus "></i>
    </a>
    @endauth
</div>

  
  {{-- search bar --}}
  <div class="md:ml-28 ml-7">
    @include('partials.search-bar', ['searchquery' => $searchquery ?? ''])
  </div>


 {{-- Sort dropdown --}}
 <div class="relative flex md:flex-row flex-col items-center justify-center gap-2 ml-2">
  <label for="sort" class="text-gray-800  font-semibold text-lg">Filter :</label>
  <form action="{{url()->current()}}" method="GET">
      @if(request()->has('search'))
      <input type="hidden" name="search" value="{{ request('search') }}">
    @endif
    <div class="relative w-full">
      <select id="sort" name="sort"
        onchange="this.form.submit()"
        class="appearance-none cursor-pointer font-semibold bg-black text-white border border-gray-300 text-sm rounded-lg focus:ring-white p-2.5 ">
       <option value="latest" {{ $sorts == 'latest' ? 'selected' : '' }}>⏰ Latest</option>
       <option value="oldest" {{ $sorts == 'oldest' ? 'selected' : '' }}>📜 Oldest</option>
       <option value="mostliked" {{ $sorts == 'mostliked' ? 'selected' : '' }}>👍 Most Liked</option>
       <option value="mostviewed" {{ $sorts == 'mostviewed' ? 'selected' : '' }}>👁️ Most Viewed</option>
       <option value="followings" {{ $sorts == 'followings' ? 'selected' : '' }}>👤 Following</option>
       <option value="featured" {{ $sorts == 'featured' ? 'selected' : '' }}>⭐ Featured</option>
       <option value="hashtagtrend" {{ $sorts == 'hashtagtrend' ? 'selected' : '' }}>#️⃣ Hashtag Trend</option>
      </select>
        <!-- Custom white arrow -->
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" />
          </svg>
          </div>
    </div>
  </form>
 </div>
</div>
 {{-- show/hide Tags --}}
<div class="flex items-center justify-center mt-5">
<button id="showtags" class=" sm:flex  w-fit bg-black text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">
  <i class="fas fa-tag mr-2 text-sm text-yellow-400"></i>
  <span class="label">Tags</span>
</button>
</div>
<div id="tagcontainer" class="flex flex-wrap justify-center gap-2 px-3 mb-3 w-full max-w-full transition-all duration-500 ease-in-out h-0 overflow-hidden">
  @foreach ($tags as $tag)
    <a href="{{ route('viewhashtag', $tag->name) }}"
       class="px-2 py-1 text-sm text-white rounded-lg flex items-center justify-center whitespace-nowrap
       {{$tag->is_featured ? 
       'bg-black border-2 border-yellow-400' : 
       'bg-gray-600 border-none'}}
       ">
      @if($tag->is_featured) 🔥 @else &#x23; @endif
       {{ $tag->name }} ({{ $tag->posts_count }})
    </a>
  @endforeach
</div>

<hr>

{{-- posts feed--}}
@if($posts->count() == 0)
  <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Posts Yet</h1>
@else
@foreach ($posts as $post)    
<x-postcard :post="$post" :authFollowings="$authFollowings"/>
@endforeach
@endif
{{-- pagination --}}
<div class="container mx-auto max-w-7xl flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>

  @push('scripts')
  <script>
    const tagContainer = document.getElementById('tagcontainer');
    const showTags = document.getElementById('showtags');
    const label = showTags.querySelector('.label');
    let expanded = false;
  
    showTags.addEventListener('click', () => {
      if (!expanded) {
        tagContainer.style.height = `${tagContainer.scrollHeight}px`;
        expanded = true;
        label.textContent = 'Hide Tags';
      } else {
        tagContainer.style.height = '0';
        expanded = false;
        label.textContent = 'Tags';
      }
    });
  
  </script>  
  @endpush




</x-layout>