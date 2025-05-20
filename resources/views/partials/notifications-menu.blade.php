<ul id="hidden-notification" style="display: none" class="w-[390px] bg-white shadow-xl rounded-xl px-4 py-3 max-h-[500px] overflow-y-auto space-y-3">

    <form action="{{ route('notifications.deleteAll') }}" method="POST" class="text-right mb-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm text-red-600 hover:underline">Delete All</button>
    </form>

    @forelse ($notifications as $notification)
    <li class="flex items-start gap-3 p-2 rounded-md hover:bg-gray-100 transition">
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
        $user =  $users[$username] ?? null;;
        $avatar = $user?->avatar_url ?? asset('storage/avatars/default.jpg');
     @endphp
            <a href="{{ route('profile', $username) }}">
                <img src="{{$avatar}}?v={{ $user?->updated_at->timestamp ?? time() }}"
                     class="w-8 h-8 rounded-full object-cover" alt="">
                    </a>
                <div class="flex-1">
                    <a href="{{$url}}"
                       class="text-sm text-gray-700 hover:text-black font-medium block">
                        {{$message}}
                    </a>
                    <div class="flex justify-center items-center gap-4">
                      <small class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</small>
                      
                        <form action="{{ route('notifications.delete',$notification->id) }}" method="POST" class="text-right mb-2">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-sm text-white hover:underline px-2 rounded-full bg-red-500">x</button>
                      </form>
                    </div>
                </div>
            </li>
    @empty
        <li class="text-center text-gray-500 py-6">No new notifications.</li>
    @endforelse
</ul>
