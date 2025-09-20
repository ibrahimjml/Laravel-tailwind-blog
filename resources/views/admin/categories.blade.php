@extends('admin.partials.layout')
@section('title','Categories Page | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Categories Table', 'route' => 'admin.users', 'value' => request('search')])
<div class="w-[90%] -m-24 mx-auto">

@can('category.create')
<div class="flex justify-end">
  <button id="openCatModel" class="text-center ml-0 mr-2 sm:ml-auto w-48 bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">create category</button>
</div>
@endcan
  <div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow">
      <table id="tablecats" class="min-w-full table-auto">
      
        <tr class="bg-gray-600">         
          <th class="text-white p-2">#</th>
          <th class="text-white p-2 text-left w-fit">Categories</th>
          <th class="text-white p-2">Related posts</th>
          <th class="text-white p-2">CreatedAt</th>
          <th class="text-white p-2">UpdatedAt</th>
          <th colspan="2" class="text-white  p-2">Actions</th>
  
        </tr>
        @forelse ($categories as $category)
        <tr class="text-center border border-b-gray-300 last:border-none">
          <td class="p-2">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
          <td class=" p-2 flex justify-start items-center">
            <span class=" py-1 px-3 text-white  text-sm rounded-md bg-gray-700 bg-opacity-70 font-semibold w-fit">

              {{$category->name}}
            </td>
            </span>
          <td class="p-2">  {{$category->posts->count()}}</td>
          
          <td class="p-2">{{$category->created_at->diffForHumans()}}</td>
          <td class="p-2">{{$category->updated_at->diffForHumans()}}</td>
          <td  class=" text-white p-2">
            <div class="flex gap-2 justify-center">
            @can('category.delete')
              <form class="catsdelete" action='{{route('delete.category',$category->id)}}' method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
              @can('category.update')
              <button class="catsedit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300"
                      data-name="{{ $category->name }}"  
                      data-id="{{ $category->id }}">
              <i class="fas fa-edit"></i>
              </button>
            @endcan
            <form action="{{ route('feature.category', $category->id) }}" method="POST" onsubmit="return confirm('Toggle featured status?');">
            @csrf
            @method('PUT')
            <button type="submit" class="rounded-lg text-yellow-600 p-2 hover:text-yellow-400 transition-colors duration-100">
              <i class="{{ $category->is_featured ? 'fas' : 'far' }} fa-star"></i>
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
  {!! $categories->links() !!}
    </div>
    </div>
{{-- create category model --}}
@include('admin.partials.create-category-model')
{{-- edit category model --}}
@include('admin.partials.edit-category-model')
@push('scripts')
<script>
    const showmenu = document.getElementById('openCatModel');
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
// delete category
const categories = document.querySelectorAll('.catsdelete');
  categories.forEach(cat => {
    cat.addEventListener('submit', (eo) => {
      eo.preventDefault();
      let options = {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': cat.querySelector('input[name="_token"]').value,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      };
      fetch(cat.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.deleted === true) {
            toastr.success(data.message);
            cat.closest('tr').remove();
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