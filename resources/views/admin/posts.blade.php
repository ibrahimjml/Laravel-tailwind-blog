@extends('admin.partials.layout')
@section('title', 'Posts Table | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Posts Table', 'route' => 'admin.posts', 'value' => request('search')])
  <div class=" md:ml-64  px-4 py-2 mb-3 -m-24 w-[80%]">
    <div class="flex items-center flex-wrap gap-4 ml-3">

    <!-- Sort & Featured -->
    <div class="flex gap-2 items-center">
      <!-- Sort Form -->
      <form action="{{ route('admin.posts') }}" method="GET">
      <div class="relative w-full">
        <select id="sort" name="sort"
        class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-gray-600 text-white border-0 text-sm rounded-lg p-2.5"
        onchange="this.form.submit()" onchange="this.form.submit()">
        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
        </select>
        <!-- Custom white arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M19 9l-7 7-7-7" />
        </svg>
        </div>
      </div>
      </form>

      <!-- Featured Checkbox -->
      <div class="bg-gray-600 rounded-md p-2 h-10 flex items-center">
      <form action="{{ route('admin.posts') }}" method="GET" class="flex items-center gap-1">
        <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }}
        onchange="this.form.submit()" class="rounded-full w-4 h-4">
        <label class="text-white font-semibold" for="featured">Featured</label>
      </form>
      </div>
    </div>

    </div>
  </div>

<div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow w-[80%] left-6">
    <table class="min-w-full table-auto ">

    <tr class="bg-gray-600">
      <th class="text-white p-2">#</th>
      <th class="text-white p-2">Username</th>
      <th class="text-white p-2">Image</th>
      <th class="text-white p-2">Title</th>
      <th class="text-white p-2">Body</th>
      <th class="text-white p-2">IsReported</th>
      <th class="text-white p-2">Hashtags</th>
      <th class="text-white p-2">Featured</th>
      <th class="text-white p-2">Likes</th>
      <th class="text-white p-2">Comments</th>
      <th class="text-white p-2">CreatedAt</th>
      <th colspan="2" class="text-white  p-2">Actions</th>

    </tr>
    @forelse ($posts as $post)
    <tr class="text-center border border-b-gray-300 ">
      <td class="p-2"> {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
      <td class="p-2">{{$post->user->name}}</td>
      <td class="p-2">
      <img class="object-contain inline-block" src="/storage/uploads/{{$post->image_path}}" width="40px" height="40px"
      alt="{{$post->title}}">
      </td>
      <td class="p-2">{{Str::limit($post->slug, 20)}}</td>
      <td class="p-2"> {!! Str::limit(strip_tags($post->description), 40) !!}</td>
      <td class="p-2">
        @if($post->reports_count >0)
        {{$post->reports_count}}
        @else
        <i class="fas fa-times text-red-500"></i>
        @endif
      </td>
      <td class="p-2">
      @if($post->hashtags->isNotEmpty())
      {{$post->hashtags->pluck('name')->implode(', ')}}
    @else
      <i class="fas fa-times text-red-600 "></i>
    @endif
      </td>
      <td class="p-2">
      <div class="flex justify-center">
      @if($post->is_featured)
      <i class="fas fa-check text-green-500"></i>
      @else
      <i class="fas fa-times text-red-600"></i>
      @endif
      </div>
      </td>
      <td class="p-2">{{$post->likes_count}}</td>
      <td class="p-2">{{$post->totalcomments_count}}</td>
      <td class="p-2">{{$post->created_at->diffForHumans()}}</td>
      <td class=" text-white p-2 ">
      <div class="flex items-center justify-center">
      @can('delete', $post)
      <form action='/post/{{$post->slug}}' method="POST"
      onsubmit="return confirm('Are you sure you want to delete this post?');">
      @csrf
      @method('delete')
      <button type="submit"
      class="rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100"><i
      class="fas fa-trash"></i></button>
      </form>
      @endcan
      <a class=" rounded-lg text-gray-700 p-2  hover:text-gray-400 transition-colors duration-100"
      href="/post/{{$post->slug}}"><i class="fas fa-eye"></i></a>
    @can('make_feature', $post)
     <form action="{{ route('toggle.feature', $post->id) }}" method="POST" onsubmit="return confirm('Toggle featured status?');">
      @csrf
      @method('PUT')
      <button type="submit" class="rounded-lg text-yellow-600 p-2 hover:text-yellow-400 transition-colors duration-100">
        <i class="{{ $post->is_featured ? 'fas' : 'far' }} fa-star"></i>
      </button>
      </form>
     @endcan
      </div>
      </td>
    </tr>
    @empty

    <h4 class="text-center font-bold">Sorry, column not found</h4>

    @endforelse
    </table>
  </div>


  <div class="relative md:ml-64 md:w-[80%] md:left-4">
    {!! $posts->links() !!}
  </div>
@endsection