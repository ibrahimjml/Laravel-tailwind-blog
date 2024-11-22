<x-header-blog>
@if(session()->has('success'))
  <div id="parag3" class="fixed  bg-green-500 p-[10px] text-center top-[100px] left-[150px] sm:left-[40%] transform translate-y-[30px] sm:transform sm:translate-y-0 z-20">
  <p  class="text-center font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif
  @if(session()->has('error'))
  <div id="parag3" class="fixed  bg-red-500 p-[10px] text-center top-[100px] left-[150px] sm:left-[40%] transform translate-y-[30px] sm:transform sm:translate-y-0 z-20">
  <p  class="text-center font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif

{{-- posts --}}

@if($posts->count() == 0)

  <h1 class=" text-4xl p-36 font-semibold text-center w-54">No Posts Yet</h1>

@else
<h1 class=" text-4xl  p-5 font-semibold text-center text-gray-500 w-54">Showing recent posts with # <span class="text-black">{{$hashtag->name}}</span></h1>
@foreach ($posts as $post)
    
<x-postcard :post="$post" />

@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>

<x-footer/>
</x-header-blog>