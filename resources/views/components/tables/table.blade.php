<div class="rounded-t mb-0 px-4 py-3 border-0 w-fit">
  <div class="flex flex-wrap items-center">
    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
      <h3 class="font-semibold text-lg text-blueGray-500">
        {{ $title ?? 'Admin Table' }}
      </h3>
    </div>
  </div>
</div>

<div class="w-full overflow-x-auto">
  <table id="{{$id}}"  class="min-w-max table-auto w-full">
    <thead class="text-left px-4">
      <tr class="bg-blueGray-200 text-blueGray-500">
        @foreach($headers as $header)
          <th class="p-2">{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody class="text-left">
      {{ $slot }}
    </tbody>
  </table>
</div>
