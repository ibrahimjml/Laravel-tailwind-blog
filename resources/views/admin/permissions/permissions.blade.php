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
<div class="flex justify-between transform -translate-y-40 px-4">
  <div class="flex gap-3 w-fit">
    @include('admin.permissions.partials.filter')
  </div>
@can('permission.create')
  <button id="openPermissionModel"
        class="text-center ml-0 mr-2 sm:ml-auto w-fit   bg-gray-600  text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">
        create permission
  </button>
@endcan
</div>
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
              <td>{{ $permission->module ?? '--' }}</td>
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
                    <button data-name="{{ $permission->name }}"
                            data-id="{{ $permission->id }}"
                            data-module="{{$permission->module}}"
                            data-description="{{$permission->description}}"
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
<!-- create/edit models -->
  @include('admin.permissions.partials.create-permission-model')
  @include('admin.permissions.partials.edit-permission-model')
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
  </script>
  <!-- fetch create -->
  <script>  
    const addpermission = document.getElementById('addpermission');

    addpermission.addEventListener('submit', async (eo) => {
      eo.preventDefault();

      const input = addpermission.querySelector('input[name="name"]');
      const moduleNew = addpermission.querySelector('[name="module"]');
      const moduleSelect = addpermission.querySelector('#moduleOptions');
      const descriptionInput = addpermission.querySelector('[name="description"]');
      const submitButton = addpermission.querySelector('button[type="submit"]');
      const originalText = submitButton.textContent;
      const content = input.value.trim();
      const menu = document.getElementById("Model");

      if (!content) return;

       const formData = {
            name: content,
            module: moduleNew.value || moduleSelect.value,
            description: descriptionInput.value
        };
      let options = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      };
    try{
       // load button
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    const response = await  fetch(addpermission.action, options)
    const data = await response.json();

          if (data.added === true) {
            menu.classList.add('hidden');
            toastr.success(`Permission  Added`);
            addpermission.reset();
            window.location.reload();
          } else {
            toastr.error( 'create failed');
        }
    }catch (error) {
        console.error('Error:', error);
        toastr.error('Error creating permission');
    }finally{
       // Restore button state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    }
    });
</script>
  <!-- fetch edit -->
<script>
    const editButtons = document.querySelectorAll('.permissionedit');
    const editModal = document.getElementById('editModel');
    const route = "{{ route('admin.permissions.update', ':id') }}";
    const closeEditBtn = document.getElementById('closeEditModel');
    const editForm = document.getElementById('edittag');
    if (editModal && closeEditBtn && editForm) {
      const nameInput = editForm.querySelector('input[name="name"]');
      const moduleInput = editForm.querySelector('input[name="module"]');
      const moduleSelect = editForm.querySelector('select[name="module"]');
      const descriptionInput = editForm.querySelector('[name="description"]');
      const submitButton = editForm.querySelector('button[type=submit]');
      const originalText = submitButton.textContent;
      const token = editForm.querySelector('input[name="_token"]').value;

      editButtons.forEach(button => {
        button.addEventListener('click', () => {
          const permissionID = button.dataset.id;
          const permissionName = button.dataset.name;
          const permissionModule = button.dataset.module;
          const permissionDescription = button.dataset.description;

          editForm.action = route.replace(':id',permissionID);
          nameInput.value = permissionName;
          moduleInput.value = permissionModule;
          descriptionInput.value = permissionDescription;

          if ([...moduleSelect.options].some(opt => opt.value === permissionModule)) {
           moduleSelect.value = permissionModule;
            }
          
          editModal.classList.remove('hidden');
        });
      });

      editForm.addEventListener('submit', async(e) => {
        e.preventDefault();

       const newModule = moduleInput.value || moduleSelect.value;
       const formData = {
              name : nameInput.value,
              module : newModule,
             description : descriptionInput.value

          };

        let options = {
          method: 'PUT',
          headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify(formData)
        };
    try{
       // loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

      const response = await  fetch(editForm.action, options)
      const data = await response.json();
      
            if (data.edited === true) {
              toastr.success(data.message);
              editModal.classList.add('hidden');
              window.location.reload();
            } else {
            toastr.error( 'Update failed');
            window.location.reload();
             }
            }catch(error){
             console.error('Error:', error);
             toastr.error('Error updating permission');
            }finally{
             // Restore button state
             submitButton.disabled = false;
             submitButton.textContent = originalText;
            }
          
      });

      closeEditBtn.addEventListener('click', () => {
        editModal.classList.add('hidden');
      });
    }
</script>
  <!-- fetch delete -->
<script>
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
            } else {
            toastr.error( 'delete failed');
        }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    });
  </script>
@endpush