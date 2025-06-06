@extends('admin.partials.layout')
@section('title','Tags Page | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Tags Table', 'route' => 'admin.users', 'value' => request('search')])
<div class="w-[90%] -m-24 mx-auto">

@can('tag.create')
<div class="flex justify-end">
  <button id="openTagModel" class="text-center ml-0 mr-2 sm:ml-auto w-36   bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6" href="{{route('create')}}">create tag</button>
</div>
@endcan
  <div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow">
      <table id="tabletags" class="min-w-full table-auto">
      
        <tr class="bg-gray-600">         
          <th class="text-white p-2">#</th>
          <th class="text-white p-2 text-left w-fit">Hashtags</th>
          <th class="text-white p-2">Related posts</th>
          <th class="text-white p-2">CreatedAt</th>
          <th colspan="2" class="text-white  p-2">Actions</th>
  
        </tr>
        @forelse ($hashtags as $hashtag)
        <tr class="text-center border border-b-gray-300 last:border-none">
          <td class="p-2">{{ ($hashtags->currentPage() - 1) * $hashtags->perPage() + $loop->iteration }}</td>
          <td class=" p-2 flex justify-start items-center">
            <span class=" py-1 px-3 text-white  text-sm rounded-md bg-gray-700 bg-opacity-70 font-semibold w-fit">

              {{$hashtag->name}}</td>
            </span>
          <td class="p-2">  {{$hashtag->posts->count()}}</td>
          
          <td class="p-2">{{$hashtag->created_at->diffForHumans()}}</td>
          <td  class=" text-white p-2">
            <div class="flex gap-2 justify-center">
            @can('tag.delete')
              <form class="tagsdelete" action='{{route('delete.hashtag',$hashtag->id)}}' method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
              @can('tag.update')
              <button class="tagsedit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300" data-name="{{ $hashtag->name }}"  data-id="{{ $hashtag->id }}"><i class="fas fa-edit"></i></button>
            @endcan
            </div>
          
          </td>
        </tr>
        @empty
      
          <h4 class="text-center font-bold">Sorry, column not found</h4>
      
        @endforelse
      </table>
    </div>

  
    <div class="relative md:ml-64 ">
  {!! $hashtags->links() !!}
    </div>
    </div>
  {{-- edit tag model --}}
  @include('admin.partials.edit-tag-model',['hashtag'=>$hashtag])
{{-- tag model --}}
@include('admin.partials.create-tag-model')
@endsection
    



