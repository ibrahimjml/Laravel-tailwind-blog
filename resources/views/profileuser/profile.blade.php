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
    <button id="open-viewed" class="active:scale-90 bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize  hover:border-gray-700 transition duration-300" title="see who viewed">
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
  {{-- posts-likes-follows-count --}}
  @include('profileuser.partials.posts-likes-follows-count',['postcount'=>$postcount,'likescount'=>$likescount,'user'=>$user])
</div>
{{-- home | Activity | About me --}}
<div class="flex items-center gap-2 ml-4">
  <a href="{{route('profile',['user'=>$user->username])}}" class="nav-link p-1 font-bold text-gray-400  rounded-lg">Home</a>
  <div class="h-4 w-px bg-gray-400"></div>
  <a href="{{route('profile.activity',['user'=>$user->username])}}"  class="nav-link p-1 font-bold text-gray-400 rounded-lg">Activity</a>
  <div class="h-4 w-px bg-gray-400"></div>
  <a href="{{route('profile.aboutme',['user'=>$user->username])}}"  class="nav-link p-1 font-bold text-gray-400  rounded-lg">About me</a>
</div>
<hr class="bg-gray-300">

{{-- home | activity | aboutme sections --}}
<div id="profile-content">
  @switch($section)
  @case('home')
    @include('profileuser.home', ['posts' => $posts])
    @break

  @case('activity')
    @include('profileuser.activity', ['user' => $user,'activities' => $activities])
    @break

  @case('about')
    @include('profileuser.aboutme', ['user' => $user])
    @break
@endswitch
</div>

{{-- open  who viewed profile model  --}}
@include('profileuser.partials.who-viewd-profile-model',['profileviews'=>$profileviews])


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
  @can('update',$user)
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
@endcan
  <script>
document.addEventListener('DOMContentLoaded', () => {
  function attachNavLinks() {
    document.querySelectorAll('a.nav-link').forEach(link => {
      const url = link.href;
      link.onclick = (e) => {
        e.preventDefault();
        loadPage(url);
      };
    });
  }

  function loadPage(url, push = true) {
    fetch(url)
      .then(res => res.text())
      .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Replace only #profile-content section
        const newContent = doc.querySelector('#profile-content');
        const currentContent = document.querySelector('#profile-content');
        if (newContent && currentContent) {
          currentContent.innerHTML = newContent.innerHTML;
        }

        const newTitle = doc.querySelector('title');
        if (newTitle) document.title = newTitle.innerText;

        if (push) history.pushState(null, '', url);

        // Reattach events (recursive)
        attachNavLinks();
  
        updateActiveLink();
      })
      .catch(err => console.error('Navigation error', err));
  }


  function updateActiveLink() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('a.nav-link').forEach(link => {
      const linkUrl = link.getAttribute('href');
      
  
      if (currentPath === new URL(linkUrl).pathname) {
        link.classList.add('activate');
        link.classList.remove('text-gray-400');
        link.classList.add('text-black');
      } else {
        link.classList.remove('activate');
        link.classList.remove('text-black');
        link.classList.add('text-gray-400');
      }
    });
  }


  attachNavLinks();
  updateActiveLink();

  // Handle back/forward navigation
  window.addEventListener('popstate', () => {
    const currentUrl = window.location.href; 
    loadPage(currentUrl, push = false);
    updateActiveLink();
  });
});

  </script>
  
@endpush


</x-layout>