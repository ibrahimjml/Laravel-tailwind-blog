@php
    $canReport = auth()->user()->can('report', $post);
    $canFollow = auth()->user()->isNot($post->user);
@endphp
<div id="moremodel"
  @class([
    'absolute -right-12 z-10 w-36 h-fit rounded-lg bg-slate-50 px-2 py-4 space-y-2 hidden',
    'top-[-110px]' => $canReport && $canFollow,
    'top-[-70px]' =>  !$canFollow || !$canReport,
  ])>
    @if($canFollow)
    <button 
    data-id="{{$post->user->id}}" onclick="follows(this)"
    class="block text-left text-sm {{in_array($post->user->id, $authFollowings) ? 'text-red-500':'text-blue-500'}} font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200  transition-all duration-150">
    {{in_array($post->user->id, $authFollowings) ? 'unfollow' :'follow'}}
    </button>
    @endif
    @if($canReport)
    <button onclick="openReort()" class="block text-left text-sm font-semibold w-full rounded-md pl-3 hover:bg-gray-200  transition-all duration-150">Report</button>
    @endif
  </div>
  
  @push('scripts')
      {{-- open more menu --}}
  <script>
  const OpenMoreModel = document.getElementById('openmoremodel');
  const moreModel = document.getElementById('moremodel');
  OpenMoreModel.addEventListener('click',()=>{
    if(moreModel.classList.contains('hidden')){
      moreModel.classList.remove('hidden');
    }else{
      moreModel.classList.add('hidden');
    }
  })
</script>
  @endpush