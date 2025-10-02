<div id="Model"
  class="hidden fixed w-2/6 z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Create New Permission.</p>
    <form id="addpermission" action="{{route('admin.permissions.store')}}" method="POST">
      @csrf
      <!-- type permission  -->
      <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
        Permission:
      </label>
      <input type="text"
        class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
        name="name" placeholder="type a permission">
      @error('name')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
      <!-- /type permission -->
      <!-- type module or select -->
      <label for="module" class="mt-2 block text-slate-200 text-sm mb-1 font-bold">
        Module (type new or select existing):
      </label>
      <input list="moduleOptions" id="module" name="module"
        class="block w-72 rounded-lg p-2 border-2 text-white bg-transparent @error('module') border-red-500 @enderror"
        placeholder="Type or select module">
      <datalist id="moduleOptions">
        @foreach ($modules as $module)
          <option value="{{$module}}">
        @endforeach
      </datalist>
      @error('module')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
        <!-- /type module or select -->
        <!-- description -->
      <label for="description" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Description :</label>
      <input type="text"
        class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('description') border-red-500 @enderror"
        name="description" placeholder="type a description">
      @error('description')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
        <!-- /description -->
      <button type="submit"
        class="block w-42 bg-green-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Add</button>

    </form>
    <button id="closeModel"
      class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
  </div>
</div>