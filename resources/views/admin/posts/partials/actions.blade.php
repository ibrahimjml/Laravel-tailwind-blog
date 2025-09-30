{{-- delete --}}
@can('deleteAny', $post)
  <form action='/post/{{$post->slug}}' method="POST"
    onsubmit="return confirm('Are you sure you want to delete this post?');">
    @csrf
    @method('delete')
    <button type="submit" class="rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100"><i
        class="fas fa-trash"></i></button>
  </form>
@endcan
{{-- view --}}
<a class=" rounded-lg text-gray-700 p-2  hover:text-gray-400 transition-colors duration-100"
  href="{{route('single.post', $post->slug)}}">
  <i class="fas fa-eye"></i>
</a>
{{-- feature/unfeature --}}
@can('feature', $post)
  <form action="{{ route('admin.posts.featured.toggle', $post->id) }}" method="POST"
    onsubmit="return confirm('Toggle featured status?');">
    @csrf
    @method('PUT')
    <button type="submit" class="rounded-lg text-yellow-600 p-2 hover:text-yellow-400 transition-colors duration-100">
      <i class="{{ $post->is_featured ? 'fas' : 'far' }} fa-star"></i>
    </button>
  </form>
@endcan
{{-- status edit --}}
@can('updateAny', $post)
<button data-id="{{$post->id}}" data-slug="{{$post->slug}}" data-status="{{$post->status->value}}"
  class="edit-btn w-6 h-6 rounded-[50%] bg-slate-50 text-blue-500 hover:bg-opacity-65 transition-bg-opacity duration-100">
  <i class="fas fa-edit"></i>
</button>
@endcan