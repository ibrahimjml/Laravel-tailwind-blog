<x-layout>
  @section('meta_title',$meta_title)
  @section('meta_keywords',$meta_keywords)
  @section('author',$author)
  @section('meta_description')

  <div id="savedPostsContainer">

    @foreach ($posts as $post)
      <div id="post-{{ $post->id }}" class="saved-post">
        <x-postcard :post="$post" :showSaveButton="true" />
      </div>
    @endforeach
    <h1 id="noSavedMessage" class="text-4xl p-36 font-semibold text-center w-54 hidden">No Saved Posts</h1>
  </div>

<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
</x-layout>