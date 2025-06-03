<div id="view-liked" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">

  <div class="relative bg-white h-2/4 rounded-lg p-6 w-full max-w-2xl  overflow-y-auto">
    <p class="text-2xl font-bold">People who liked</p>
    @forelse($viewwholiked as $viewliked)
    <div class="rounded-xl flex items-center gap-2 mb-2 mt-4 w-full py-1 px-2 hover:bg-gray-200 transition-bg duration-200 ease-in-out">
    <a href="{{route('profile',$viewliked->user->username)}}" class="flex items-center gap-3">
      <img src="{{$viewliked->user->avatar_url}}"  class="w-8 h-8 overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full ">
        <div class="flex flex-col gap-1">
          <strong>{{ $viewliked->user->name }}</strong>
          <small>{{'@'.$viewliked->user->username}}</small>
        </div>
      </a> 
      @if(auth()->user()->id !== $viewliked->user->id)
      <button data-id="{{$viewliked->user->id}}" onclick="follow(this)" class="w-5 h-5 text-xs ml-auto text-white {{auth()->user()->isFollowing($viewliked->user) ? 'bg-green-500' : 'bg-gray-500'}} rounded-full">
        <i class="fas fa-{{auth()->user()->isFollowing($viewliked->user) ? 'check' : 'plus'}}"></i>
      </button>
      @endif
    </div>
    @empty
    <p class="text-lg text-center p-20 font-bold">No people who liked yet</p>
    @endforelse
    <button id="close-modal" class="absolute top-1 right-3 text-lg mt-4 text-black"><i class="fas fa-times"></i></button>
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