@extends('admin.partials.layout')
@section('title', 'Posts Reports | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Post Reports', 'route' => 'admin.posts', 'value' => request('search')])
<div class="lg:w-[80%] w-full lg:ml-[280px] ml-0 left-6 space-y-4 -mt-24">
  {{-- sort by status --}}
    @php
      $statuses = collect(\App\Enums\ReportStatus::cases());
    @endphp
     <form action="{{ url()->current() }}" method="GET">
      <div class=" w-full z-30">
        <label for="sort" class="text-lg text-white font-bold">status :</label>
        <select id="sort" name="sort"
        class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-gray-600 text-white border-0 text-sm rounded-lg p-2"
        onchange="this.form.submit()" onchange="this.form.submit()">
        <option value="" {{ request('sort') === null ? 'selected' : '' }}>All</option>
        @foreach ($statuses as $status )
        <option value="{{$status->value}}" {{ request('sort') === $status->value ? 'selected' : '' }}>{{$status->value}}</option>
        @endforeach
        </select>
        <!-- Custom white arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" />
          </svg>
          </div>
      </div>
      </form>
<div class="rounded-xl overflow-hidden bg-white shadow">

  <table class="min-w-full table-auto ">

    <tr class="bg-gray-600">
      <th class="text-white p-2">#</th>
      <th class="text-white p-2">Post</th>
      <th class="text-white p-2">Post Author</th>
      <th class="text-white p-2">Reported By</th>
      <th class="text-white p-2">Reason</th>
      <th class="text-white p-2">Other</th>
      <th class="text-white p-2">Status</th>
      <th class="text-white p-2">CreatedAt</th>
      <th colspan="2" class="text-white  p-2">Actions</th>
    </tr>
    @forelse ($reports as $report)
        <tr class="text-center border border-b-gray-300 p-4">
      <td>{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
      <td>
        <div class="flex items-center gap-2">
        <img class="object-contain inline-block" src="/storage/uploads/{{$report->post->image_path}}" width="40px" height="40px"
      alt="{{$report->post->title}}">
      <span>{{$report->post->title}}</span>
        </div>
      </td>
      <td>
        <span class="px-2">
          {{$report->post->user->name}}
        </span>
      </td>
      <td>
        <span class="px-2 py-2">
          {{$report->user->name}} 
        </span>
      </td>
      <td>{{$report->reason_label}}</td>
      <td>
        @if(isset($report->other))
        {{$report->other}}
        @else
        <b>--</b>
        @endif
      </td>
      <td>
        <span @class([
          'rounded-lg font-bold p-1 text-sm text-white',
          'bg-yellow-500' => $report->status === \App\Enums\ReportStatus::Pending,
          'bg-green-600' => $report->status === \App\Enums\ReportStatus::Reviewed,
          'bg-red-600' => $report->status === \App\Enums\ReportStatus::Rejected,
           ])>
          {{$report->status->label()}}
        </span>
      </td>
      <td>{{$report->created_at->format('y/m/j')}}</td>
      <td>
        <div class="flex items-center justify-center gap-2">
      @can('postreport.delete')
          <form action='{{route('delete.report',$report->id)}}' method="POST"
         onsubmit="return confirm('Are you sure you want to delete this report?');">
         @csrf
         @method('delete')
         <button type="submit"
         class="rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100">
         <i class="fas fa-trash"></i></button>
       </form>
        @endcan
       <a href="{{route('single.post',$report->post->slug)}}"><i class="fas fa-eye "></i></a>
        {{-- action report status menu --}}
        @can('postreport.status')
        <div class="relative inline-block">
        <button  class="toggle-menu w-6 h-6 rounded-[50%] bg-slate-50 hover:bg-opacity-65 transition-bg-opacity duration-100">
         <i class="fas fa-ellipsis-v"></i>
        </button>
        @include('admin.partials.action-report-status-menu',['type'=>'post','report'=>$report])
        </div>
        @endcan
      </div>
      </td>
     </tr>
    @empty
        <h4 class="text-center font-bold">No Reports yet</h4>
    @endforelse
     
    </table>
  </div>
</div>

  <div class="relative md:ml-64 md:w-[80%] md:left-4">
    {!! $reports->links() !!}
  </div>
@endsection