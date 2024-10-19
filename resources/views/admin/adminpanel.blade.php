<x-header-blog/>
<main class="admin w-screen  h-screen grid grid-cols-[25%,75%] transition-all ease-in-out duration-300">
  <aside id="sidebar" class="border-r-2 border-[#2e83ec] h-screen transition-all ease-in-out duration-300">
    <div class="parag w-full h-[10%] bg-[#2e83ec] text-white text-2xl font-semibold text-center flex justify-center items-center capitalize transition-opacity duration-300">admin panel</div>
    <div class="parag2 h-[30%] w-full flex flex-col items-center gap-2.5 mt-3.5 pt-3 transition-opacity duration-300">
      <button id="user-btn" class="h-10 w-40 capitalize text-2xl font-medium bg-[#2e83ec] text-white rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-[#2888fe] active:scale-95">users</button>
      <button id="post-btn" class="active h-10 w-40 capitalize text-2xl font-medium bg-[#2e83ec] text-white rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-[#2888fe] active:scale-95">posts</button>
    </div>
  </aside>
  <section id="main-section" class="p-5 transition-all ease-in-out duration-300 h-screen overflow-auto">
    @if (session()->has("success"))
      <p class="text-red-600 text-2xl font-semibold ">{{session('success')}}</p>
    @endif
    <div class="top-section flex gap-5">
      <span id="spn" class="text-4xl text-[#2e83ec] cursor-pointer">&leftarrow;</span>
      <h2 id="title-body" class="text-black text-2xl font-bold p-3">Posts Table</h2>
    </div>
    <table id="posts-table" class="w-full border-collapse ">
      <!-- Table Headers -->
      <tr class="bg-[#2e83ec]">
        <th class="text-white border border-black p-2">ID</th>
        <th class="text-white border border-black p-2">Username</th>
        <th class="text-white border border-black p-2">Image</th>
        <th class="text-white border border-black p-2">Title</th>
        <th class="text-white border border-black p-2">Body</th>
        <th class="text-white border border-black p-2">Likes</th>
        <th class="text-white border border-black p-2">Comments</th>
        <th class="text-white border border-black p-2">User ID</th>
        <th class="text-white border border-black p-2">CreatedAt</th>
        <th class="text-white border border-black p-2">Delete</th>
        <th class="text-white border border-black p-2">View</th>
      </tr>
      @foreach ($posts as $post)
      <tr class="text-center">
        <td class=" border border-black bg-white text-black p-2">{{$post->id}}</td>
        <td class="border border-black bg-white text-black p-2">{{$post->user->name}}</td>
        <td class="border border-black bg-white text-black  p-2">
          <img class="object-contain inline-block" src="/images/{{$post->image_path}}" width="40px" height="40px"  alt="{{$post->title}}">
        </td>
        <td class="border border-black bg-white text-black p-2">{{$post->slug}}</td>
        <td class="border border-black bg-white text-black p-2">{{$post->description}}</td>
        <td class="border border-black bg-white text-black p-2">{{$post->likes->count()}}</td>
        <td class="border border-black bg-white text-black p-2">{{$post->comments->count()}}</td>
        <td class="border border-black bg-white text-black p-2">{{$post->user->id}}</td>
        <td class="border border-black bg-white text-black p-2">{{$post->created_at->format('d-m-y')}}</td>
        <td class="border border-black bg-white text-white p-2">
          @can('delete', $post)
          <form action='/post/{{$post->slug}}' method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('delete')
            <input class="bg-red-500 rounded-lg p-2 cursor-pointer hover:bg-red-400 " type='submit' value="Delete">
          </form>
          @endcan
        </td>
        <td class="border border-black bg-white p-2"><a class="bg-blue-500 rounded-lg text-white p-2 hover:bg-blue-400 " href="/post/{{$post->slug}}">View</a></td>
      </tr>
      @endforeach
    </table>
    <table id="users-table" class="w-full border-collapse hidden">
      <!-- User Table Headers -->
      <tr class="bg-[#2e83ec]">
        <th class="text-white border border-black p-2">ID</th>
        <th class="text-white border border-black p-2">Avatar</th>
        <th class="text-white border border-black p-2">Name</th>
        <th class="text-white border border-black p-2">Email</th>
        <th class="text-white border border-black p-2">CreatedAt</th>
        <th class="text-white border border-black p-2">Phone</th>
        <th class="text-white border border-black p-2">Age</th>
        <th class="text-white border border-black p-2">Isblocked</th>
        <th class="text-white border border-black p-2">Delete</th>
        <th class="text-white border border-black p-2">Block</th>
      </tr>
      @foreach ($users as $user)
      <tr class="text-center">
        <td class="border border-black bg-white text-black p-2">{{$user->id}}</td>
        <td class="border border-black bg-white text-black p-2">
          <div class="inline-block">
            <img src="storage/avatars/{{$user->avatar}}"  class="w-[40px] h-[40px] overflow-hidden flex  justify-center items-center  shrink-0 grow-0 rounded-full">
          </div>
        </td>
        <td class="border border-black bg-white text-black p-2">{{$user->name}}</td>
        <td class="border border-black bg-white text-black p-2">{{$user->email}}</td>
        <td class="border border-black bg-white text-black p-2">{{$user->created_at->format("d-m-y")}}</td>
        <td class="border border-black bg-white text-black p-2">{{$user->phone}}</td>
        <td class="border border-black bg-white text-black p-2">{{$user->age}}</td>
        <td class="border border-black bg-white text-black p-2">{{$user->is_blocked}}</td>
        <td class="border border-black bg-white text-white p-2">
          @can('deleteuser', $user)
          <form action="{{ url('/admin/delete/' . $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 rounded-lg p-2 hover:bg-red-400 ">Delete</button>
          </form>
          @endcan
        </td>
        <td class="border border-black bg-white text-white p-2">
          @if($user->is_blocked)
          @can('block', $user)
          <form action="{{ url('/admin/unblock/' . $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to block this user?');">
            @csrf
            <button type="submit" class="bg-yellow-500 rounded-lg p-2 hover:bg-yellow-400 ">UnBlock</button>
          </form>
          @endcan
          @else
          @can('block', $user)
          <form action="{{ url('/admin/block/' . $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to block this user?');">
            @csrf
            <button type="submit" class="bg-yellow-500 rounded-lg p-2 hover:bg-yellow-400 ">Block</button>
          </form>
          @endcan
          @endif
        </td>
      </tr>
      @endforeach
    </table>
  </section>
</main>
<x-footer/>
