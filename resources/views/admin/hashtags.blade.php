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
              <form action="{{ route('feature.tag', $hashtag->id) }}" method="POST" onsubmit="return confirm('Toggle featured status?');">
              @csrf
              @method('PUT')
              <button type="submit" class="rounded-lg text-yellow-600 p-2 hover:text-yellow-400 transition-colors duration-100">
                <i class="{{ $hashtag->is_featured ? 'fas' : 'far' }} fa-star"></i>
              </button>
              </form>
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

@push('scripts')
<script>
    const showmenu = document.getElementById('openTagModel');
    const closemenu = document.getElementById('closeModel');
    const menu = document.getElementById("Model");

  if (showmenu && closemenu && menu) {
    showmenu.addEventListener('click', () => {
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
      }
    });

    closemenu.addEventListener('click', () => {
      if (menu.classList.contains('fixed')) {
        menu.classList.add('hidden');
      }
    });
  }


// delete hashtag
const tags = document.querySelectorAll('.tagsdelete');
  tags.forEach(tag => {
    tag.addEventListener('submit', (eo) => {
      eo.preventDefault();
      let options = {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': tag.querySelector('input[name="_token"]').value,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      };
      fetch(tag.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.deleted === true) {
            toastr.success(data.message);
            tag.closest('tr').remove();
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  });
</script>
@endpush
@endsection
    



