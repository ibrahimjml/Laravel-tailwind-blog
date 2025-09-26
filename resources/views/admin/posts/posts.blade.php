@extends('admin.partials.layout')
@section('title', 'Posts Table | Dashboard')
@section('content')

<div class="md:ml-64 ">
@include('admin.partials.header', [
       'linktext'        => 'Manage Posts', 
       'route'           => 'admin.posts', 
       'value'           => request('search'),
       'searchColor'     => 'bg-blueGray-200',
       'borderColor'     => 'border-blueGray-200',
       'backgroundColor' => 'bg-gray-400'
  ])
  {{-- filters  --}}
<div class="transform -translate-y-52">
  @include('admin.posts.filters')
</div>
 <div class="bg-white shadow rounded-xl overflow-hidden max-w-7xl mx-4 transform -translate-y-40 ">
{{-- post table --}}
<x-tables.table id='' :headers="['#','Username','Image','Title','Body','Hashtags','Categories','Reported','Reports Count','Featured','Likes','Comments','CreatedAt','Actions']" title="Posts Table" >
      @forelse ($posts as $post)
      <tr class="py-4">
        <td class="p-2"> {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
        <td class="p-2">{{$post->user->name}}</td>
        <td class="p-2"><img class="object-contain inline-block" src="{{$post->image_url}}" width="40px" height="40px"
        alt="{{$post->title}}">
        </td>
        <td class="p-2">{{Str::limit($post->slug, 20)}}</td>
        <td class="p-2"> {!! Str::limit(strip_tags($post->description), 40) !!}</td>
        <td class="p-2">
           @if($post->allHashtags->isNotEmpty())
           @foreach($post->allHashtags as $hashtag)
           <span 
             @class([
               "bg-gray-100 text-sm mr-2 px-2 py-1 rounded font-semibold",
               'text-green-600'  => $hashtag->status === \App\Enums\TagStatus::ACTIVE,
               'text-red-600'    => $hashtag->status === \App\Enums\TagStatus::DISABLED, 
             ])>
             {{ $hashtag->name }}
           </span>
         @endforeach
           @else
            <b>--</b>
           @endif
        </td>
        <td class="p-2">
           @if($post->categories->isNotEmpty())
              <span class="bg-blueGray-200 text-sm text-blueGray-500 font-semibold px-2 py-1 rounded">
             {{$post->categories->pluck('name')->implode(' | ')}}
              </span>
           @else
            <b>--</b>
           @endif
        </td>
        <td class="p-2">
          @if($post->is_reported)
          <i class="fas fa-check text-green-500"></i>
          @else
          <i class="fas fa-times text-red-500"></i>
          @endif
        </td>
        <td class="p-2">
          @if($post->report_count > 0)
           {{$post->report_count}}
          @else
          {{$post->report_count}}
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
</x-tables.table>
 <div class="relative ">
    {!! $posts->links() !!}
  </div>
  </div>
</div>
  
@endsection