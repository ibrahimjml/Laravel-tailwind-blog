<div id="editModel"  class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Edit Permission</h2>
      <button id="closeEditModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
        @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-700">
          <ul class="list-disc ml-5">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

    <form id="edittag" method="POST" class="space-y-6">
      @csrf
      @method("PUT")
      <!-- Form Fields -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Permission:</label>
          <input type="text" name="name" placeholder="type a permission" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
          @error('name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
      <!-- type module or select -->
      <label for="module" class="block text-sm font-medium text-gray-700 mb-1">
        Module (type new or select existing):
      </label>
      <input  id="module" name="module"
        class="block w-72 rounded-lg p-2 border-2 text-white bg-transparent @error('module') border-red-500 @enderror"
        placeholder="Type new module">
    <label for="module" class="block text-sm font-medium text-gray-700 mb-1">
        or select:
      </label>
        <select name="module" id="module" class="block w-72 rounded-lg p-2 border-2 ">
        <option value="">None</option>
        @foreach ($modules as $module)
          <option value="{{ $module }}">{{ $module }}</option>
        @endforeach>
      </select>
      @error('module')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
      <!-- description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
          <input type="text" name="description" placeholder="type a description" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-500 @enderror">
          @error('description')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
         <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Edit Permission
            </button>
        </div>
    </form>
  </div>
</div>
</div>