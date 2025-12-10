<div id="editModel" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Edit Category</h2>
      <button id="closeEditModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
      <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
 <form id="editcategory" method="POST" class="space-y-6">
 @csrf
 @method("PUT")
  <!-- Form Fields -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category:</label>
          <input type="text" name="name"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
          @error('name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
    
<!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Edit 
            </button>
        </div>       
    </form> 
</div>
</div>
</div>

@push('scripts')
<script>
    // edit category
  const editButtons = document.querySelectorAll('.catsedit');
  const route = "{{ route('admin.categories.update', ':id') }}";
  const editModal = document.getElementById('editModel');
  const closeEditBtn = document.getElementById('closeEditModel');
  const editForm = document.getElementById('editcategory');

  if (editModal && closeEditBtn && editForm) {
    const nameInput = editForm.querySelector('input[name="name"]');
    const token = editForm.querySelector('input[name="_token"]').value;

    editButtons.forEach(button => {
      button.addEventListener('click', () => {
        const catId = button.dataset.id;
        const catName = button.dataset.name;

        editForm.action = route.replace(':id',catId);
        nameInput.value = catName;

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
          if (data.updated === true) {
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