@php
  $private = collect();
@endphp

<div class="mt-5 sm:grid grid-cols-4 gap-6 space-y-6 sm:space-y-0">
  @forelse($posts as $post)

    @unless($private->contains($post->user->id))
      <x-private-profile :user="$post->user" :status="$authFollowings[$post->user->id] ?? null">

        <div id="post-{{ $post->id }}" class="flex flex-wrap items-center justify-center ">
          <div class="relative group">
            <a href="{{route('single.post', $post->slug)}}">
              <img src="{{$post->image_url}}" alt="{{$post->title}}"
                class="ml-auto w-80 h-40 mr-auto blur-md bg-gray-200 transition-all duration-700 ease-out group-hover:scale-105 rounded-lg mb-5"
                onload="this.classList.remove('bg-gray-200','blur-md')">
              @if($post->user->isNot(auth()->user()) && $post->is_pinned)
                <span class="absolute top-2 left-2 p-2 w-fit rounded-xl text-white bg-red-500 ">
                  pinned
                </span>
              @endif
            </a>
            @can('update', $post)
              <button title="{{ $post->is_pinned ? 'Unpin' : 'Pin' }}" data-id="{{ $post->id }}"
                class="pin-btn absolute top-1 right-1 p-2 w-8 h-8 {{$post->is_pinned ? 'opacity-100' : 'opacity-0'}} group-hover:opacity-100 transition-opacity duration-200 flex place-content-center rounded-full bg-white ">

                <i class="fas fa-thumbtack transform rotate-45 {{$post->is_pinned ? 'text-red-600' : 'text-gray-400'}} "
                  aria-hidden="true">
                </i>
              </button>
            @endcan
          </div>
        </div>
      </x-private-profile>
      @php $private->push($post->user_id); @endphp
    @endunless
  @empty
    <h1 class=" text-4xl  p-6 font-semibold text-center w-54">No Posts</h1>
  @endforelse
</div>

@push('scripts')
  <script>
    document.querySelectorAll('.pin-btn').forEach(button => {
      button.addEventListener('click', function () {
        const postId = this.dataset.id;
        const icon = this.querySelector('i');

        fetch(`/toggle/${postId}/pin`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'pinned') {
              toastr.success(data.status)
              icon.classList.remove('text-gray-400');
              icon.classList.add('text-red-600');
              this.setAttribute('title', 'Unpin');
              movePostToTop(postId);
            }
            else if (data.status === 'unpinned') {
              toastr.success(data.status)
              icon.classList.remove('text-red-600');
              icon.classList.add('text-gray-400');
              this.setAttribute('title', 'Pin');
              movePostDown(postId);
            }
            else if (data.status === 'limit_reached') {
              toastr.error(data.message);
            }
          });
      });
    });
    function movePostToTop(postId) {
      const postElement = document.querySelector(`#post-${postId}`);
      if (postElement) {
        const container = postElement.parentNode;
        container.insertBefore(postElement, container.firstChild);
      }
    }

    function movePostDown(postId) {
      const postElement = document.querySelector(`#post-${postId}`);
      if (postElement) {
        const container = postElement.parentNode;
        container.appendChild(postElement);
      }
    }
  </script>
@endpush