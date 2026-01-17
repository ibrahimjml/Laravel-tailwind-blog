@php
    $canReport = auth()->user()->can('report', $post);
    $canFollow = auth()->user()->isNot($post->user);
       $followStatus = $authFollowings[$post->user_id] ?? null;
           $status = isset($followStatus)
                   ? \App\Enums\FollowerStatus::tryFrom((int) $followStatus)
                   : null;
@endphp
<div id="moremodel" class="absolute top-[-100px] -right-12 z-10 w-36 h-fit rounded-lg bg-slate-50 px-2 py-4 space-y-2 hidden">
    @if($canFollow)
     <button
        data-id="{{ $post->user->id }}"
        onclick="follows(this)"
        class="block text-left text-sm font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200 transition-all duration-150
            {{ is_null($status) ? 'text-blue-500' : ($status === \App\Enums\FollowerStatus::PENDING ? 'text-yellow-500' : 'text-red-500') }}">
        {{ is_null($status) ? 'Follow' : ($status === \App\Enums\FollowerStatus::PENDING ? 'Requested' : 'Unfollow') }}
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