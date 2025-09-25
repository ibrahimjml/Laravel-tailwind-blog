@extends('admin.partials.layout')
@section('title', 'Comment Reports | Dashboard')
@section('content')

@include('admin.partials.header', [
  'linktext' => 'Comment Reports',
   'route' => 'admin.posts', 
   'value' => request('search'),
    'searchColor'     => 'bg-blueGray-200',
       'borderColor'     => 'border-blueGray-200',
       'backgroundColor' => 'bg-gray-400'
   ])

{{-- sort by status --}}
<div class=" md:ml-64  px-4 py-2 mb-3 -m-24 w-[80%]">
@include('admin.reports.partials.filter')
</div>
<div class="relative md:ml-60 rounded-md bg-white shadow w-[80%] left-6 overflow-hidden">
<x-tables.table id="tablecommentreports" :headers="['#','Post','Comment','Commenter','Reporter','Reason','Other','Status','CreatedAt','Actions']" title="Comment Reports Table">
    @forelse ($reports as $report)
        <tr>
      <td>{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
      <td>
        <div class="flex items-center gap-2">
        <img class="object-contain inline-block" src="/storage/uploads/{{$report->comment->post->image_path}}" width="40px" height="40px"
      alt="{{$report->comment->post->title}}">
      <span class="px-2">
          {{$report->comment->post->title}}
        </span>
        </div>
      </td>
      <td>
        <span class="px-2">
          {{$report->comment->content}}
        </span>
      </td>
      <td>
        <span class="px-2">
          {{$report->comment->user->name}}
        </span>
      </td>
      <td>
        <span class="px-2 py-2">
          {!!$report->reporter->name.'<b class="text-blue-400">'.' @'.$report->reporter->username.'</b>'!!} 
        </span>
      </td>
      <td>{{$report->reason->value}}</td>
      <td>
        @if(isset($report->other))
        {{$report->other}}
        @else
        <b>--</b>
        @endif
      </td>
      <td>
          <i @class([
            "fas fa-circle  mr-2 text-xs",
            'text-orange-400' => $report->status === \App\Enums\ReportStatus::Pending,
            'text-green-600' => $report->status === \App\Enums\ReportStatus::Reviewed,
            'text-red-600' => $report->status === \App\Enums\ReportStatus::Rejected,
          ])></i>  {{$report->status->label()}}
      </td>
      <td>{{$report->created_at->format('y/m/j')}}</td>
      <td>
        <div class="flex items-center justify-start gap-2">
      @can('commentreport.delete')
          <form action='{{route('delete.comment.report',$report->id)}}' method="POST"
         onsubmit="return confirm('Are you sure you want to delete this report?');">
         @csrf
         @method('delete')
         <button type="submit"
         class="rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100">
         <i class="fas fa-trash"></i></button>
       </form>
        @endcan
       <a href=""><i class="fas fa-eye "></i></a>
        {{-- action report status menu --}}
        @can('commentreport.status')
        <div class="relative inline-block">
        <button  class="toggle-menu w-6 h-6 rounded-[50%] bg-slate-50 hover:bg-opacity-65 transition-bg-opacity duration-100">
         <i class="fas fa-ellipsis-v"></i>
        </button>
        @include('admin.reports.partials.action-report-status-menu',['type'=>'comment','report'=>$report])
        </div>
        @endcan
      </div>
      </td>
     </tr>
    @empty
        <h4 class="text-center font-bold">No Reports yet</h4>
    @endforelse
     
</x-tables.table>
</div>

  <div class="relative md:ml-64 md:w-[80%] md:left-4">
    {!! $reports->links() !!}
  </div>
@endsection