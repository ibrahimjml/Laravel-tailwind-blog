{{-- button onclick open model --}}
@php
    $target = isset($reply) ? $reply : $comment;
@endphp

<button  class="opencommentmodel-btn absolute top-3 right-3 z-10 w-6 h-6 rounded-[50%] {{ isset($reply) ? 'bg-white' : 'bg-slate-100' }} hover:bg-opacity-65 transition-bg-opacity duration-100">
  <i class="fas fa-ellipsis-v"></i>
</button>
{{-- delete|edit model  --}}
<div  class="commentmodel absolute top-10 right-3 z-10 w-36 h-fit rounded-lg {{ isset($reply) ? 'bg-white' : 'bg-slate-100' }} px-2 py-4 space-y-2 hidden">

  @can('edit',$target)
  <p class="edit-btn block font-semibold w-full rounded-md pl-3 hover:bg-gray-400 hover:text-white transition-all duration-150 cursor-pointer">Edit</p>
  @endcan

  @can('delete',$target)
  @include('comments.partials.delete_form',['comment' => $target])
  @endcan
  @can('report',$target)
  <button onclick="openReport('reportsmodel-{{ $target->id }}')" class="block font-semibold text-left w-full rounded-md pl-3 hover:bg-gray-400 hover:text-white transition-all duration-150 cursor-pointer">Report</button>
  @endcan
  {{-- report model --}}
@include('comments.partials.report-model', ['comment' => $target,'id' => "reportsmodel-{$target->id}"])
</div>