<div id="Model" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Create New Slide</h2>
      <button id="closeModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
      <form id="addslide" action="{{route('admin.slides.store')}}" method="POST" enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        <!-- Form Fields -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
            Image:
          </label>
          <input type="file"
            class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('image') border-red-500 @enderror"
            name="image">
          @error('image')
            <p class="text-red-500 text-xs italic mt-4">
              {{ $message }}
            </p>
          @enderror
        </div>
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title:</label>
          <input type="text" name="title" placeholder="type a title"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-red-500 @enderror">
          @error('title')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
          <input type="text" name="description" placeholder="type a description"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-500 @enderror">
          @error('description')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Link:</label>
          <input type="url" name="link" placeholder="type a link"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('link') border-red-500 @enderror">
          @error('link')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
        <select name="status" id="status"
          class="pl-3 w-36 appearance-none font-bold cursor-pointer  text-blueGray-500 border-2 text-sm rounded-lg p-2.5">
          @foreach (\App\Enums\SlidesStatus::cases() as $status)
            <option value="{{$status->value}}">{{$status->value}}</option>
          @endforeach
        </select>
        @error('status')
          <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
          </p>
        @enderror

        <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
          <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create
          </button>
        </div>
      </form>
    </div>
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
          } else {
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