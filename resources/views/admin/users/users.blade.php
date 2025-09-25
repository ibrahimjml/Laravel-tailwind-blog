@extends('admin.partials.layout')
@section('title', 'Users Table | Dashboard')
@section('content')

<div class="md:ml-64">
  @include('admin.partials.header', [
          'linktext'        => 'Users Table',
          'route'           => 'admin.users',
          'value'           => request('search'),
         'searchColor'      => 'bg-blueGray-200',
         'borderColor'      => 'border-blueGray-200',
         'backgroundColor'  => 'bg-gray-400'
      ])

    {{-- Filter + Button --}}
  <div class="flex justify-between items-center mb-5 transform -translate-y-40 px-4">
    <div class="bg-blueGray-200 rounded-md p-2 h-10 flex items-center">
      <form action="{{ route('admin.users') }}" method="GET" class="flex items-center gap-2">
        <input type="checkbox" name="blocked" value="1"
          {{ request('blocked') ? 'checked' : '' }}
          onchange="this.form.submit()" class="rounded w-4 h-4">
        <label class="text-blueGray-500 font-semibold" for="blocked">Blocked</label>
      </form>
    </div>

    @can('user.create')
      <button id="openUserModel"
        class="bg-blueGray-200 text-blueGray-500 py-2 px-5 rounded-lg font-bold capitalize">
        Create User
      </button>
    @endcan
  </div>
 <div class="bg-white shadow rounded-xl overflow-hidden max-w-7xl lg:max-w-max mx-4 transform -translate-y-40 ">
    <x-tables.table id='' :headers="['#','Avatar','User','Role','Permissions','Submitted Reports','Reports Recieved','Verified','Phone','Age','Blocked','Username ChangedAt','CreatedAt','Actions']" title="Users Table" >
      @forelse ($users as $user)
  
      <tr>
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
        <td class="p-2 flex justify-start w-40">
        @can('user.role')
        @include('admin.users.partials.change-role')
       @else
        <p
        class="cursor-not-allowed bg-gray-600 font-bold text-white border border-gray-300 block  text-sm rounded-lg   w-full p-2.5 ">
        {{$user->roles->pluck('name')->implode(',')}}</p>
      @endcan
        </td>
        <td class="p-2">
          <div class="flex flex-wrap gap-2 justify-start items-center ">
          @forelse ($user->getAllPermissions()->take(3) as $name)
          <span class="bg-blueGray-200 text-sm font-semibold text-blueGray-500 px-2 py-1 rounded">
               {{$name}}
              </span>
              @empty
              <i class="fas fa-times text-red-600"></i>
          @endforelse
          </div>
        </td>
        <td>{{ $user->reports_submitted_count ?: '--' }}</td>
        <td>{{ $user->reports_received_count ?: '--' }}</td>
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
        <td class=" p-2">{{ $user->username_changed_at ? $user->username_changed_at->format('Y-m-d H:i') : '-' }}</td>
        <td class=" p-2">{{$user->created_at->diffForHumans()}}</td>
        <td colspan="2" class=" bg-white text-white p-2">
        <div class="flex justify-center gap-2">
        <div>
        @can('delete',$user)
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
        @can('block',$user)
        <form action="{{ route('toggle.block', $user->id) }}" method="POST"
        onsubmit='return confirm("Are you sure you want to {{$user->is_blocked ? "unblock":"block"}} {{$user->name}} ?");'>
        @csrf
        @method("PUT")
        <button type="submit" class="text-yellow-500 rounded-lg p-2 hover:text-yellow-400 "><i
        class="fas {{$user->is_blocked ? "fa-undo":"fa-ban"}}"></i></button>
        </form>
        @endcan
        </div>
        @can('user.edit')
        <button data-user-id="{{ $user->id }}" class="editusers text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300" ><i class="fas fa-edit"></i></button>
        @endcan
      </div>
    </td>
  </tr>
  {{-- user edit model --}}
  @include('admin.users.partials.edit-user-model',['permissions'=>$permissions,'roles'=>$roles,'user'=>$user])
      @empty
      <h4 class="text-center font-bold">Sorry, column not found</h4>
      @endforelse
  </x-tables.table>
  <div class="relative  ">
    {!! $users->links() !!}
  </div>
 </div>
</div>


  {{-- create user model --}}
  @include('admin.users.partials.create-user-model',['permissions'=>$permissions,'roles'=>$roles])
  
@endsection

@push('scripts')
<script>
    const showmenu = document.getElementById('openUserModel');
  const closemenu = document.getElementById('closeModel');
  const menu = document.getElementById("Model");

  if (showmenu && closemenu && menu) {
    showmenu.addEventListener('click', () => {
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
      }
    });

    closemenu.addEventListener('click', () => {
      if (menu.classList.contains('fixed')) {
        menu.classList.add('hidden');
      }
    });
  }
</script>
<script>
  document.querySelectorAll('.editusers').forEach(button => {
    const userId = button.dataset.userId;
    const modal = document.getElementById(`editModel-${userId}`);
    const closeBtn = document.getElementById(`closeEditModel-${userId}`);

    button.addEventListener('click', () => {
      modal.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });
  });
</script>

@endpush