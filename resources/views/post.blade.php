<x-layout>


<div class="container mx-auto ">


  <div class="relative w-3/4  mx-auto mt-2">
      {{-- delete|edit model  --}}
    @can('view',$post)
      @include('partials.delete-edit-post-model')
      @endcan

  <div class="relative mx-auto w-full max-w-6xl mt-2 h-[300px] md:h-[450px]">
      <img class="absolute top-0 left-0 w-full h-full object-cover rounded-none md:rounded-lg shadow-lg hover:shadow-md" src="/storage/uploads/{{$post->image_path}}"  alt="">
    {{-- hashtags on post --}}
      <div class="absolute z-10 bottom-1 left-4 flex flex-wrap gap-2">
        @foreach($post->hashtags->pluck('name') as $tag)
          <span class="px-2 py-1 text-white text-xs rounded-md bg-gray-700 bg-opacity-70 font-semibold hover:bg-gray-500 transition-all">
            <a href="{{route('viewhashtag',$tag)}}"># {{ $tag }}</a>
          </span>
        @endforeach
      </div>
  </div>
{{-- Post Title & user information --}}
<div class="flex flex-col items-center justify-center container mx-auto  pb-2 sm:pb-6 mt-7">
  <span class="block w-full font-bold md:text-6xl text-2xl text-center capitalize">{{$post->title}}</span>

   
    <div class="ml-5 mt-4 flex justify-center items-center md:text-sm text-xs">
      <span class="flex justify-center items-center  font-semibold gap-2">
        
  <a href='{{route('profile',$post->user->username)}}'>
    <img src="{{$post->user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
        <a href="{{route('profile',$post->user->username)}}" class="hover:underline">{{$post->user->username}}</a>
      </span>
      
      &nbsp;&nbsp;
      <span class="text-lg flex items-center gap-2">
        <b>·</b>
        <span class="follow-status {{ !in_array($post->user->id, $authFollowings) ? 'hidden' : '' }}">
          <small>Following</small>
          <b>·</b>
        </span>
         {{$post->updated_at->diffForHumans()}}
      </span>
    </div>
  
</div>

<div class="published-content w-full py-12">
  {!! $post->description !!}
</div>
</div>

{{-- like | comment | TOC | save | share Model | more menu--}}
<div id="action-bar-trigger" class="h-[1px] w-full"></div>

<div id="action-bar" class=" container  mx-auto mb-5 w-fit h-14 space-x-2 flex justify-center items-center gap-2 border-2 rounded-full px-6 py-3 text-2xl bg-white transition-all duration-300 z-50">
<div class="flex items-center justify-center">
    <span onclick="fetchLike(this)" class="cursor-pointer w-8 h-8 rounded-full flex justify-center items-center  hover:bg-gray-200 transition-bg duration-150 ">
      <i class="fa-heart like-icon {{ $post->is_liked() ? 'fas text-red-500' : 'far' }}" data-id="{{ $post->id }}"></i>
    </span>

    <span title="view who liked" id="likes-count" class="open-view-model text-sm cursor-pointer">
      {{ $post->likes_count}}
    </span>

</div>
@if($post->allow_comments)
<div class="h-4 w-px bg-gray-400"></div>
<div class="flex items-center justify-center">
  <span title="write a comment" id="openModel" class="cursor-pointer flex items-center justify-center  w-8 h-8 rounded-full   hover:bg-gray-200 transition-bg duration-150">
    <i class="far fa-comment"></i>
  </span>
  <span  class="text-sm">{{ $totalcomments }}</span>
</div>
@endif
@if(auth()->user()->is($post->user))
<div class="h-4 w-px bg-gray-400"></div>
<span id="openviewsmodel" class="cursor-pointer w-8 h-8 rounded-full flex justify-center items-center  hover:bg-gray-200 transition-bg duration-150 ">
  <i class="far fa-eye "></i>
  <span class="text-sm ml-1">{{$post->views}}</span>
</span>
@endif
<div id="divider" class="h-4 w-px bg-gray-400 hidden"></div>
<span title="table of contents" class="open-tocmodel cursor-pointer hidden">
  <i class="fas fa-list"></i>
</span>

