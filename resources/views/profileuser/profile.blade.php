<x-layout>

  <main class="profile-page">
    <section class="relative block h-500-px">
      <div class="absolute top-0 w-full h-full bg-center bg-cover" style="
            background-image: url('{{$user->cover}}');
          ">
        <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
      </div>
      <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px"
        style="transform: translateZ(0px)">
        <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
          version="1.1" viewBox="0 0 2560 100" x="0" y="0">
          <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
      
    </section>
    <section class="relative py-16 bg-blueGray-200">
      <div class="container mx-auto px-4 lg:w-[80%]">
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
          <div class="px-6">
          {{-- edit cover photo --}}
          @can('updateImage',$user)
         <a href="{{route('edit.coverpage',$user->id)}}" class="absolute -top-10 right-0 text-black py-1 px-3 rounded-full bg-white"><i class="fas fa-camera"></i> edit cover</a>
          @endcan
          <div class="flex flex-wrap justify-center">
              <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                <div class="relative mb-5 ">
                  <img src="{{ $user->avatar_url }}" alt=""
                    class="shadow-xl rounded-full border-2 border-gray-700 h-auto align-middle  absolute -m-16   max-w-150-px">
                  @can('updateImage', $user)
            <span
            class="absolute lg:bottom-0 lg:left-10 bottom-12 left-10 flex justify-center items-center w-6 h-6 shrink-0 grow-0 rounded-full bg-gray-600 text-white"><a
              href="{{route('edit.avatarpage',$user->id)}}"><i class="fas fa-plus" aria-hidden="true"></i></a></span>
          @endcan


                </div>
              </div>
            <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center mt-14 lg:mt-0">
              <div class="py-6 px-3 flex justify-center items-center gap-x-2">
              <div class="relative">
                  <button onclick="toggleShareMenu()" title="share" class="w-8 h-8 text-gray-500 hover:text-black transition-colors duration-150 ease-in flex items-center justify-center border border-black rounded-full">
                 <i class="fas fa-share-alt"></i>
                </button>
                {{-- share model --}}
                @include('partials.share-menu')
              </div>
              @if(auth()->user()->is($user))
              <button onclick="openQrModal()" class="w-8 h-8 text-gray-500 hover:text-black transition-colors duration-150 ease-in flex items-center justify-center border border-black rounded-full">
               <i class="fas fa-qrcode"></i>
              </button>
              @endif
              @include('profileuser.partials.qrcode-model')
              @if(auth()->user()?->isNot($user))
               <button title="report" class="w-8 h-8 text-gray-500 hover:text-black transition-colors duration-150 ease-in flex items-center justify-center border border-black rounded-full">
                <i class="fas fa-exclamation-triangle"></i>
               </button>
                  <button data-id="{{$user->id}}" onclick="follow(this)" class="px-3 py-1 w-fit rounded-lg text-center text-sm font-bold {{auth()->user()?->isFollowing($user) ? 'text-gray-600 border border-gray-600 ' : 'bg-gray-500 text-white' }}">
                    {{auth()->user()?->isFollowing($user) ? 'Following' : 'Follow' }}
                  </button>
                  @endif
                </div>
              </div>
            {{-- posts-likes-follows-count --}}
            @include('profileuser.partials.posts-likes-follows-count')
            </div>
            {{-- edit profile | open viewed model --}}
              @can('update', $user)
          <div class="flex gap-1 justify-center mb-3">
          <span class="flex justify-center "><a
            class="bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300"
            href="{{route('editprofile', $user->username)}}">edit profile</a></span>
          <button id="open-viewed"
            class="active:scale-90 bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize  hover:border-gray-700 transition duration-300"
            title="see who viewed">
            <i class="fas fa-eye"></i>
          </button>
          </div>
        @endcan
  <div class="text-center mt-2">
      <h3 class=" text-3xl font-bold text-center  tracking-wide text-gray-700">{{$user->name}} </h3>
      <span class="text-sm text-gray-400 text-center mb-2">@ {{$user->username}}</span>
    </h3>
    
      <div class="mb-2 text-blueGray-600">
    @if($user->bio == null)
    <p class="text-lg text-gray-400 text-center mb-2">Tell people about yourself</p>
    @else
      <i class="fas fa-info mr-2 text-lg text-blueGray-400"></i>{{$user->bio}}
    @endif
    </div>
  {{-- social links --}}
  <div class="flex justify-center items-center gap-3">
    @if($user->github)
    <a href="{{$user->github}}" target="_blank"><i class="fab fa-github"></i></a>
    @endif
    @if($user->linkedin)
    <a href="{{$user->linkedin}}" target="_blank"><i class="fab fa-linkedin"></i></a>
    @endif
    @if($user->twitter)
    <a href="{{$user->twitter}}" target="_blank"><i class="fab fa-twitter"></i></a>
    @endif
    @foreach ($user->socialLinks as $link)
    <a href="{{ $link->url }}" target="_blank"><i class="fas fa-link text-sm mr-1"></i>{{ $link->platform }}</a><br>
@endforeach
  </div>
  </div>
{{-- home | Activity | About me --}}
<div class="flex items-center gap-2 ml-4">
  <a href="{{route('profile',['user'=>$user->username])}}" class="nav-link p-1 font-bold text-gray-400  rounded-lg">Home</a>
  <div class="h-4 w-px bg-gray-400"></div>
  <a href="{{route('profile.activity',['user'=>$user->username])}}"  class="nav-link p-1 font-bold text-gray-400 rounded-lg">Activity</a>
  <div class="h-4 w-px bg-gray-400"></div>
  <a href="{{route('profile.aboutme',['user'=>$user->username])}}"  class="nav-link p-1 font-bold text-gray-400  rounded-lg">About me</a>
</div>

{{-- home | activity | aboutme sections --}}
<div class=" py-10 border-t border-blueGray-200 text-center">
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
          </div>
        </div>
      </div>
    </section>
  </main>
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