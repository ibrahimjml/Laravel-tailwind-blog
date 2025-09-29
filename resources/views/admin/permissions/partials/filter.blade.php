<div class="flex gap-2 items-center">
  <!-- Sort by latest oldest -->
  <x-forms.filter-form exclude="sort">
    <div class="relative w-full">
      <select id="sort" name="sort"
        class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5"
        onchange="this.form.submit()">
        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
        <option value="module" {{ request('sort') === 'module' ? 'selected' : '' }}>Module A-Z</option>
      </select>
      <!-- Custom white arrow -->
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
  </x-forms.filter-form>
  <!-- Sort by module -->
  <x-forms.filter-form exclude="module">
    <div class="relative w-full">
      <select id="module" name="module"
        class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5"
        onchange="this.form.submit()">
         <option value="">All Modules</option>
        @foreach (\App\Enums\PermissionModule::cases() as $module)
          <option value="{{$module->value}}" {{request('module') === $module->value ? 'selected' : ''}}>
            {{$module->name}}
          </option>
        @endforeach
      </select>
      <!-- Custom white arrow -->
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
  </x-forms.filter-form>
  <!-- Clear Filters  -->
  @if(request()->anyFilled(['search', 'sort', 'module']))
    <a href="{{ url()->current() }}"
      class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center gap-2">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
      Clear Filters
    </a>
  @endif
</div>