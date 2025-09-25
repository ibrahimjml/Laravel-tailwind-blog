<div id="editModel" class="hidden fixed w-2/6 z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Edit Category.</p>
 <form id="editcategory" method="POST">
 @csrf
 @method("PUT")
 <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Category:
</label>
 <input  type="text" class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
  name="name" value="">
  @error('name')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
    
        <button type="submit" class="w-42 bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Edit</button>
    
    </form> 
<button id="closeEditModel" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
</div>
</div>

@push('scripts')
<script>
    // edit category
    const editButtons = document.querySelectorAll('.catsedit');
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

        editForm.action = `/admin/edit/category/${catId}`;
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