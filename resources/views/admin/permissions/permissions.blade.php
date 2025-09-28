@extends('admin.partials.layout')
@section('title', 'Permissions page | Dashboard')
@section('content')

<div class="md:ml-64 ">
  @include('admin.partials.header', [
       'linktext'           => 'Manage Permissions', 
       'route'              => 'admin.permissions.index', 
       'value'              => request('search'),
       'searchColor'       => 'bg-blueGray-200',
       'borderColor'       => 'border-blueGray-200',
       'backgroundColor'   => 'bg-gray-400'
    ])

    @can('permission.create')
      <div class="flex justify-end transform -translate-y-40">
        <button id="openPermissionModel"
          class="text-center ml-0 mr-2 sm:ml-auto w-fit   bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">create permission</button>
      </div>
    @endcan

   <div class="bg-white shadow rounded-xl overflow-hidden w-7xl mx-4 transform -translate-y-40 ">
      @foreach ($permissions as $module => $group)
        <x-tables.table id="tablepermissions" :headers="['#', 'Permission', 'Module', 'Description', 'CreatedAt', 'Actions']"
          title="{{ $module }} Permissions">
          @foreach ($group as $permission)
            <tr>
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2 flex justify-start items-center">
                <span class="py-1 px-3 text-blueGray-500 text-sm rounded-md bg-blueGray-200 bg-opacity-70 font-semibold w-fit">
                  {{ $permission->name }}
                </span>
              </td>
              <td>{{ $permission->module?->value ?? '--' }}</td>
              <td>{{ $permission->description ?? '--' }}</td>
              <td class="p-2">{{ $permission->created_at->format('Y-m-d') }}</td>
              <td class="text-white p-2">
                <div class="flex gap-2 justify-start">
                  @can('permission.delete')
                    <form class="permissiondelete" action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                      @csrf
                      @method('delete')
                      <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  @endcan
                  @can('permission.update')
                    <button data-name="{{ $permission->name }}" data-id="{{ $permission->id }}"
                      data-module="{{$permission->module}}" data-description="{{$permission->description}}"
                      class="permissionedit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300">
                      <i class="fas fa-edit"></i>
                    </button>
                  @endcan
                </div>
              </td>
            </tr>
          @endforeach
        </x-tables.table>
      @endforeach

  </div>
</div>
  @include('admin.permissions.partials.create-permission-model')
  @include('admin.permissions.partials.edit-permission-model', ['permission' => $permission])
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
      const moduleSelect = addpermission.querySelector('[name="module"]');
      const descriptionInput = addpermission.querySelector('[name="description"]');
      const content = input.value.trim();
      const menu = document.getElementById("Model");
      if (!content) return;

      let options = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: content, module: moduleSelect.value, description: descriptionInput.value })
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
      const moduleSelect = editForm.querySelector('[name="module"]');
      const descriptionInput = editForm.querySelector('[name="description"]');
      const token = editForm.querySelector('input[name="_token"]').value;

      editButtons.forEach(button => {
        button.addEventListener('click', () => {
          const permissionID = button.dataset.id;
          const permissionName = button.dataset.name;
          const permissionModule = button.dataset.module;
          const permissionDescription = button.dataset.description;

          editForm.action = `/admin/permissions/${permissionID}`;
          nameInput.value = permissionName;
          moduleSelect.value = permissionModule;
          descriptionInput.value = permissionDescription;

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
          body: JSON.stringify({
            name: nameInput.value,
            module: moduleSelect.value,
            description: descriptionInput?.value || null
          })
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