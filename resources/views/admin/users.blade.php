@extends('admin.partials.layout')
@section('title', 'Users Table | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Users Table', 'route' => 'admin.users', 'value' => request('search')])
<div class="md:ml-64  px-4 py-2 mb-3 -m-[120px] w-[80%]">
  <div class="flex justify-between items-center mb-5">

    <div class="bg-gray-600 rounded-md p-2 h-10 flex items-center ml-3">
    <form action="{{route('admin.users')}}" method="GET" class="flex items-center gap-1">
      <input type="checkbox" name="blocked" value="1" {{ request('blocked') ? 'checked' : '' }}
      onchange="this.form.submit()" class="rounded-full w-4 h-4">
      <label class="text-white font-semibold" for="blocked">Blocked</label>
    </form>
    </div>

  </div>
</div>
<div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow w-[80%] left-6">
    <table class="min-w-full table-auto overflow-auto">
    <!-- User Table Headers -->
    <tr class="bg-gray-600">
      <th class="text-white p-2">#</th>
      <th class="text-white p-2">Avatar</th>
      <th class="text-white p-2 w-1/4 text-left">User</th>
      <th class="text-white p-2 ">Role</th>
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

    <tr class="text-center border border-b-gray-300 ">
      <td class="p-2"> {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
      <td class=" p-2">
      <div class="inline-block">
      <img src="{{$user->avatar_url}}"
      class="w-[40px] h-[40px] overflow-hidden flex  justify-center items-center  shrink-0 grow-0 rounded-full">
      </div>
      </td>
      <td class="p-2 text-left">
      <div class="flex flex-col gap-2">
      <p>{{$user->name}} <span class="text-blue-400">@ {{$user->username}}</span> </p>
      <p>{{$user->email}}</p>
      </div>
      </td>
      <td class="p-2 flex justify-center w-32">
      @can('modify', $user)
      <form action="{{route('role.update', $user)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="relative w-full">
        <select name="role"
        class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-gray-600 text-white text-sm rounded-lg w-full p-2.5">
        <option value="user" {{!$user->is_admin ? 'selected' : ''}}>User</option>
        <option value="admin" {{$user->is_admin ? 'selected' : ''}}>Admin</option>
        </select>
        <!-- Custom white arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M19 9l-7 7-7-7" />
        </svg>
        </div>
      </div>
      </form>
    @else
      <p
      class="cursor-not-allowed bg-gray-600 text-white border border-gray-300 block  text-sm rounded-lg   w-full p-2.5 ">
      Admin</p>
    @endcan
      </td>
      <td class="p-2">{{$user->followings->count()}}</td>
      <td class="p-2">{{$user->followers->count()}}</td>
      <td class=" p-2">{{$user->created_at->diffForHumans()}}</td>
      <td class=" p-2">
      <div class="flex justify-center">
      @if($user->email_verified_at)
      <i class="fas fa-check text-green-500"></i>
      @else
      <i class="fas fa-times text-red-600"></i>
      @endif
      </div>
      </td>
      <td class=" p-2">{{$user->phone}}</td>
      <td class=" p-2">{{$user->age}}</td>
      <td class=" bg-white  p-2 text-center">
      <div class="flex justify-center">
      @if($user->is_blocked)
      <i class="fas fa-check text-green-500"></i>
      @else
      <i class="fas fa-times text-red-600"></i>
      @endif
      </div>
      </td>
      <td colspan="2" class=" bg-white text-white p-2">
      <div class="flex justify-center gap-2">
      <div>
      @can('modify', $user)
      <form action="{{ route('delete.user', $user) }}" method="POST"
      onsubmit="return confirm('Are you sure you want to delete this user?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-red-500 rounded-lg p-2 hover:text-red-400 "><i
      class="fas fa-trash"></i></button>
      </form>
      @endcan
      </div>


      <div>
      @if($user->is_blocked)
      @can('modify', $user)
      <form action="{{ route('unblock.user', $user) }}" method="POST"
      onsubmit='return confirm("Are you sure you want to unblock {{$user->name}} ?");'>
      @csrf
      <button type="submit" class="text-yellow-500 rounded-lg p-2 hover:text-yellow-400 "><i
      class="fas fa-undo"></i></button>
      </form>
      @endcan
      @else
      @can('modify', $user)
      <form action="{{ route('block.user', $user) }}" method="POST"
      onsubmit="return confirm('Are you sure you want to block {{$user->name}} ?');">
      @csrf
      <button type="submit" class="text-yellow-500 rounded-lg p-2 hover:text-yellow-400 "><i
      class="fas fa-ban"></i></button>
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

  <div class="relative md:ml-64 md:w-[80%] md:left-4">
    {!! $users->links() !!}
  </div>
@endsection