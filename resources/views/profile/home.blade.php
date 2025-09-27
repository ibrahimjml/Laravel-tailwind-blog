<div class="mt-5 sm:grid grid-cols-4 gap-6 space-y-6 sm:space-y-0">
  @forelse($posts as $post)
  <div class="flex flex-wrap items-center justify-center ">
    <div class="relative">
    <a  href="{{route('single.post', $post->slug)}}">
        <img src="{{$post->image_url}}" alt="{{$post->title}}" class="ml-auto w-80 h-40 mr-auto  rounded-lg mb-5">
      </a>
      @can('update', $post)
      <form  action="{{route('toggle.pin',$post->id)}}" method="POST">
        @csrf
        @method('POST')
        <button type="submit" class="absolute top-1 right-1 p-2 w-8 h-8 flex place-content-center rounded-full bg-white ">
          <i class="fas fa-thumbtack {{$post->is_pinned ? 'text-red-600' : 'text-gray-400'}} " aria-hidden="true">
            </i>
          </button>
      </form>
      @endcan
    </div>
  </div>
  @empty
  <h1 class=" text-4xl  p-6 font-semibold text-center w-54">No Posts</h1>
  @endforelse
</div>