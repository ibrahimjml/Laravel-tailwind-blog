<x-layout>
  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)
  @section('author',$author)
  @section('meta_description',$meta_description)

  
<div class=" container mx-auto mt-[30px]">

  <div class="relative w-[170px]  h-[170px]   mx-auto  mb-5">
    <img src="{{$user->avatar_url}}" alt=""  class="w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-gray-500">
    @can('update',$user)
    <span class="absolute  bottom-[18px] right-[10px] flex justify-center items-center w-6 h-6 shrink-0 grow-0 rounded-full bg-gray-600 text-white"><a href="/edit-avatar/{{$user->id}}"><i class="fa fa-plus" aria-hidden="true"></i></a></span>
    @endcan
    

  </div>
  @can('update',$user)
<div class="flex gap-1 justify-center mb-3">
    <span class="flex justify-center "><a class="bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300" href="{{route('editprofile',$user->username)}}">edit profile</a></span>
    <button id="open-viewed"  class=" active:scale-90 bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize  hover:border-gray-700 transition duration-300" title="see who viewed">
      <i class="fa-solid fa-eye"></i>
    </button>
</div>
  @endcan
  <div class="flex flex-col pb-3 justify-center items-center">
    <h1 class=" text-3xl font-bold text-center  tracking-wide text-gray-700">{{$user->name}} </h1>
    <span class="text-sm text-gray-400 text-center mb-2">@ {{$user->username}}</span>
    @if($user->bio == null)
    <p class="text-lg text-gray-400 text-center mb-2">Tell people about yourself</p>
    @else
    <p class="text-lg text-gray-600 text-center font-semibold mb-2">{{$user->bio}}</p>
    @endif
    @if(auth()->user()->id !== $user->id)
    <button data-id="{{$user->id}}" onclick="follow(this)" class="px-3 py-1 w-fit rounded-lg text-center text-sm font-bold {{auth()->user()->isFollowing($user) ? 'text-gray-600 border border-gray-600 ' : 'bg-gray-600 text-white' }}">
      {{auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}
    </button>
    @endif
  </div>
</div>
<div class=" mx-auto flex  justify-center gap-6">
  
  <div class="flex flex-col">
    <p class="text-lg font-bold ">posts</p>
    {{-- count posts --}}
    <p class="text-lg font-bold text-center">{{$postcount}}</p>
  </div>

<div class="flex  w-30 gap-5">
  {{-- likes count --}}
  <div class="flex flex-col">
  <p class="text-lg font-bold text-center">Total likes</p>
  <p class="text-lg font-bold text-center">{{$likescount}}</p>
  </div>
  <div class="flex flex-col">
{{-- followers counts --}}
    <p class="text-lg font-bold text-center">Followers</p>
    <p id="followers-count" class="text-lg font-bold text-center">{{$user->followers()->count()}}</p>
  </div>
  <div class="flex flex-col">
    {{-- followings counts --}}
        <p class="text-lg font-bold text-center">Following</p>
        <p  class="text-lg font-bold text-center">{{$user->followings()->count()}}</p>
      </div>
</div>

</div>

<hr>
@if($posts->count() == 0)

<h1 class=" text-4xl  p-6 font-semibold text-center w-54">No Posts</h1>
@else
<div class="mt-5 sm:grid grid-cols-4 gap-6 space-y-6 sm:space-y-0">
  @foreach($posts as $post)
  <div class="flex flex-wrap items-center justify-center ">
    <a  href="/post/{{$post->slug}}">
      <img src="/images/{{$post->image_path}}" alt="" class="ml-auto mr-auto w-[80%] rounded-lg mb-5">
    </a>
    
  </div>
  
  @endforeach
  @endif
</div>
{{-- open  who viewed profile model  --}}
@include('partials.who-viewd-profile-model',['profileviews'=>$profileviews])


@push('scripts')
<script>
  async function follow(eo) {
    const userId = eo.dataset.id;
  
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
  
  
      eo.textContent = data.attached ? "Following" : "Follow";
      const followerscount = document.querySelector('#followers-count');
      let countfollowers = parseInt(followerscount.textContent);
  
      eo.classList.remove('text-gray-600', 'border', 'border-gray-600', 'bg-gray-600', 'text-white');
  
      if (data.attached) {
        eo.classList.add('text-gray-600', 'border', 'border-gray-600');
        followerscount.textContent = countfollowers +1;
      } else {
        eo.classList.add('bg-gray-600', 'text-white');
        followerscount.textContent = countfollowers -1;
      }
  
    } catch (error) {
      console.error(error);
    }
  }
  
  </script>
  {{-- open who view profile model   --}}
  <script>
    const openmodel = document.getElementById('open-viewed');
    const viewmodel = document.getElementById('view-profile');
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
@endpush


</x-layout>