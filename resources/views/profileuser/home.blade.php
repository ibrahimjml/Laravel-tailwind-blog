<div class="mt-5 sm:grid grid-cols-4 gap-6 space-y-6 sm:space-y-0">
  @forelse($posts as $post)
  <div class="flex flex-wrap items-center justify-center ">
    <a  href="/post/{{$post->slug}}">
      <img src="/images/{{$post->image_path}}" alt="" class="ml-auto mr-auto w-[80%] rounded-lg mb-5">
    </a>
    
  </div>
  @empty
  <h1 class=" text-4xl  p-6 font-semibold text-center w-54">No Posts</h1>
  @endforelse
</div>