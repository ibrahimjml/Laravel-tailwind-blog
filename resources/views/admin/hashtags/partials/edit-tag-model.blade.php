<div id="editModel" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Edit Hashtag</h2>
      <button id="closeEditModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
      <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
 <form id="edittag" method="POST" class="space-y-6">
 @csrf
 @method("PUT")
<!-- Form Fields -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Hashtag:</label>
          <input type="text" name="name"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
          @error('name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
<label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status:</label>      
<select name="status" id="status" class="pl-3 w-36 appearance-none font-bold cursor-pointer text-blueGray-500 border-2 text-sm rounded-lg p-2.5">
@foreach (\App\Enums\TagStatus::cases() as $status )
<option value="{{$status->value}}">{{$status->name}}</option>
@endforeach  
</select>     
<button type="submit" class="block w-42 bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Edit</button>
    
</form> 
</div>
</div>
</div>

@push('scripts')
<script>
    // edit hashtag
  const editButtons = document.querySelectorAll('.tagsedit');
  const route = "{{ route('admin.tags.update', ':id') }}";
  const editModal = document.getElementById('editModel');
  const closeEditBtn = document.getElementById('closeEditModel');
  const editForm = document.getElementById('edittag');

  if (editModal && closeEditBtn && editForm) {
    const nameInput = editForm.querySelector('input[name="name"]');
    const statusInput = editForm.querySelector('[name="status"]');
    const token = editForm.querySelector('input[name="_token"]').value;

    editButtons.forEach(button => {
      button.addEventListener('click', () => {
        const tagId = button.dataset.id;
        const tagName = button.dataset.name;
        const tagStatus = button.dataset.status;

        editForm.action = route.replace(':id', tagId);
        nameInput.value = tagName;
        statusInput.value = tagStatus;

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
        body: JSON.stringify({ name: nameInput.value , status: statusInput.value })
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
</script>
@endpush