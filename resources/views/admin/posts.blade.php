<x-layout>

<main class="admin w-screen grid grid-cols-[25%,75%] transition-all ease-in-out duration-300 p-5">
    {{-- admin side bar --}}
<x-admin-sidebar/>
<section id="main-section" class="p-5 transition-all ease-in-out duration-300 ">
  <div class="top-section flex gap-5">
    <span id="spn" class="text-4xl text-gray-600  cursor-pointer">&leftarrow;</span>
    <h2 id="title-body" class="text-gray-600 text-2xl font-bold p-3">Posts Table</h2>
  </div>
  
  <div class="flex justify-between w-[50%]">
    <div class="flex gap-2">
  {{-- sort option --}}
  <form  action="{{route('admin.posts')}}" method="GET">
        
    <select id="sort" name="sort" class="font-bold cursor-pointer bg-gray-700 text-white border border-gray-300 block  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="this.form.submit()">
      <option  value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option> 
      <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
    </select>
  </form>
  {{-- sort featured --}}
  <div class="bg-gray-700 rounded-md p-2 h-10">
    <form action="{{route('admin.posts')}}" method="GET">
      <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full w-5 h-4">
      <label class="text-white font-semibold" for="featured">Featured</label>
    </form>
  </div>
    </div>
      
  

      <form action="{{route('admin.posts')}}" class="w-[150px] sm:w-[250px] relative flex justify-end    translate-x-[12vw]  sm:translate-x-[30vw]  mb-5" method="GET">
      
        <input type="search" value="{{old('search',$filter['search'] ?? '')}}" class="peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-50 placeholder:text-gray-200 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none text-black dautofill:shadow-autofill peer-focus:text-primary " placeholder="Search" name="search" id="search" />
      
      <button class="relative z-[2] -ms-0.5 flex items-center rounded-e bg-gray-500 px-5  text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"  type="submit"  id="button-addon1"  >
        <span class="[&>svg]:h-5 [&>svg]:w-5">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </span>
      </button>
      </form>
  

  </div>
  <div class="overflow-x-auto rounded-lg shadow-lg">
    <table  class="min-w-full table-auto border-collapse">
    
      <tr class="bg-gray-600">
        <th class="text-white p-2">#</th>
        <th class="text-white p-2">Username</th>
        <th class="text-white p-2">Image</th>
        <th class="text-white p-2">Title</th>
        <th class="text-white p-2">Body</th>
        <th class="text-white p-2">Hashtags</th>
        <th class="text-white p-2">Featured</th>
        <th class="text-white p-2">Likes</th>
        <th class="text-white p-2">Comments</th>
        <th class="text-white p-2">CreatedAt</th>
        <th colspan="2" class="text-white  p-2">Actions</th>

      </tr>
      @forelse ($posts as $post)
      <tr class="text-center border border-b-gray-300 last:border-none">
        <td class="p-2">  {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
        <td class="p-2">{{$post->user->name}}</td>
        <td class="p-2">
          <img class="object-contain inline-block" src="/storage/uploads/{{$post->image_path}}" width="40px" height="40px"  alt="{{$post->title}}">
        </td>
        <td class="p-2">{{Str::limit($post->slug,20)}}</td>
        <td class="p-2">  {!! Str::limit(strip_tags($post->description), 40) !!}</td>
        <td class="p-2">
          @if($post->hashtags->isNotEmpty())
          {{$post->hashtags->pluck('name')->implode(', ')}}
          @else
          <i class="fa-solid fa-close text-red-600 "></i>
          @endif
        </td>
        <td class="p-2">
          <div class="flex justify-center">
            @if($post->is_featured)
            <i class="fa-solid fa-check text-green-500"></i>
            @else
            <i class="fa-solid fa-close text-red-600"></i>
            @endif
        </div>
        </td>
        <td class="p-2">{{$post->likes_count}}</td>
        <td class="p-2">{{$post->totalcomments_count}}</td>
        <td class="p-2">{{$post->created_at->diffForHumans()}}</td>
        <td  class=" text-white p-2 ">
          <div class="flex items-center justify-center">
            @can('delete', $post)
            <form action='/post/{{$post->slug}}' method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
              @csrf
              @method('delete')
              <button type="submit" class="rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100"><i class="fa-solid fa-trash"></i></button>
            </form>
            @endcan
            <a class=" rounded-lg text-gray-700 p-2  hover:text-gray-400 transition-colors duration-100" href="/post/{{$post->slug}}"><i class="fa-solid fa-eye"></i></a>
            <a  href="" class="rounded-lg text-yellow-600 p-2  hover:text-yellow-400 transition-colors duration-100"><i class="fa-solid fa-star"></i></a>
          </div>
        </td>
      </tr>
      @empty
    
        <h4 class="text-center font-bold">Sorry, column not found</h4>
    
      @endforelse
    </table>
  </div>

  {!! $posts->links() !!}
</section>
</main>
</x-header-blog>