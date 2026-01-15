<div id="Model" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

    <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Create New Hashtag</h2>
      <button id="closeModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
      <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
 <form id="addtag" action="{{route('admin.tags.create')}}" method="POST" class="space-y-6">
 @csrf
 @method("POST")
  <!-- Form Fields -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Hashtag:</label>
          <input type="text" name="name" placeholder="type a tag" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
          @error('name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
<label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
<select name="status" id="status" class="pl-3  appearance-none font-bold cursor-pointer  text-blueGray-500 border-2 text-sm rounded-lg p-2.5">
@foreach (\App\Enums\TagStatus::cases() as $status )
<option value="{{$status->value}}">{{$status->name}}</option>
@endforeach  
</select>    
  <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Create 
            </button>
        </div>    
</form> 
</div>
</div>
</div>

@push('scripts')
<script>
    const addtag = document.getElementById('addtag');
  if (addtag) {
    addtag.addEventListener('submit', (eo) => {
      eo.preventDefault();

      const input = addtag.querySelector('input[name="name"]');
      const inputStatus = addtag.querySelector('[name="status"]');
      const content = input.value.trim();
      const status = inputStatus.value ?? 'active';
      const menu = document.getElementById("Model");
      const table = document.getElementById('tabletags');
      if (!content) return;

      let options = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ 
                name: content , 
                status: status
           })
      };

      fetch(addtag.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.added === true) {
            menu.classList.add('hidden');
            toastr.success(`Tag ${data.hashtag} Added`);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  }
</script>
@endpush