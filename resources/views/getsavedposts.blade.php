<x-layout>

  <div id="savedPostsContainer">

    @foreach ($posts as $post)
      <div id="post-{{ $post->id }}" class="saved-post">
        <x-postcard :post="$post" :showSaveButton="true" :authFollowings="$authFollowings"/>
      </div>
    @endforeach
    <h1 id="noSavedMessage" class="text-4xl p-36 font-semibold text-center w-54 hidden">No Saved Posts</h1>
  </div>

<div class="container mx-auto flex justify-center gap-6 mt-2 mb-2">
  {!! $posts->links() !!}
</div>
</x-layout>