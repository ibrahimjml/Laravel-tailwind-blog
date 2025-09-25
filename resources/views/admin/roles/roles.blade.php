@extends('admin.partials.layout')
@section('title','Tags Page | Dashboard')
@section('content')

@include('admin.partials.header', [
  'linktext' => 'Roles table',
   'route' => 'roles.index', 
   'value' => request('search'),
    'searchColor'     => 'bg-blueGray-200',
       'borderColor'     => 'border-blueGray-200',
       'backgroundColor' => 'bg-gray-400'
   ])


<div class="w-[90%] -m-24 mx-auto">

@can('role.create')
<div class="flex justify-end">
  <button id="openRoleModel" class="text-center ml-0 mr-2 sm:ml-auto w-36   bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6" href="{{route('roles.create')}}">create role</button>
</div>
@endcan
  <div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow">
    <x-tables.table id="tableroles" :headers="['#','Roles','Permissions','CreatedAt','Actions']" title="Roles Table" >
        @foreach ( $roles as $role )
         <tr>
          <td class="p-2">{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</td>
    <td class="p-2 ">
    <div class="flex justify-start  h-full">
        <span class="py-1 px-3 text-white text-sm rounded-md bg-gray-700 bg-opacity-70 font-semibold">
            {{ $role->name }}
        </span>
     </div>
      </td>
        <td class="max-w-[200px] ">
         <div class="flex flex-wrap gap-2">
           @foreach($role->permissions->take(10) as $permission)
             <span class="bg-gray-200 gap-2 text-sm text-black px-2 py-1 rounded">
               {{ $permission->name }}
             </span>
           @endforeach
         </div>
       </td>
          
          <td class="p-2">{{$role->created_at}}</td>
          <td  class=" text-white p-2">
            <div class="flex gap-2 justify-start">
              @can('role.delete')
              <form class="rolesdelete" action="{{route('roles.destroy',$role->id)}}"  method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
              @can('role.update')
              <button class="roleedit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300" 
                      data-name="{{ $role->name }}"  
                      data-id="{{ $role->id }}" 
                      data-permissions='@json($role->permissions->pluck('id')->toArray())'>
              <i class="fas fa-edit"></i>
            </button>
             @endcan
            </div>
          
          </td>
        </tr>
      @endforeach
      </x-tables.table>
    </div>
  
    <div class="relative md:ml-64 ">
 {!! $roles->links() !!} 
    </div>
    </div>
    @include('admin.roles.partials.create-role-model',['permissions'=>$permissions])

@include('admin.roles.partials.edit-role-model',['permissions'=>$permissions])

@endsection
@push('scripts')
<script>
    const showmenu = document.getElementById('openRoleModel');
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
    const addrole = document.getElementById('addrole');

    addrole.addEventListener('submit', (eo) => {
      eo.preventDefault();

      const input = addrole.querySelector('input[name="name"]');
      const content = input.value.trim();
      const menu = document.getElementById("Model");
      if (!content) return;
const checkedPermissions = Array.from(addrole.querySelectorAll('input[name="permissions[]"]:checked'))
    .map(el => parseInt(el.value));
      let options = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: content , permissions: checkedPermissions})
      };

      fetch(addrole.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.added === true) {
            menu.classList.add('hidden');
            toastr.success(`Role  Added`);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  
  const editButtons = document.querySelectorAll('.roleedit');
const editModal = document.getElementById('editModel');
const closeEditBtn = document.getElementById('closeEditModel');
const editForm = document.getElementById('editrole');

if (editModal && closeEditBtn && editForm) {
  const nameInput = editForm.querySelector('input[name="name"]');
  const token = editForm.querySelector('input[name="_token"]').value;
  const title = document.getElementById('editTitle');

  editButtons.forEach(button => {
    button.addEventListener('click', () => {
      const roleID = button.dataset.id;
      const roleName = button.dataset.name;
      const rolePermissions = JSON.parse(button.dataset.permissions); 

      editForm.action = `/admin/roles/${roleID}`;
      nameInput.value = roleName;
      title.textContent = `Edit role ${roleName}`;

      const checkboxes = editForm.querySelectorAll('input[name="permissions[]"]');
      checkboxes.forEach(checkbox => {
        checkbox.checked = rolePermissions.includes(parseInt(checkbox.value));
      });

      editModal.classList.remove('hidden');
    });
  });

  editForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const checkedPermissions = Array.from(editForm.querySelectorAll('input[name="permissions[]"]:checked'))
      .map(input => parseInt(input.value));

    fetch(editForm.action, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': token,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        name: nameInput.value,
        permissions: checkedPermissions
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.edited === true) {
        toastr.success(data.message);
        editModal.classList.add('hidden');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });

  closeEditBtn.addEventListener('click', () => {
    editModal.classList.add('hidden');
  });
}


    const roles = document.querySelectorAll('.rolesdelete');
  roles.forEach(role => {
    role.addEventListener('submit', (eo) => {
      eo.preventDefault();
      let options = {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': role.querySelector('input[name="_token"]').value,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      };
      fetch(role.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.deleted === true) {
            toastr.success(data.message);
            role.closest('tr').remove();
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  });
</script>
@endpush