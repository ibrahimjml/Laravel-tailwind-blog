<x-header-blog>

@if($posts->count() == 0)

  <h1 class=" text-4xl p p-36 font-semibold text-center w-54">No Saved Posts </h1>
@else

@foreach ($posts as $post)
    <x-postcard :post="$post" />
@endforeach
@endif
<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
<x-footer/>
</x-header-blog>