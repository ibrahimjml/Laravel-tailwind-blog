@extends('admin.partials.layout')
@section('title','Permissions page | Dashboard')
@section('content')

@include('admin.partials.header', ['linktext' => 'Permissions table', 'route' => 'permissions.index', 'value' => request('search')])


<div class="w-[90%] -m-24 mx-auto">

@can('permission.create')
<div class="flex justify-end">
  <button id="openPermissionModel" class="text-center ml-0 mr-2 sm:ml-auto w-36   bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6" href="{{route('permissions.create')}}">create permission</button>
</div>
@endcan
  <div class="relative md:ml-64 rounded-xl overflow-hidden bg-white shadow">
      <table id="tablepermissions" class="min-w-full table-auto">
      
        <tr class="bg-gray-600">         
          <th class="text-white p-2">#</th>
          <th class="text-white p-2 text-left w-fit">Permissions</th>
        
          <th class="text-white p-2">CreatedAt</th>
          <th colspan="2" class="text-white  p-2">Actions</th>
  
        </tr>
        @foreach ( $permissions as $permission )
        <tr class="text-center border border-b-gray-300 last:border-none">
          <td class="p-2">{{$permission->id}}</td>
          <td class=" p-2 flex justify-start items-center">
            <span class=" py-1 px-3 text-white  text-sm rounded-md bg-gray-700 bg-opacity-70 font-semibold w-fit">
          {{$permission->name}}
            </td>
            </span>
          
          
          <td class="p-2">{{$permission->created_at}}</td>
          <td  class=" text-white p-2">
            <div class="flex gap-2 justify-center">
              @can('permission.delete')
              <form class="permissiondelete" action="{{route('permissions.destroy',$permission->id)}}"  method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
              @can('permission.update')
              <button class="permissionedit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300"  data-name="{{ $permission->name }}"  data-id="{{ $permission->id }}"><i class="fas fa-edit"></i></button>
              @endcan
            </div>
          
          </td>
        </tr>
      @endforeach
      </table>
    </div>

  
    </div>
@include('admin.partials.create-permission-model')
@include('admin.partials.edit-permission-model',['permission'=>$permission])
@endsection
@push('scripts')
<script>
    const showmenu = document.getElementById('openPermissionModel');
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
    const addpermission = document.getElementById('addpermission');

    addpermission.addEventListener('submit', (eo) => {
      eo.preventDefault();

      const input = addpermission.querySelector('input[name="name"]');
      const content = input.value.trim();
      const menu = document.getElementById("Model");
      if (!content) return;

      let options = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: content })
      };

      fetch(addpermission.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.added === true) {
            menu.classList.add('hidden');
            toastr.success(`Permission  Added`);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });

  const editButtons = document.querySelectorAll('.permissionedit');
  const editModal = document.getElementById('editModel');
  const closeEditBtn = document.getElementById('closeEditModel');
  const editForm = document.getElementById('edittag');
  if (editModal && closeEditBtn && editForm) {
    const nameInput = editForm.querySelector('input[name="name"]');
    const token = editForm.querySelector('input[name="_token"]').value;

    editButtons.forEach(button => {
      button.addEventListener('click', () => {
        const permissionID = button.dataset.id;
        const permissionName = button.dataset.name;

        editForm.action = `/admin/permissions/${permissionID}`;
        nameInput.value = permissionName;

        editModal.classList.remove('hidden');
      });
    });

    editForm.addEventListener('submit', (e) => {
      e.preventDefault();

      let options = {
        method: 'PUT',
        headers: {
          'X-CSRF-TOKEN': token,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ name: nameInput.value })
      };

      fetch(editForm.action, options)
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

  const permissions = document.querySelectorAll('.permissiondelete');
  permissions.forEach(permission => {
    permission.addEventListener('submit', (eo) => {
      eo.preventDefault();
      let options = {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': permission.querySelector('input[name="_token"]').value,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      };
      fetch(permission.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.deleted === true) {
            toastr.success(data.message);
            permission.closest('tr').remove();
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  });
</script>
@endpush