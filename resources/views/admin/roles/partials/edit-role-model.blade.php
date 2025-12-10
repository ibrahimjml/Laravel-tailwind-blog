<div id="editModel" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">
  
  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 id="editTitle" class="text-xl font-bold text-gray-800">Edit Role</h2>
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
    <form id="editrole" method="POST" class="space-y-6">
      @csrf
      @method("PUT")

        <!-- Form Fields -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role:</label>
          <input type="text" name="name" placeholder="type a role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
          @error('name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>
 <!-- Permissions -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Permissions:</label>
          <div id="editPermissions" class="mt-2 p-3 border border-gray-200 rounded-md max-h-52 overflow-y-auto space-y-4">
            @foreach ($permissions as $module => $modulePermissions)
              <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2">{{ $module }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                  @foreach ($modulePermissions as $permission)
                    <label class="flex items-center text-sm text-gray-600 font-normal">
                      <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                      {{ $permission->name }}
                    </label>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>

         <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Edit Role
            </button>
        </div>    
      </form>

  </div>
</div>
</div>