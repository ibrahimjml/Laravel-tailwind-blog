<x-layout>

  <main class="admin w-screen grid grid-cols-[25%,75%] transition-all ease-in-out duration-300 p-5">
      {{-- admin side bar --}}
  <x-admin-sidebar/>
  <section id="main-section" class="p-5 transition-all ease-in-out duration-300 ">
    <div class="top-section flex gap-5">
      <span id="spn" class="text-4xl text-gray-600  cursor-pointer">&leftarrow;</span>
      <h2 id="title-body" class="text-gray-600 text-2xl font-bold p-3">Hashtags Table</h2>
    </div>
    
<div class="flex justify-end">
  <button id="openTagModel" class="text-center ml-0 mr-2 sm:ml-auto w-36   bg-gray-500  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6" href="{{route('create')}}">create tag</button>
</div>
    <div class="overflow-x-auto rounded-lg shadow-lg ">
      <table id="tabletags" class="min-w-full  border-collapse">
      
        <tr class="bg-gray-600">         
          <th class="text-white p-2">#</th>
          <th class="text-white p-2 text-left w-fit">Hashtags</th>
          <th class="text-white p-2">Related posts</th>
          <th class="text-white p-2">CreatedAt</th>
          <th colspan="2" class="text-white  p-2">Actions</th>
  
        </tr>
        @forelse ($hashtags as $hashtag)
        <tr class="text-center border border-b-gray-300 last:border-none">
          <td class="p-2">{{ ($hashtags->currentPage() - 1) * $hashtags->perPage() + $loop->iteration }}</td>
          <td class=" p-2 flex justify-start items-center">
            <span class=" py-1 px-3 text-white  text-sm rounded-md bg-gray-700 bg-opacity-70 font-semibold w-fit">

              {{$hashtag->name}}</td>
            </span>
          <td class="p-2">  {{$hashtag->posts->count()}}</td>
          
          <td class="p-2">{{$hashtag->created_at->diffForHumans()}}</td>
          <td  class=" text-white p-2">
            <div class="flex gap-2 justify-center">
            
              <form class="tagsdelete" action='{{route('delete.hashtag',$hashtag->id)}}' method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
              <button class="tagsedit text-blue-500 rounded-lg p-2 cursor-pointer hover:text-blue-300" data-name="{{ $hashtag->name }}"  data-id="{{ $hashtag->id }}"><i class="fa-solid fa-edit"></i></button>
            </div>
          
          </td>
        </tr>
        @empty
      
          <h4 class="text-center font-bold">Sorry, column not found</h4>
      
        @endforelse
      </table>
    </div>

    {!! $hashtags->links() !!}
  {{-- edit tag model --}}
  @include('admin.partials.edit-tag-model',['hashtag'=>$hashtag])
{{-- tag model --}}
@include('admin.partials.create-tag-model')
  </section>
  </main>

</x-layout>