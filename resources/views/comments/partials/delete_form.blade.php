<form delete-comment="{{$comment->id}}"  action="{{route('delete.comment',$comment->id)}}" method="POST">
  @csrf
  @method('delete')
  <button type="submit" class="text-left font-semibold w-full rounded-md pl-3 hover:bg-gray-400 hover:text-white transition-all duration-150">delete</button>
</form>