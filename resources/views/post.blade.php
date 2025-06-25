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
@include('partials.interactions-post-menu')

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

@push('scripts')
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
  
  
  

