<x-layout>
  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)
  @section('author',$author)
  @section('meta_description',$meta_description)

<div class="container mx-auto ">


  <div class="relative w-3/4  mx-auto mt-2">
      {{-- delete|edit model  --}}
    @can('view',$post)
      @include('partials.delete-edit-post-model',['post'=>$post])
      @endcan

  <div class="relative mx-auto w-full max-w-6xl mt-2 h-[300px] md:h-[450px]">
      <img class="absolute top-0 left-0 w-full h-full object-cover rounded-none md:rounded-lg shadow-lg hover:shadow-md" src="/images/{{$post->image_path}}"  alt="">
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
      <span class="text-lg">
        · {{$post->updated_at->diffForHumans()}}
      </span>
    </div>
  
</div>

<div class="w-full py-12">
  {!! $post->description !!}
</div>
</div>

{{-- like | comment | save | share Model --}}
<div id="action-bar-trigger" class="h-[1px] w-full"></div>

<div id="action-bar" class=" container  mx-auto mb-5 w-fit space-x-2 flex justify-center items-center gap-2 border-2 rounded-full px-6 py-3 text-2xl bg-white transition-all duration-300 z-50">
  <span onclick="fetchLike(this)" class="cursor-pointer flex items-center gap-2">
    <i class="fa-heart like-icon {{ $post->is_liked() ? 'fa-solid text-red-500' : 'fa-regular' }}" data-id="{{ $post->id }}"></i>
    <span id="likes-count" class="text-sm">{{ $post->likes()->count()}}</span>
  </span>
<div class="h-4 w-px bg-gray-400"></div>
<span id="openModel" class="cursor-pointer flex items-center gap-2">
  <i class="fa-regular fa-comment"></i>
  <span  class="text-sm">{{ $post->commentsCount() }}</span>
</span>
<div class="h-4 w-px bg-gray-400"></div>
<span  onclick="savedTo(this,{{$post->id}})" class="cursor-pointer flex items-center gap-2">
  <i class="fa-bookmark bookmark-icon {{in_array($post->id,session('saved-to',[])) ? 'fa-solid' : 'fa-regular'}}"></i>
</span>
<div class="h-4 w-px bg-gray-400"></div>
<span class="cursor-pointer flex items-center gap-2"><i class="fa-solid fa-share-nodes"></i></span>
</div>


{{-- open comments model --}}

<div id="bgmodel" class="fixed hidden inset-0 z-50 opacity-0 transition-opacity duration-300 ease-in-out">
  
  <div class="absolute inset-0 bg-gray-900 opacity-60"></div>

  <div id="commentModel" class="relative h-full w-screen md:w-[50%] bg-white overflow-y-auto shadow-xl translate-x-[-110vw] transition-all duration-300 ease-in-out">
  <span id="closeModel" title="close" class="cursor-pointer absolute top-4 right-4 text-xl"><i class="fa-solid fa-xmark"></i></span>
    {{-- Comment Form --}}
    <p class="w-fit md:text-xl text-md mb-3 p-2 font-semibold">
      Comments (<span id="comment-count-number">{{ $post->commentsCount() }}</span>)
    </p>
    <div class="w-fit mb-4 border-2 p-1 rounded-lg px-5 mx-auto">
      @include('comments.partials.comment_form', ['post' => $post])
    </div>

       {{-- display comments | replies UI --}}
    @include('comments.comments',['comments'=>$post->comments])
  </div>
</div>
{{-- hashtag on post  --}}
<div class="flex justify-center items-center gap-1 mt-3">
  @foreach($post->hashtags->pluck('name') as $tag)
<span class=" p-1 text-white  text-xs rounded-md bg-gray-700 bg-opacity-70 font-semibold hover:bg-gray-500 transition-all">
  <a href="{{route('viewhashtag',$tag)}}">{{ $tag }}</a>
</span>
@endforeach
</div>
{{-- More Articles --}}
<p class="text-gray-500 text-lg text-center font-semibold mt-5 uppercase">More Articles</p>
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
<img src="/images/{{$article->image_path}}"  alt="" class="w-full h-[270px] object-cover mt-2">
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

  
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const actionBar = document.getElementById('action-bar');
    const trigger = document.getElementById('action-bar-trigger');

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          // Trigger is visible (user is at bottom), show naturally
          actionBar.classList.remove('fixed', 'bottom-0', 'left-1/2', '-translate-x-1/2', 'shadow-xl');
          actionBar.classList.add('relative', 'mx-auto');
        } else {
          // Trigger is out of view — fix it to bottom
          actionBar.classList.remove('relative', 'mx-auto');
          actionBar.classList.add('fixed', 'bottom-0', 'left-1/2', '-translate-x-1/2', 'shadow-xl');
        }
      });
    }, {
      threshold: 0.5 // trigger is half-visible
    });

    observer.observe(trigger);
  });
</script>

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
  


</x-layout>
  
  
  

