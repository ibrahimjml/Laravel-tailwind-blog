<div id="editModel" class="hidden fixed w-2/6 z-[20] py-8 left-[50%] top-[50%] transform -translate-x-1/2 -translate-y-1/2 items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">
  <div class="ml-6">
    <p id="editTitle" class="text-xl text-gray-100">Edit role</p>

    <form id="editrole" method="POST">
      @csrf
      @method("PUT")

      <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold">Role:</label>
      <input type="text" name="name" class="block w-72 rounded-lg p-2 border-2 text-white bg-transparent @error('name') border-red-500 @enderror">
      @error('name')
        <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
      @enderror

      <label class="mt-4 block text-slate-200 font-bold">Permissions:</label>
      <div id="editPermissions" class="flex flex-col h-52 overflow-y-auto">
        @foreach ($permissions as $permission)
        <label class="mr-4 text-white">
          <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="mr-1">
          {{ $permission->name }}
        </label>
        @endforeach
      </div>

      <button type="submit" class="w-42 bg-blue-700 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6">Edit</button>
    </form>

    <button id="closeEditModel" class="border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
  </div>
</div>
