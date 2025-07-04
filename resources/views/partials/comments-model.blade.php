<div id="bgmodel" class="fixed hidden inset-0 z-50 opacity-0 transition-opacity duration-300 ease-in-out">
  
  <div class="absolute inset-0 bg-gray-900 opacity-60"></div>

  <div id="commentModel" class="relative h-[100vh] w-screen md:w-[50%] bg-white overflow-y-auto shadow-xl translate-x-[-110vw] transition-all duration-300 ease-in-out">
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

@push('scripts')
@if($post->allow_comments)
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const opencommentModel = document.getElementById('openModel');
    const closeModel = document.getElementById('closeModel');
    const commentModel = document.getElementById('commentModel');
    const bgmodel = document.getElementById('bgmodel');
  
    opencommentModel.addEventListener('click', () => {
      document.body.classList.add('no-scroll');
  
      bgmodel.classList.remove('hidden');
      setTimeout(() => {
        bgmodel.classList.add('opacity-100');
        bgmodel.classList.remove('opacity-0');

        commentModel.classList.remove('translate-x-[-110vw]');
      commentModel.classList.add('translate-x-[0]');
      }, 10); 
  

      
    });
  
    closeModel.addEventListener('click', () => {
      document.body.classList.remove('no-scroll');
  
      bgmodel.classList.remove('opacity-100');
      bgmodel.classList.add('opacity-0');
  
      commentModel.classList.remove('translate-x-[0]');
      commentModel.classList.add('translate-x-[-110vw]');
  

      setTimeout(() => {
        bgmodel.classList.add('hidden');
      }, 300); 
    });
  });
  </script>
@endif
{{-- trigger and Scroll to comment/reply if anchor is present in user activities --}}
<script>

window.addEventListener('open-comment-modal', function () {
  const bgmodel = document.getElementById('bgmodel');
  const commentModel = document.getElementById('commentModel');

  if (bgmodel && commentModel) {
    document.body.classList.add('no-scroll');

    bgmodel.classList.remove('hidden');
    setTimeout(() => {
      bgmodel.classList.add('opacity-100');
      bgmodel.classList.remove('opacity-0');

      commentModel.classList.remove('translate-x-[-110vw]');
      commentModel.classList.add('translate-x-[0]');

      const hash = window.location.hash;
      setTimeout(()=>{
       if (hash) {
        const target = document.querySelector(hash);
        if (target) {
        
          let parent = target.parentElement;
           while (parent) {
            if ((parent.classList.contains('reply-content') || parent.classList.contains('nested-replies')) 
                && parent.classList.contains('hidden')) {
              parent.classList.remove('hidden');
            }
            parent = parent.parentElement;
          }
          
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          target.classList.add('highlight');
          setTimeout(() => target.classList.remove('highlight'), 2000);
        }
      }
      },500)
    
    }, 10);
  }
});


</script>
<script>

document.addEventListener('DOMContentLoaded', () => {

  if (sessionStorage.getItem('showCommentModal') === 'true') {
    window.dispatchEvent(new CustomEvent('open-comment-modal'));
    sessionStorage.removeItem('showCommentModal'); 
  }
});

</script>
@endpush