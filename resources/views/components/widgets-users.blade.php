<div class="flex-auto p-4 border-2 rounded-lg">
  <div class="flex flex-wrap">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-blueGray-400 uppercase font-bold text-xs">
      Users
      </h5>
      <span class="font-semibold text-xl text-blueGray-700">
      {{$users}}
      </span>
    </div>
    <div class="relative w-auto pl-4 flex-initial">
      <div
        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-gray-500">
        <i class="far fa-user"></i>
      </div>
    </div>
  </div>
</div>

<div class="flex-auto p-4 border-2 rounded-lg">
  <div class="flex flex-wrap">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-blueGray-400 uppercase font-bold text-xs">
        Blocked
      </h5>
      <span class="font-semibold text-xl text-blueGray-700">
      {{$blocked}}
      </span>
    </div>
    <div class="relative w-auto pl-4 flex-initial">
      <div
        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-gray-500">
        <i class="fa fa-ban"></i>
      </div>
    </div>
  </div>

</div>