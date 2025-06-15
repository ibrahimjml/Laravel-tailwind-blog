<div id="bgmodel" class="fixed hidden inset-0 z-50 opacity-0 transition-opacity duration-300 ease-in-out">
  
  <div class="absolute inset-0 bg-gray-900 opacity-60"></div>

  <div id="commentModel" class="relative h-full w-screen md:w-[50%] bg-white overflow-y-auto shadow-xl translate-x-[-110vw] transition-all duration-300 ease-in-out">
  <span id="closeModel" title="close" class="cursor-pointer absolute top-4 right-4 text-xl"><i class="fas fa-times"></i></span>
    {{-- Comment Form --}}
    <p class="w-fit md:text-xl text-md mb-3 p-2 font-semibold">
      Comments (<span id="comment-count-number">{{ $totalcomments }}</span>)
    </p>
    <div class="w-fit mb-4 border-2 p-1 rounded-lg px-5 mx-auto">
      @include('comments.partials.comment_form', ['post' => $post])
    </div>

       {{-- display comments | replies UI --}}
    @include('comments.comments',['comments'=>$post->comments])
  </div>
</div>