@php
    $canReport = auth()->user()->can('report', $post);
    $canFollow = !auth()->user()->is($post->user);
@endphp
<div id="moremodel"
  @class([
    'absolute right-3 z-10 w-36 h-fit rounded-lg bg-slate-50 px-2 py-4 space-y-2 hidden',
    'top-[-110px]' => $canReport && $canFollow,
    'top-[-60px]' =>  $canFollow,
  ])>
    @if($canFollow)
    <button 
    data-id="{{$post->user->id}}" onclick="follows(this)"
    class="block text-left text-sm {{in_array($post->user->id, $authFollowings) ? 'text-red-500':'text-blue-500'}} font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200  transition-all duration-150">{{in_array($post->user->id, $authFollowings) ? 'unfollow' :'follow'}}</button>
    @endif
    @if($canReport)
    <button onclick="openReort()" class="block text-left text-sm font-semibold w-full rounded-md pl-3 hover:bg-gray-200  transition-all duration-150">Report</button>
    @endif
  </div>