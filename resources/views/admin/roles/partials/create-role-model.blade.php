<div id="Model"
  class="hidden fixed w-2/6 z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Create New Role.</p>
    <form id="addrole" action="{{route('admin.roles.store')}}" method="POST">
      @csrf
      <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
        Role:
      </label>
      <input type="text"
        class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
        name="name" placeholder="type a tag">
      @error('name')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
      <div class="flex flex-col h-52 overflow-y-auto">
        @foreach ($permissions as $module => $modulePermissions)
          <div class="mb-4">
            <h3 class="text-white font-bold mb-2">{{ $module }}</h3>
            <div class="flex flex-wrap gap-2">
              @foreach ($modulePermissions as $permission)
                <label class="text-white mr-4">
                  <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                  {{ $permission->name }}
                </label>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
      <button type="submit"
        class="w-42 bg-green-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Add</button>
    </form>
    <button id="closeModel"
      class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
  </div>
</div>