@extends('admin.partials.layout')
@section('title','Tags Page | Dashboard')
@section('content')

<div class="md:ml-64 ">
@include('admin.partials.header', [
        'linktext'     => 'Manage Tags', 
        'route'        => 'admin.users.page',
        'value'         => request('search'),
       'searchColor'      => 'bg-blueGray-200',
       'borderColor'      => 'border-blueGray-200',
       'backgroundColor'  => 'bg-gray-400'
   ])
{{-- sort by status --}}
<div class="flex justify-between transform -translate-y-40 px-4">
  <div class="w-fit">
    @include('admin.hashtags.partials.filter')
  </div>
  @can('tag.create')
  <button id="openTagModel" class="text-center bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">create tag</button>
  @endcan
</div>
 <div class="bg-white shadow rounded-xl overflow-hidden max-w-7xl mx-4 transform -translate-y-40 ">
    <x-tables.table id="tablehashtags" :headers="['#','Hashtag','Related Posts','Status','CreatedAt','UpdatedAt','Actions']" title="Hashtags Table" >
        @forelse ($hashtags as $hashtag)
        <tr>
          <td class="p-2">{{ ($hashtags->currentPage() - 1) * $hashtags->perPage() + $loop->iteration }}</td>
          <td class=" p-2 ">
            <span class=" py-1 px-3 text-blueGray-500  text-sm rounded-md bg-blueGray-200 bg-opacity-70 font-semibold w-fit">

              {{$hashtag->name}}
            </span>
            </td>
          <td class="p-2">  {{$hashtag->allPosts->count()}}</td>
          
          <td>
            <i @class([
                "fas fa-circle  mr-2 text-xs",
                'text-green-600' => $hashtag->status === \App\Enums\TagStatus::ACTIVE,
                'text-red-600' => $hashtag->status === \App\Enums\TagStatus::DISABLED,
          ])></i>
            {{$hashtag->status->value}}
          </td>
          <td class="p-2">{{$hashtag->created_at->diffForHumans()}}</td>
          <td class="p-2">{{$hashtag->updated_at->diffForHumans()}}</td>
          <td  class=" text-white p-2">
            <div class="flex gap-2 justify-start">
            @can('tag.delete')
              <form class="tagsdelete" action='{{route('admin.tags.delete',$hashtag->id)}}' method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
              @can('tag.update')
              <button class="tagsedit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300"
                      data-name="{{ $hashtag->name }}"  
                      data-id="{{ $hashtag->id }}"
                      data-status="{{ $hashtag->status->value }}"
                      >
               <i class="fas fa-edit"></i>
              </button>
              @endcan
              @can('tag.feature')
              <form action="{{ route('admin.tags.feature', $hashtag->id) }}" method="POST" onsubmit="return confirm('Toggle featured status?');">
              @csrf
              @method('PUT')
              <button type="submit" class="rounded-lg text-yellow-600 p-2 hover:text-yellow-400 transition-colors duration-100">
                <i class="{{ $hashtag->is_featured ? 'fas' : 'far' }} fa-star"></i>
              </button>
              </form>
              @endcan
            </div>
          
          </td>
        </tr>
        @empty
          <h4 class="text-center font-bold">Sorry, column not found</h4>
        @endforelse
      </x-tables.table>
        <div class="relative">
        {!! $hashtags->links() !!}
       </div>
    </div>
</div>
  {{-- edit tag model --}}
  @include('admin.hashtags.partials.edit-tag-model')
{{-- tag model --}}
@include('admin.hashtags.partials.create-tag-model')

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
    