<div class="h-4 w-px bg-gray-400"></div>
<span title="save" onclick="savedTo(this,{{$post->id}})" class="cursor-pointer flex items-center justify-center w-8 h-8 rounded-full   hover:bg-gray-200 transition-bg duration-150">
  <i class="fa-bookmark bookmark-icon {{in_array($post->id,session('saved-to',[])) ? 'fas' : 'far'}}"></i>
</span>
<div class="h-4 w-px bg-gray-400"></div>
<span class="cursor-pointer flex justify-center items-center  w-8 h-8 rounded-full   hover:bg-gray-200 transition-bg duration-150"><i class="far fa-share-square"></i></span>
<div @class([
  'relative flex  items-center',
  'hidden' => auth()->user()->cannot('report', $post) && auth()->user()->is($post->user)
])>
  <div class="h-4 w-px bg-gray-400"></div>
  <span id="openmoremodel" title="more options" class=" cursor-pointer flex justify-center items-center  w-8 h-8 rounded-full  hover:bg-gray-200 transition-bg duration-150"><i class="fas fa-ellipsis-v"></i></span>
  {{-- more menu --}}
  @include('partials.more-menu')
</div>
</div>


{{-- open comments model --}}

@include('partials.comments-model')
{{-- hashtag on post  --}}
<div class="flex justify-center items-center gap-1 mt-3">
  @foreach($post->hashtags->pluck('name') as $tag)
<span class=" p-1 text-white  text-xs rounded-md bg-gray-700 bg-opacity-70 font-semibold hover:bg-gray-500 transition-all">
  <a href="{{route('viewhashtag',$tag)}}">{{ $tag }}</a>
</span>
@endforeach
</div>
{{-- More Articles --}}
<p class="text-gray-500 text-lg text-center font-semibold mt-5 uppercase ">More Articles</p>
<div class="flex flex-col md:flex-row  md:justify-center md:items-center md:gap-2 gap-4 mt-4 mb-3">
  @foreach($morearticles as $article)
<div class="rounded-lg p-3 border-2 mx-auto md:mx-0 w-[400px] md:w-[500px] h-fit flex flex-col ">
<div class="flex gap-2 items-center">
  <a href='{{route('profile',$article->user->username)}}'>
    <img loading="lazy" src="{{$article->user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full">
    </a>
    <a href='{{route('profile',$article->user->username)}}' class="hover:underline">
      {{$article->user->username}}
    </a>
</div>
<a href="{{route('single.post',$article->slug)}}">
<img src="/storage/uploads/{{$article->image_path}}"  alt="" class="w-full h-[270px] object-cover mt-2 rounded-lg">
<div class="flex flex-col">
  <p class="text-xl font-bold mt-1">{{$article->title}}</p>
  <p class="text-sm text-gray-500 font-semibold line-clamp-3 mt-2">{!! Str::words(strip_tags($article->description), 20) !!}</p>
</div>
</a>
</div>
@endforeach
</div>
{{-- contianer random hearts--}}
<div id="containerheart"></div>

{{-- open Toc model  --}}
@include('partials.table-of-contents-model')
{{-- open view who liked model  --}}
@include('partials.view-who-liked-model')
{{-- open views model  --}}
@include('partials.who-viewedpost-model')
{{-- open reports model  --}}
@include('partials.reports-model')
{{-- All scripts ---}}
@push('scripts')
{{--  post menu edit and delete option--}}
@can('view',$post)
<script>
  const OpenModel = document.getElementById('openmodel');
  const Model = document.getElementById('model');
  OpenModel.addEventListener('click',()=>{
    if(Model.classList.contains('hidden')){
      Model.classList.remove('hidden');
    }else{
      Model.classList.add('hidden');
    }
  })
</script>
@endcan

{{-- observer for model inertactions --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const actionBar = document.getElementById('action-bar');
    const trigger = document.getElementById('action-bar-trigger');

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          
          actionBar.classList.remove('fixed', 'bottom-0', 'left-1/2', '-translate-x-1/2', 'shadow-xl');
          actionBar.classList.add('relative', 'mx-auto');
        } else {
          
          actionBar.classList.remove('relative', 'mx-auto');
          actionBar.classList.add('fixed', 'bottom-0', 'left-1/2', '-translate-x-1/2', 'shadow-xl');
        }
      });
    }, {
      threshold: 0.5 
    });

    observer.observe(trigger);
  });
