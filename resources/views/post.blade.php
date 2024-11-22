<x-header-blog>
@if(session()->has('success'))
  <div id="parag3" class="fixed  bg-green-500 p-[10px] text-center top-[100px] left-[150px] sm:left-[40%] transform translate-y-[30px] sm:transform sm:translate-y-0 z-20">
  <p  class="text-center font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif
<div class="container mx-auto ">
  @can('view',$post)
  <div class="flex justify-center items-center mt-3">
    <a href="{{route('edit.post',$post->slug)}}" class="flex sm:hidden justify-center items-center bg-blue-700   w-32 text-slate-200 p-2 py-1 sm:py-3 px-2 sm:px-5  rounded-lg font-medium sm:font-bold capitalize ">edit</a>
  </div>
  @endcan

  <div class=" container mx-auto flex  flex-row justify-center items-center pb-2 sm:pb-6 translate-x-7  mt-4">
     <div class=" sm:mx-0 flex justify-center items-center" >
      
      <span class="text-sm italic sm:text-lg ">
        <strong class="">BY: </strong>
        <a href="{{route('profile',$post->user->username)}}">{{$post->user->username}}</a>
      </span>
    
      &nbsp;&nbsp;
      <span class="text-sm italic sm:text-lg flex items-center mr-0 sm:mr-36 ">
        <b>Updated-at :</b> &nbsp;{{$post->updated_at->diffForHumans()}}
      </span>
     </div>
      
      
      
      <div class="flex  items-center justify-center translate-x-0 sm:translate-x-[-3rem] mx-auto sm:mx-0">
        
        @can('delete',$post)
        <div>
          <form action="{{route('delete.post',$post->slug)}}" method="POST" onsubmit="return confirm('Are you sure you want delete this post ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="hidden sm:flex justify-center bg-red-700 ml-9  w-32 text-slate-200 p-2 py-1 sm:py-3 px-2 sm:px-5  rounded-lg font-medium sm:font-bold capitalize place-self-start  ">Delete</button>
            <button type="submit" class="sm:hidden p-2 rounded-full bg-red-100 flex items-center mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ee4811" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></button>
          </form>
        </div>
        @endcan
      
        @can('view',$post)
        <a href="{{route('edit.post',$post->slug)}}" class="hidden sm:flex justify-center bg-blue-700 ml-9  w-32 text-slate-200 p-2 py-1 sm:py-3 px-2 sm:px-5  rounded-lg font-medium sm:font-bold capitalize place-self-start">edit</a>
        @endcan
      </div>
      
    
      
    
  </div>
  <div>
    <img class="object-contain rounded-none md:rounded-lg w-[90%] md:w-[60%] h-120  mx-auto s shadow-lg hover:shadow-md" src="/images/{{$post->image_path}}"  alt="">
    <div class="flex gap-1 justify-between items-center ml-0 sm:ml-[290px] mt-1">
      <span class="text-xl ml-10 items-center">&#128420;</span>
      <span id="likes-count" class="text-xl">{{$post->likes()->count()}}</span>
      {{-- like/unlike button fetch --}}
    @if($post->is_liked())
    <button onclick="fetchLike({{$post->id}})" class="likeBTN mb-4 mx-auto  sm:mx-auto   bg-transparent border-2 text-red-700 py-2 px-5 rounded-lg font-bold capitalize border-red-300  hover:border-red-700 hover:text-red-500 transition duration-300 mt-4">Unlike</button>
  @else
  <button onclick="fetchLike({{$post->id}})" class="likeBTN mb-4 mx-auto  sm:mx-auto  bg-transparent border-2 text-red-700 py-2 px-5 rounded-lg font-bold capitalize border-red-300  hover:border-red-700 hover:text-red-500 transition duration-300 mt-4">Like</button>
  @endif
    </div>
    
</div>
<div class="w-[80vw] mx-auto py-12">
  {!! $post->description !!}
</div>
{{-- comment form --}}
  <div class="w-fit mb-4 border-2 p-1 rounded-lg px-5 mx-auto">
    <form action="/comment/{{$post->id}}" method="POST">
      @csrf
      <h5 class="text-gray-500 mb-2">Add a new comment</h5>
      <textarea class="border-2 bg-gray-100  rounded-lg placeholder-gray-400 pl-2 placeholder-opacity-100 @error('content') border-red-500 @enderror" placeholder="Type Your Comment" name="content" id="content" cols="40" ></textarea>
      @error('content')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      <button type="submit" class="block text-white rounded-lg p-1 text-sm ml-auto bg-blue-500">post a comment</button>
    </form>
  </div>
  <h2 class="w-fit mx-auto mb-4">Comments ({{ $post->comments->count() }})</h2>

  
</div>
 

{{--display comment Form --}}
@include('comments.comments',['posts'=>$post->comments])





  {{-- contianer random hearts--}}
<div id="containerheart"></div>





<x-footer/>
</x-header-blog>
  
  
  

