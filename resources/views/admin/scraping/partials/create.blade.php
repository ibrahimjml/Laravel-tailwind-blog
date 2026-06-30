<div id="SourceModel" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Create Source</h2>
      <button id="closeModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
      <form id="addSource" action="{{route('admin.scraping.sources.store')}}" method="POST"  class="space-y-6">
        @csrf
        <!-- source name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Source Name:</label>
          <input type="text" name="name" placeholder="e.g. BBC"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <p data-error-for="name" class="hidden text-red-500 text-xs italic mt-2"></p>
        </div>
          <!-- Source link -->
          <div>
          <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Website or RSS Url:</label>
          <input type="url" name="url" placeholder="https://"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <p data-error-for="url" class="hidden text-red-500 text-xs italic mt-2"></p>
        </div>
          <!-- Source favicon url -->
          <div>
          <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Favicon Url: (optional)</label>
          <input type="url" name="favicon_url" placeholder="https://"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <p data-error-for="favicon_url" class="hidden text-red-500 text-xs italic mt-2"></p>
        </div>
        <div class="flex justify-between items-center gap-4">
        <!-- Data type -->
        <div>
          <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Data Type:</label>
          <select id="sourceType" name="type" class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5">
            @foreach(\App\Enums\ScrapingType::cases() as $type)
              <option value="{{ $type->value }}">{{ $type->label() }}</option>
            @endforeach
          </select>
          <p data-error-for="type" class="hidden text-red-500 text-xs italic mt-2"></p>
        </div>
        <div>
          <!-- Max Links per Crawl -->
          <div>
          <label for="max_links" class="block text-sm font-medium text-gray-700 mb-1">Max Links per crawl:</label>
          <input type="number" name="max_links" step="1" min="1"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <p data-error-for="max_links" class="hidden text-red-500 text-xs italic mt-2"></p>
        </div>
        </div>
        </div>
        <div>
          <!-- Max Age -->
          <div>
          <label for="max_age_hours" class="block text-sm font-medium text-gray-700 mb-1">Auto Delete After (hr):</label>
          <input type="number" name="max_age_hours" step="1" min="1"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <p data-error-for="max_age_hours" class="hidden text-red-500 text-xs italic mt-2"></p>
        </div>
        </div>
        <!-- skip no image -->
         <div class="p-2 rounded-lg border border-gray-300 w-fit flex items-center gap-4">
           <label for="skip_no_image">skip no image?</label>
           <input type="hidden" name="skip_no_image" value="0">
           <x-toggle name="skip_no_image" value="1" :checked="old('skip_no_image') === true"/>
           <p data-error-for="skip_no_image" class="hidden text-red-500 text-xs italic mt-2"></p>
         </div>
        <!-- skip no category -->
         <div class="p-2 rounded-lg border border-gray-300 w-fit flex items-center gap-4">
           <label for="skip_no_category">skip no category?</label>
           <input type="hidden" name="skip_no_category" value="0">
           <x-toggle name="skip_no_category" value="1" :checked="old('skip_no_category') === true"/>
           <p data-error-for="skip_no_category" class="hidden text-red-500 text-xs italic mt-2"></p>
         </div>
        <!-- status -->
         <div class="p-2 rounded-lg border border-gray-300 w-fit flex items-center gap-4">
           <label for="is_active">Is Active?</label>
           <input type="hidden" name="is_active" value="0">
           <x-toggle name="is_active" value="1" :checked="old('is_active') === true"/>
           <p data-error-for="is_active" class="hidden text-red-500 text-xs italic mt-2"></p>
         </div>
        <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
          <button id="submitSource" type="submit"
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

  const addSource = document.getElementById('addSource');
  const submitSource = document.getElementById('submitSource');

  function clearSourceErrors() {
    addSource.querySelectorAll('[data-error-for]').forEach((element) => {
      element.textContent = '';
      element.classList.add('hidden');
    });
  }

  function showSourceErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
      const errorElement = addSource.querySelector(`[data-error-for="${field}"]`);

      if (errorElement) {
        errorElement.textContent = messages[0];
        errorElement.classList.remove('hidden');
      }
    });
  }

  addSource.addEventListener('submit', async (event) => {
    event.preventDefault();
    clearSourceErrors();
    submitSource.disabled = true;
    submitSource.textContent = 'Creating...';

    try {
      const response = await fetch(addSource.action, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: new FormData(addSource),
      });

      const data = await response.json();

      if (!response.ok) {
        if (response.status === 422 && data.errors) {
          showSourceErrors(data.errors);
          return;
        }

        throw new Error(data.message || 'Unable to create Source.');
      }

      if (window.toastr) {
        toastr.success(data.message);
      }

      addSource.reset();
      document.getElementById('SourceModel').classList.add('hidden');
      window.location.reload();
    } catch (error) {
      if (window.toastr) {
        toastr.error(error.message);
      } else {
        alert(error.message);
      }
    } finally {
      submitSource.disabled = false;
      submitSource.textContent = 'Create';
    }
  });
</script>
@endpush
