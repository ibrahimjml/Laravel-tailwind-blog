@extends('admin.partials.layout')
@section('title', 'Posts Reports | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Post Reports', 'route' => 'admin.posts', 'value' => request('search')])


<div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow w-[80%] left-6 -m-24">
    <table class="min-w-full table-auto ">

    <tr class="bg-gray-600">
      <th class="text-white p-2">#</th>
      <th class="text-white p-2">Post</th>
      <th class="text-white p-2">Author</th>
      <th class="text-white p-2">Reported By</th>
      <th class="text-white p-2">Reason</th>
      <th class="text-white p-2">Other</th>
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
        <span class="px-2 font-semibold text-white rounded-lg bg-green-400">
          {{$report->post->user->name}}
        </span>
      </td>
      <td>
        <span class="px-2 py-2 font-semibold text-white rounded-lg bg-yellow-400">
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
      <td>{{$report->created_at->format('y/m/j')}}</td>
      <td>
        <div class="flex items-center justify-center gap-2">
        <form action='{{route('delete.report',$report->id)}}' method="POST"
      onsubmit="return confirm('Are you sure you want to delete this report?');">
      @csrf
      @method('delete')
      <button type="submit"
      class="rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100">
      <i class="fas fa-trash"></i></button>
      </form>
          <a href="{{route('single.post',$report->post->slug)}}"><i class="fas fa-eye "></i></a>
        </div>
      </td>
     </tr>
    @empty
        <h4 class="text-center font-bold">No Reports yet</h4>
    @endforelse
     
    </table>
  </div>


  <div class="relative md:ml-64 md:w-[80%] md:left-4">
    {!! $reports->links() !!}
  </div>
@endsection