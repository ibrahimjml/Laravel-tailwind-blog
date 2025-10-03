<div class="bg-white border border-gray-200 rounded-2xl p-6 mt-6">
  <h3 class="text-xl font-bold text-gray-800 mb-2">Who to Follow</h3>
  <div class="w-20 h-1 bg-red-600 mb-4"></div>
  <div class="flex flex-wrap gap-2">
    @foreach($users as $user)
      <div
        class="rounded-xl flex items-center gap-2 mb-2 mt-4 w-full py-1 px-2 hover:bg-gray-200 transition-bg duration-200 ease-in-out">
        <a href="{{route('profile', $user->username)}}" class="flex items-center gap-3">
          <img src="{{$user->avatar_url}}"
            class="w-8 h-8 overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
          <div class="flex flex-col gap-1">
            <strong>{{ $user->name }}</strong>
            <small>{{'@' . $user->username}}</small>
          </div>
        </a>
        @if(auth()->user()->isNot($user))
          @php
            $isFollowing = in_array($user->id, $authFollowings);
           @endphp
          <button data-id="{{$user->id}}" onclick="follow(this)"
            class="w-5 h-5 text-xs ml-auto text-white {{$isFollowing ? 'bg-green-500' : 'bg-gray-500'}} rounded-full">
            <i class="fas fa-{{$isFollowing ? 'check' : 'plus'}}"></i>
          </button>
        @endif
      </div>
    @endforeach
  </div>
</div>

@push('scripts')
<script>
  async function follow(eo) {
    const icon = eo.querySelector('i');
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
  
      icon.classList.toggle('fa-check', data.attached);
      icon.classList.toggle('fa-plus', !data.attached);
      
      eo.classList.toggle("bg-green-500", data.attached);
      eo.classList.toggle("bg-gray-500", !data.attached);

  
    } catch (error) {
      console.error(error);
    }
  }
</script>
@endpush