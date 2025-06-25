{{-- button onclick open model --}}
<button id="openmodel" class="absolute top-3 right-3 z-10 w-6 h-6 rounded-[50%] bg-slate-100 hover:bg-opacity-65 transition-bg-opacity duration-100">
  <i class="fas fa-ellipsis-h"></i>
</button>
{{-- delete|edit model  --}}
<div id="model" class="absolute top-10 right-3 z-10 w-36 h-20 rounded-lg bg-slate-50 px-2 py-4 space-y-2 hidden">
  @can('view',$post)
   <a href="{{route('edit.post',$post->slug)}}" class="block font-semibold w-full rounded-md pl-3 hover:bg-gray-400 hover:text-white transition-all duration-150">Edit</a>
   @endcan
   @can('delete',$post)
   <form action="{{route('delete.post',$post->slug)}}" method="POST" onsubmit="return confirm('Are you sure you want delete this post ?')">
    @csrf
    @method('DELETE')
   <button  class="text-left font-semibold w-full rounded-md pl-3 hover:bg-gray-400 hover:text-white transition-all duration-150">Delete</button>
   </form>
   @endcan
</div>
@push('scripts')
    @can('view',$post)
<script>
  const OpenModel = document.getElementById('openmodel');
  const Model = document.getElementById('model');
  OpenModel.addEventListener('click',()=>{
    if(Model.classList.contains('hidden')){
      Model.classList.remove('hidden');
    }else{
      Model.classList.add('hidden');
    }
  })
</script>
@endcan
@endpush