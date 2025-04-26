<x-layout>
  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)
  @section('author',$author)
  @section('meta_description',$meta_description)


{{-- posts --}}

@if($posts->count() == 0)

  <h1 class=" text-4xl p-36 font-semibold text-center w-54">No Posts Yet</h1>

@else
<h1 class=" text-4xl  p-5 font-semibold text-center text-gray-500 w-54">Showing recent posts with # <span class="text-black">{{$hashtag->name}}</span></h1>
@foreach ($posts as $post)
    
<x-postcard :post="$post" :authFollowings="$authFollowings"/>

@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
</x-layout>