</script>

{{-- open comments model if its allowed --}}
@if($post->allow_comments)
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const opencommentModel = document.getElementById('openModel');
    const closeModel = document.getElementById('closeModel');
    const commentModel = document.getElementById('commentModel');
    const bgmodel = document.getElementById('bgmodel');
  
    opencommentModel.addEventListener('click', () => {
      document.body.classList.add('no-scroll');
  
      bgmodel.classList.remove('hidden');
      setTimeout(() => {
        bgmodel.classList.add('opacity-100');
        bgmodel.classList.remove('opacity-0');

        commentModel.classList.remove('translate-x-[-110vw]');
      commentModel.classList.add('translate-x-[0]');
      }, 10); 
  

      
    });
  
    closeModel.addEventListener('click', () => {
      document.body.classList.remove('no-scroll');
  
      bgmodel.classList.remove('opacity-100');
      bgmodel.classList.add('opacity-0');
  
      commentModel.classList.remove('translate-x-[0]');
      commentModel.classList.add('translate-x-[-110vw]');
  

      setTimeout(() => {
        bgmodel.classList.add('hidden');
      }, 300); 
    });
  });
  </script>
@endif

{{-- open view who liked model  --}}

  <script>
    const openmodel = document.getElementsByClassName('open-view-model')[0];
    const viewmodel = document.getElementById('view-liked');
    const closemodel = document.getElementById('close-modal');
    openmodel.addEventListener('click',()=>{
      if(viewmodel.classList.contains('hidden')) viewmodel.classList.remove('hidden');
      document.body.classList.add('no-scroll');
    })
    closemodel.addEventListener('click',()=>{
      viewmodel.classList.add('hidden');
      document.body.classList.remove('no-scroll');
    })
  </script>
{{-- open views model  --}}
@if(auth()->user()->is($post->user))
  <script>
    const openviewsmodel = document.getElementById('openviewsmodel');
    const viewsmodel = document.getElementById('viewsmodel');
    const closeviewsmodel = document.getElementById('close-views-modal');
    openviewsmodel.addEventListener('click',()=>{
      if(viewsmodel.classList.contains('hidden')) viewsmodel.classList.remove('hidden');
      document.body.classList.add('no-scroll');
    })
    closeviewsmodel.addEventListener('click',()=>{
      viewsmodel.classList.add('hidden');
      document.body.classList.remove('no-scroll');
    })
  </script>
@endif  
{{-- open more menu --}}
  <script>
  const OpenMoreModel = document.getElementById('openmoremodel');
  const moreModel = document.getElementById('moremodel');
  OpenMoreModel.addEventListener('click',()=>{
    if(moreModel.classList.contains('hidden')){
      moreModel.classList.remove('hidden');
    }else{
      moreModel.classList.add('hidden');
    }
  })
</script>
{{-- open report menu --}}
<script>
  function openReort(){
    const more = document.getElementById('moremodel');
    const reportsmodel = document.getElementById('reportsmodel');
    const closereportsmodel = document.getElementById('close-reports-modal');

   if(!more.classList.contains('hidden')) more.classList.add('hidden');
   reportsmodel.classList.remove('hidden');

 closereportsmodel.addEventListener('click',()=>{
  reportsmodel.classList.add('hidden');
 })
  }
</script>
{{-- fetch follow --}}
<script>
    async function follows(eo) {
    const userId = eo.dataset.id;
    const followStatus = document.getElementsByClassName('follow-status')[0];
    let options = {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        "Accept": "application/json"
      },
    };
  
    try {
      const res = await fetch(`/user/${userId}/togglefollow`, options);
      const data = await res.json();
  
     eo.textContent = data.attached ? "unfollow" : "follow";
    eo.classList.toggle("text-red-500", data.attached);
    eo.classList.toggle("text-blue-500", !data.attached);

    if (followStatus) {
      followStatus.classList.toggle("hidden", !data.attached);
    }
  
    } catch (error) {
      console.error(error);
    }
  }
</script>
@endpush
</x-layout>
  
  
  

