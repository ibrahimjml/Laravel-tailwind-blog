<x-layout>
<main class="admin w-screen  grid grid-cols-[25%,75%] overflow-hidden transition-all ease-in-out duration-300 p-5">
<x-admin-sidebar/>
  <section id="main-section" class=" p-5 transition-all ease-in-out duration-300 ">
  
    <div class="top-section flex gap-5">
      <span id="spn" class="text-4xl text-gray-400  cursor-pointer">&leftarrow;</span>
      <h2 id="title-body" class="text-black text-2xl font-bold p-3">Admin Panel</h2>
    </div>
    {{-- widgets sections --}}
    <div class="flex flex-wrap gap-2 md:flex-nowrap items-center ">
      <x-widgets-posts 
      :posts="$post" 
      :hashtags="$hashtags"
      :likes="$likes"
      :comments="$comments"/>
      <x-widgets-users :users="$user" :blocked="$blocked"/>
    </div>

{{-- Notifications section --}}
<div class="mt-10 w-full">

  <div class="flex gap-1 border-b-2 justify-between border-gray-600 w-full py-2 items-center">
  <div class="flex items-center gap-2">
        <p class="text-xl font-bold text-gray-700 ">All Notifications</p>
        <span class="flex items-center">
          (<span class="h-4 w-4 bg-red-500 text-white font-medium flex justify-center items-center rounded-full p-1 text-xs">
            {{ auth()->user()->unreadNotifications->count() }}
          </span>)
        </span>
        
  </div>
<form  action="{{route('admin-page')}}" method="GET" class="flex gap-2 items-center">
{{-- sort Read/Unread --}}
<select id="sort" name="sort" class="font-bold cursor-pointer bg-gray-700 text-white border border-gray-300 block  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="this.form.submit()">
  <option value="">Sort</option>
  <option value="read" {{ request('sort') === 'read' ? 'selected' : '' }}>Read</option> 
  <option value="unread" {{ request('sort') === 'unread' ? 'selected' : '' }}>Unread</option>
</select>
{{-- sort by type --}}
<select name="type" class="font-bold cursor-pointer bg-gray-700 text-white border border-gray-300 text-sm rounded-lg p-2.5" onchange="this.form.submit()">
  <option value="">Types</option>
  <option value="newuser" {{ request('type') === 'newuser' ? 'selected' : '' }}>Registered</option>
  <option value="Postcreated" {{ request('type') === 'Postcreated' ? 'selected' : '' }}>PostCreated</option>
  <option value="comments" {{ request('type') === 'comments' ? 'selected' : '' }}>Comments</option>
  <option value="reply" {{ request('type') === 'reply' ? 'selected' : '' }}>Replies</option>
  <option value="viewedprofile" {{ request('type') === 'viewedprofile' ? 'selected' : '' }}>Viewed</option>
  <option value="like" {{ request('type') === 'like' ? 'selected' : '' }}>Likes</option>
  <option value="follow" {{ request('type') === 'follow' ? 'selected' : '' }}>Follows</option>
</select>
      </form>
  </div>

  @forelse ($notifications as $notification)
      <div class="flex items-start gap-2 p-3 rounded-md hover:bg-gray-100 transition w-full ">
    
      <span class="mt-2 text-sm text-gray-500">
          @if($notification->read_at === null)
              <i class="fa-solid fa-circle text-blue-500 text-[10px]"></i>
          @else
              <i class="fa-regular fa-circle text-gray-300 text-[10px]"></i>
          @endif
      </span>

    {{-- Notification Content --}}
    <li class="flex items-start gap-3 list-none w-full">
      @php
      $type = $notification->data['type'];
      $message = $notification->data['message'] ?? '';
      $url = route('notifications.read', $notification->id);
      $username = null;

      foreach ($notification->data as $key => $value) {
      if (!$username && str_contains($key, 'username')) {
      $username = $value;
      break;
        }
      }

       $user = $users[$username] ?? null;
       $avatar = $user?->avatar_url ?? asset('storage/avatars/default.png');
      @endphp
    
    <a href="{{ route('profile', $username) }}">
        <img src="{{ $avatar }}" class="w-8 h-8 rounded-full object-cover" alt="">
    </a>

          
      <div class="flex-1">
          <a href="{{ $url }}" class="text-sm text-gray-700 hover:text-black font-medium block">
              {{ $message }}
          </a>
          <div class="flex justify-between items-center gap-4 mt-1">
              <small class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</small>
              <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-xs text-white bg-red-500 px-2 rounded-full">x</button>
              </form>
          </div>
      </div>
    </li>
  </div>
  @empty
    @php  
    $sort = request('sort');
    $type = request('type');
     @endphp
    <div class="grid place-items-center h-40 w-full">
      <p class="text-xl font-bold">
        No 
        @if($type)
        {{ ucfirst($type)}}
        @endif
        @if($sort == 'read')
        Read
        @elseif($sort === 'unread')
        Unread
        @endif
        Notifications
      </p>
    </div>
@endforelse
{!! $notifications->links() !!}
</div>
  </section>
</main>
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const url = new URL(window.location.href);
    const params = url.searchParams;

    // Remove empty parameters
    ['sort', 'type'].forEach(key => {
      if (!params.get(key)) {
        params.delete(key);
      }
    });

    // Update the URL without reloading
    const newUrl = url.pathname + (params.toString() ? '?' + params.toString() : '');
    window.history.replaceState({}, '', newUrl);
  });
  </script>
@endpush
</x-layout>
