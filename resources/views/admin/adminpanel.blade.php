<x-layout>
<main class="admin w-screen   grid grid-cols-[25%,75%] transition-all ease-in-out duration-300 p-5">
<x-admin-sidebar/>
  <section id="main-section" class="p-5 transition-all ease-in-out duration-300 ">
  
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
  <p class="text-xl font-bold text-gray-700 border-b-2 border-gray-600 w-full mb-4">All Notifications</p>

  @foreach ($notifications as $notification)
      <div class="flex items-start gap-2 p-3 rounded-md hover:bg-gray-100 transition w-full">
    
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

       $user = \App\Models\User::where('username', $username)->first();
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
@endforeach
</div>
  </section>
</main>
</x-layout>
