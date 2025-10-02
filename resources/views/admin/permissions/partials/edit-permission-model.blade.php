@php
  use App\Enums\PermissionModule;
@endphp
<div id="editModel"
  class="hidden fixed w-2/6 z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Edit permission .</p>
    <form id="edittag" method="POST">
      @csrf
      @method("PUT")
      <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
        Name:
      </label>
      <input type="text"
        class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
        name="name">
      @error('name')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
      <!-- type module or select -->
      <label for="module" class="mt-2 block text-slate-200 text-sm mb-1 font-bold">
        Module (type new or select existing):
      </label>
      <input  id="module" name="module"
        class="block w-72 rounded-lg p-2 border-2 text-white bg-transparent @error('module') border-red-500 @enderror"
        placeholder="Type new module">
    <label for="module" class="mt-2 block text-slate-200 text-sm mb-1 font-bold">
        or select:
      </label>
        <select name="module" id="module" class="block w-72 rounded-lg p-2 border-2 text-white bg-gray-700">
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
      <!-- /type module or select -->
      <label for="description" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Description :</label>
      <input type="text"
        class="block  w-72 rounded-lg p-2 border-2 text-white  bg-transparent @error('description') border-red-500 @enderror"
        name="description" placeholder="type a description">
      @error('description')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
      @enderror
      <button type="submit"
        class="w-42 bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Edit</button>

    </form>
    <button id="closeEditModel"
      class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
  </div>
</div>