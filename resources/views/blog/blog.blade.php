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
@include('blog.partials.filter')
</div>

 {{-- show/hide Tags --}}
 @if($tags->count() > 0)
<div class="flex items-center justify-center mt-5">
<button id="showtags" class=" sm:flex  w-fit bg-black text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">
  <i class="fas fa-tag mr-2 text-sm text-yellow-400"></i>
  <span class="label">Tags</span>
</button>
</div>
@endif
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
{{-- posts feed --}}
<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
  <div class="lg:col-span-2">
<!-- Main Content  - Posts -->
@if($posts->count() == 0)
  <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Posts Yet</h1>
@else
@foreach ($posts as $post)    
<x-postcard :post="$post" :authFollowings="$authFollowings"/>
@endforeach
@endif
</div>
  <!-- Sidebar content - Recent Tags & Posts -->
  <div class="hidden lg:block mt-4 transform -translate-x-16 ">
      <!-- Recent Tags Section -->
      @include('blog.popular-tags')

      <!-- Recent Posts Section -->
      @include('blog.categories')
      <!-- Who To Follow Section -->
      @include('blog.whotofollow')
        </div>
    </div>
</div>
{{-- pagination --}}
<div class="container mx-auto max-w-4xl mt-2 mb-2">
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