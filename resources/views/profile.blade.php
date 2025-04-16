<x-header-blog>
  @section('meta_title',$meta_title)
  @section('meta_keywords')
  @section('author',$author)
  @section('meta_description')

  
<div class=" container mx-auto mt-[30px]">

  <div class="relative w-[170px]  h-[170px]   mx-auto  mb-5">
    @if($user->avatar !== "default.jpg")
    <img src="{{Storage::url($user->avatar)}}" alt=""  class="w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-gray-500">
    @can('update',$user)
    <span class="absolute  bottom-[18px] right-[10px] flex justify-center items-center w-6 h-6 shrink-0 grow-0 rounded-full bg-gray-600 text-white"><a href="/edit-avatar/{{$user->id}}"><i class="fa fa-plus" aria-hidden="true"></i></a></span>
    @endcan
    
    @else
    <img src="/storage/avatars/{{$user->avatar}}" alt=""  class="w-full h-full overflow-hidden flex justify-center items-center  shrink-0 grow-0 rounded-full border-4 border-gray-500">
    @can('update',$user)
    <span class="absolute  bottom-[18px] right-[10px] flex justify-center items-center w-6 h-6 shrink-0 grow-0 rounded-full bg-gray-600 text-white"><a href="/edit-avatar/{{$user->id}}"><i class="fa fa-plus" aria-hidden="true"></i></a></span>
  
    @endcan
    @endif

  </div>
  @can('update',$user)
  <span class="flex justify-center mb-5"><a class="bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize inline-block hover:border-gray-700 transition duration-300" href="{{route('editprofile',$user->username)}}">edit profile</a></span>
  @endcan
  <div class="flex flex-col pb-3">
    <h1 class=" text-3xl font-bold text-center  tracking-wide text-gray-700">{{$user->name}} </h1>
    <span class="text-sm text-gray-400 text-center mb-2">@ {{$user->username}}</span>
    @if($user->bio == null)
    <p class="text-lg text-gray-400 text-center mb-2">Tell people about yourself</p>
    @else
    <p class="text-lg text-gray-600 text-center font-semibold mb-2">{{$user->bio}}</p>
    @endif
  </div>
</div>
<div class=" mx-auto flex  justify-center gap-6">
  
  <div class="flex flex-col">
    <p class="text-lg font-bold ">posts</p>
    {{-- count posts --}}
    <p class="text-lg font-bold text-center">{{$postcount}}</p>
  </div>

<div class="flex  w-30 gap-5">
  {{-- likes count --}}
  <div class="flex flex-col">
  <p class="text-lg font-bold text-center">Total likes</p>
  <p class="text-lg font-bold text-center">{{$likescount}}</p>
  </div>
  <div class="flex flex-col">
{{-- comment counts --}}
    <p class="text-lg font-bold text-center">comments</p>
    <p class="text-lg font-bold text-center">{{$commentscount}}</p>
  </div>
</div>

</div>

<hr>
@if($posts->count() == 0)

<h1 class=" text-4xl  p-6 font-semibold text-center w-54">No Posts</h1>
@else
<div class="mt-5 sm:grid grid-cols-4 gap-6 space-y-6 sm:space-y-0">
  @foreach($posts as $post)
  <div class="flex flex-wrap items-center justify-center ">
    <a  href="/post/{{$post->slug}}">
      <img src="/images/{{$post->image_path}}" alt="" class="ml-auto mr-auto w-[80%] rounded-lg mb-5">
    </a>
    
  </div>
  
  @endforeach
  @endif
</div>

<x-footer/>
</x-header-blog>