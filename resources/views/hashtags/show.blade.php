<x-layout>
  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)
  @section('meta_description',$meta_description)


{{-- posts --}}

@if($posts->count() == 0)

  <h1 class=" text-4xl p-36 font-semibold text-center w-54">No Posts Yet</h1>

@else
<div class="w-full p-5 mt-1 bg-black">
  <h1 class=" text-4xl  p-5 font-semibold text-center text-white ">Showing recent posts with <span class="text-white bg-yellow-500 p-3 rounded-lg">#{{$hashtag->name}}</span></h1>
</div>
@foreach ($posts as $post)
    
<x-postcard :post="$post" :authFollowings="$authFollowings"/>

@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
</x-layout>