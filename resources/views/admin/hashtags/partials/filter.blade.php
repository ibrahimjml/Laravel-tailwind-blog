    @php
      $statuses = collect(\App\Enums\TagStatus::cases());
    @endphp
     <form action="{{ url()->current() }}" method="GET">
      <div class=" w-fit z-30">
        <label for="sort" class="text-lg text-white font-bold">status :</label>
        <select id="sort" name="sort"
        class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2"
        onchange="this.form.submit()" onchange="this.form.submit()">
        <option value="" {{ request('sort') === null ? 'selected' : '' }}>All</option>
        @foreach ($statuses as $status )
        <option value="{{$status->value}}" {{ request('sort') === $status->value ? 'selected' : '' }}>{{$status->value}}</option>
        @endforeach
        </select>
        <!-- Custom white arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <svg class="w-4 h-4 text-blueGray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" />
          </svg>
          </div>
      </div>
      </form>