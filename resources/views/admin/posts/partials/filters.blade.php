<div class="flex items-center flex-wrap gap-4 ml-3">
  <!-- Sort & Featured -->
  <div class="flex gap-2 items-center">
    <!-- Sort Form -->
    <form action="{{ url()->current() }}" method="GET">
      <div class="relative w-full">
        <select id="sort" name="sort"
          class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5"
          onchange="this.form.submit()" onchange="this.form.submit()">
          <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
          <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
          @foreach (\App\Enums\PostStatus::cases() as $status)
          <option value="{{$status->value}}" {{request('sort') === $status->value ? 'selected' : ''}}>{{$status->name}}</option>
          @endforeach
        </select>
        <!-- Custom white arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" />
          </svg>
        </div>
      </div>
    </form>

    <!-- Featured Checkbox -->
    <div class="bg-blueGray-200 rounded-md p-2 h-10 flex items-center">
      <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-1">
        <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }}
          onchange="this.form.submit()" class="rounded-full w-4 h-4">
        <label class="text-blueGray-500 font-semibold" for="featured">Featured</label>
      </form>
    </div>
    <!-- Reported Checkbox -->
    <div class="bg-blueGray-200 rounded-md p-2 h-10 flex items-center">
      <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-1">
        <input type="checkbox" name="reported" value="1" {{ request('reported') ? 'checked' : '' }}
          onchange="this.form.submit()" class="rounded-full w-4 h-4">
        <label class="text-blueGray-500 font-semibold" for="reported">Reported</label>
      </form>
    </div>
  </div>

</div>