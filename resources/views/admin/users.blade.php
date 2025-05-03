<x-layout>

<main class="admin w-screen  grid grid-cols-[25%,75%] transition-all ease-in-out duration-300 p-5">
    {{-- admin side bar --}}
<x-admin-sidebar/>
<section id="main-section" class="p-5 transition-all ease-in-out duration-300 ">
  <div class="top-section flex gap-5">
    <span id="spn" class="text-4xl text-gray-600  cursor-pointer">&leftarrow;</span>
    <h2 id="title-body" class="text-gray-600 text-2xl font-bold p-3">Users Table</h2>
  </div>
  <div class="flex justify-between items-center  mb-5">

    <div class="bg-gray-600  p-2 rounded-md">
      <form action="{{route('admin.users')}}" method="GET">
        <input type="checkbox" name="blocked" value="1" {{ request('blocked') ? 'checked' : '' }} onchange="this.form.submit()">
        <label class="text-white font-semibold" for="blocked">Blocked</label>
      </form>
    </div>



  <form action="{{route('admin.users')}}" class="w-[150px] sm:w-[250px] relative flex justify-end" method="GET">
  
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

  <div class="overflow-x-auto rounded-lg  shadow-lg">
  <table  class="w-full border-collapse ">
    <!-- User Table Headers -->
    <tr class="bg-gray-600">
      <th class="text-white p-2">#</th>
      <th class="text-white p-2">Avatar</th>
      <th class="text-white p-2 w-1/4 text-left">User</th>
      <th class="text-white p-2 w-1/6">Role</th>
      <th class="text-white p-2 ">Followings</th>
      <th class="text-white p-2 ">Followers</th>
      <th class="text-white p-2">CreatedAt</th>
      <th class="text-white p-2">Verified</th>
      <th class="text-white p-2">Phone</th>
      <th class="text-white p-2">Age</th>
      <th class="text-white p-2">Blocked</th>
      <th colspan="2" class="text-white p-2">Actions</th>

    </tr>
    @forelse ($users as $user)

    <tr class="text-center border border-b-gray-300 last:border-none">
      <td class="p-2">  {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
      <td class=" p-2">
        <div class="inline-block">
          <img src="{{$user->avatar_url}}"  class="w-[40px] h-[40px] overflow-hidden flex  justify-center items-center  shrink-0 grow-0 rounded-full">
        </div>
      </td>
      <td class="p-2 text-left">
        <div class="flex flex-col gap-2">
         <p>{{$user->name}} <span class="text-blue-400">@ {{$user->username}}</span> </p>
         <p>{{$user->email}}</p>
        </div>
      </td>
      <td class="p-2 flex justify-center w-32">
        @can('modify',$user)
        <form  action="{{route('role.update',$user)}}" method="POST">
         @csrf
         @method('PUT')
          <select  name="role" class="cursor-pointer  bg-gray-600 text-white border border-gray-300 block  text-sm rounded-lg   w-full p-2.5 " onchange="this.form.submit()">
            <option value="user"{{!$user->is_admin ? 'selected':''}} >User</option> 
            <option value="admin" {{$user->is_admin ? 'selected' :''}}>Admin</option>
        
          </select>
        </form>
        @else
        <p class="cursor-not-allowed bg-gray-600 text-white border border-gray-300 block  text-sm rounded-lg   w-full p-2.5 ">Admin</p>
        @endcan
      </td>
      <td class="p-2">{{$user->followings->count()}}</td>
      <td class="p-2">{{$user->followers->count()}}</td>
      <td class=" p-2">{{$user->created_at->diffForHumans()}}</td>
      <td class=" p-2">
        <div class="flex justify-center">
          @if($user->email_verified_at)
          <i class="fa-solid fa-check text-green-500"></i>
          @else
          <i class="fa-solid fa-close text-red-600"></i>
          @endif
      </div>
      </td>
      <td class=" p-2">{{$user->phone}}</td>
      <td class=" p-2">{{$user->age}}</td>
      <td class=" bg-white  p-2 text-center">
      <div class="flex justify-center">
          @if($user->is_blocked)
          <i class="fa-solid fa-check text-green-500"></i>
          @else
          <i class="fa-solid fa-close text-red-600"></i>
          @endif
      </div>
      </td>
      <td colspan="2" class=" bg-white text-white p-2">
      <div class="flex justify-center gap-2">
        <div>
            @can('modify', $user)
            <form action="{{ route('delete.user', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 rounded-lg p-2 hover:text-red-400 "><i class="fa-solid fa-trash"></i></button>
            </form>
            @endcan
        </div>
        
        
        <div>
            @if($user->is_blocked)
            @can('modify', $user)
            <form action="{{ route('unblock.user', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to block this user?');">
              @csrf
              <button type="submit" class="text-yellow-500 rounded-lg p-2 hover:text-yellow-400 "><i class="fas fa-undo"></i></button>
            </form>
            @endcan
            @else
            @can('modify', $user)
            <form action="{{ route('block.user', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to block this user?');">
              @csrf
              <button type="submit" class="text-yellow-500 rounded-lg p-2 hover:text-yellow-400 "><i class="fas fa-ban"></i></button>
            </form>
            @endcan
            @endif
        </div>
      </div>
      </td>
    </tr>
    @empty
    <h4 class="text-center font-bold">Sorry, column not found</h4>
    @endforelse
  </table>
</div>
{!! $users->links() !!}
</section>
</main>
</x-layout>