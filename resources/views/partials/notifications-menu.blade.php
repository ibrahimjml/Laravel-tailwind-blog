<ul id="hidden-notification" style="display: none" class="w-[320px] bg-white shadow-xl rounded-xl px-4 py-3 max-h-[300px] overflow-y-auto space-y-3">

    <form action="{{ route('notifications.deleteAll') }}" method="POST" class="text-right mb-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm text-red-600 hover:underline">Delete All</button>
    </form>

    @forelse (auth()->user()->notifications as $notification)
        {{-- Follow Notification --}}
        @if ($notification->data['type'] === 'follow')
            <li class="flex items-start gap-3 p-2 rounded-md hover:bg-gray-100 transition">
                <img src="{{ $notification->data['follower_avatar_url'] }}"
                     class="w-8 h-8 rounded-full object-cover" alt="follower avatar">
                <div class="flex-1">
                    <a href="{{ route('notifications.read', $notification->id) }}"
                       class="text-sm text-gray-700 hover:text-black font-medium block">
                        {{ $notification->data['message'] }}
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

        {{-- Like Notification --}}
        @elseif($notification->data['type'] === 'like')
            <li class="flex items-start gap-3 p-2 rounded-md hover:bg-gray-100 transition">
                <a href="{{ route('profile', $notification->data['user_username']) }}">
                    <img src="{{ $notification->data['user_avatar'] }}"
                         class="w-9 h-9 rounded-full object-cover" alt="user avatar">
                </a>
                <div class="flex-1">
                    <a href="{{ route('notifications.read', $notification->id) }}"
                       class="text-sm text-gray-700 hover:text-black font-medium block">
                        {{ $notification->data['message'] }}
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
        @endif
    @empty
        <li class="text-center text-gray-500 py-6">No new notifications.</li>
    @endforelse
</ul>
