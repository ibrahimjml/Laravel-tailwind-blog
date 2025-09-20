<x-layout>

{{--recent category posts --}}
@if($posts->count() == 0)

  <h1 class=" text-4xl p-36 font-semibold text-center w-54">No Posts Yet with # {{$currentCategory->name}}</h1>

@else
<div class="w-full p-5 mt-1 bg-black">
  <h1 class=" text-4xl  p-5 font-semibold text-center text-white ">Recent posts with category <span class="text-white bg-yellow-500 p-3 rounded-lg">{{$currentCategory->name}}</span></h1>
</div>
@foreach ($posts as $post)
    
<x-postcard :post="$post" :authFollowings="$authFollowings" :currentCategory="$currentCategory"/>

@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
</x-layout>