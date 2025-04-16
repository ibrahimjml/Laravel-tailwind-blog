<x-header-blog>

  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)


<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold  text-center pb-5">POSTS</h1>
</div>

<div class="flex flex-row-reverse justify-center">
  @auth
  <a class="hidden sm:flex ml-0 mr-2 sm:ml-auto w-36   bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6" href="{{route('create')}}">create post</a>

  <a href="{{route('create')}}" class="mr-2 ml-auto active:scale-90" title="create post">
    <svg class="flex sm:hidden w-[40px] h-[40px] ml-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#45494f" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
  </a>
  @endauth

  
  {{-- search bar --}}
  
  @include('partials.search-bar', ['searchquery' => $searchquery ?? ''])

  {{-- sort type posts --}}
<div class="ml-3 ">
  {{-- <label for="sort" class="text-sm font-semibold">sort by :</label> --}}
  <form  action="/blog" method="GET">
  
    <select id="sort" name="sort" class="cursor-pointer bg-gray-500 text-white border border-gray-300 block  text-sm rounded-lg focus:ring-blue-500   w-full p-2.5  " onchange="this.form.submit()">
      <option value="latest" {{$sorts == 'latest' ? 'selected' : ''}}>Latest</option> 
      <option value="oldest" {{$sorts == 'oldest' ? 'selected' : ''}}>Oldest</option>
      <option value="mostliked" {{ $sorts == 'mostliked' ? 'selected' : '' }}>Most Liked</option>
      <option value="featured" {{ $sorts == 'featured' ? 'selected' : '' }}>Featured</option>
      <option value="hashtagtrend" {{ $sorts == 'hashtagtrend' ? 'selected' : '' }}>Hashtag Trend</option>
    </select>
  </form>
</div>
  
</div>
<div class="flex justify-center">
<button id="showtags" class=" sm:flex  w-fit   bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">Show Tags</button>
</div>
<div id="tagcontainer" class="flex flex-wrap justify-center gap-2 px-3 mb-3 w-full max-w-full transition-all duration-500 ease-in-out h-0 overflow-hidden">
  @foreach ($tags as $tag)
    <a href="{{ route('viewhashtag', $tag->name) }}"
       class="px-2 py-1 bg-gray-500 text-sm text-white rounded-lg flex items-center justify-center whitespace-nowrap">
      {{ $tag->name }} ({{ $tag->posts_count }})
    </a>
  @endforeach
</div>
<hr class="dark: mix-blend-color-dodge">

{{-- posts --}}

@if($posts->count() == 0)

  <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Posts Yet</h1>

@else
@foreach ($posts as $post)
    

<x-postcard :post="$post"/>

@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>

<x-footer/>
<script>
  const tagContainer = document.getElementById('tagcontainer');
  const showTags = document.getElementById('showtags');
  let expanded = false;

  showTags.addEventListener('click', () => {
    if (!expanded) {
      tagContainer.style.height = `${tagContainer.scrollHeight}px`;
      expanded = true;
      showTags.textContent = 'Hide Tags';
    } else {
      tagContainer.style.height = '0';
      expanded = false;
      showTags.textContent = 'Show Tags';
    }
  });

</script>
</x-header-blog>