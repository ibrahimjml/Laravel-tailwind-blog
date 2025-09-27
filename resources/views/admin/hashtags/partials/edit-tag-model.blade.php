<div id="editModel" class="hidden fixed w-2/6 z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Edit Hashtag.</p>
 <form id="edittag" method="POST">
 @csrf
 @method("PUT")
 <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Hashtag:
</label>
 <input  type="text" class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
  name="name" value="">
  @error('name')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
<label for="status" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">Status:</label>      
<select name="status" id="status" class="pl-3 w-36 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5">
@foreach (\App\Enums\TagStatus::cases() as $status )
<option value="{{$status->value}}">{{$status->name}}</option>
@endforeach  
</select>     
<button type="submit" class="block w-42 bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Edit</button>
    
</form> 
<button id="closeEditModel" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
</div>
</div>

@push('scripts')
<script>
    // edit hashtag
    const editButtons = document.querySelectorAll('.tagsedit');
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

        editForm.action = `/admin/edit/tag/${tagId}`;
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