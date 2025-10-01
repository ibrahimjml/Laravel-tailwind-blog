<div id="Model" class="hidden fixed w-3/6 z-[20] py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class=" w-[70%] mx-auto">
    <p class="text-xl text-gray-100">Create New Slide.</p>
 <form id="addslide" action="{{route('admin.slides.store')}}" method="POST" enctype="multipart/form-data">
 @csrf
 @method("POST")
 <label for="image" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Image:
</label>
 <input  type="file" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('image') border-red-500 @enderror"
  name="image">
  @error('image')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
   
 <label for="title" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Title:
</label>
 <input  type="title" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('title') border-red-500 @enderror"
  name="title">
  @error('title')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
   <label for="description" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Description:
</label>
 <input  type="description" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('description') border-red-500 @enderror"
  name="description">
  @error('description')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
   <label for="link" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Link:
</label>
 <input  type="url" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('link') border-red-500 @enderror"
  name="link">
  @error('link')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
   <label for="status" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Status:
</label>
 <select name="status" id="status" class="pl-3 w-36 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5">
  @foreach (\App\Enums\SlidesStatus::cases() as $status)
  <option value="{{$status->value}}">{{$status->value}}</option>
  @endforeach
 </select>
  @error('status')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror

<button type="submit" class="block w-42 bg-green-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Add Slide</button>
</form> 
<button id="closeModel" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
</div>
</div>
@push('scripts')
<script>
  const addSlide = document.getElementById('addslide');

    addSlide.addEventListener('submit', (eo) => {
      eo.preventDefault();

      const image = addSlide.querySelector('input[name="image"]');
      const title = addSlide.querySelector('[name="title"]');
      const description = addSlide.querySelector('[name="description"]');
      const link = addSlide.querySelector('[name="link"]');
      const status = addSlide.querySelector('[name="status"]');
      const menu = document.getElementById("Model");

     const formData = new FormData();
    formData.append('image', image.files[0]); 
    formData.append('title', title.value);
    formData.append('description', description.value);
    formData.append('link', link.value);
    formData.append('status', status.value);

      let options = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        },
        body: formData 
      };

      fetch(addSlide.action, options)
        .then(response => response.json())
        .then(data => {
          if (data.created === true) {
            menu.classList.add('hidden');
            toastr.success(data.message);
            addSlide.reset();
            location.reload();
          }else {
            if (data.errors) {
                Object.values(data.errors).forEach(errorArray => {
                    errorArray.forEach(error => toastr.error(error));
                });
            }
        }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
</script>
@endpush