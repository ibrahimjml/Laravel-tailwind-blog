<div id="Model" class="hidden fixed w-2/6 z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Create New Hashtag.</p>
 <form id="addtag" action="{{route('admin.tags.create')}}" method="POST">
 @csrf
 @method("POST")
 <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Hashtag:
</label>
 <input  type="text" class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
  name="name" placeholder="type a tag">
  @error('name')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
<label for="status" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">Status:</label>
<select name="status" id="status" class="pl-3  appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5">
@foreach (\App\Enums\TagStatus::cases() as $status )
<option value="{{$status->value}}">{{$status->name}}</option>
@endforeach  
</select>    
<button type="submit" class="block w-42 bg-green-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Add</button>
    
</form> 
<button id="closeModel" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
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
          'Content-Type': 'application/json'
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