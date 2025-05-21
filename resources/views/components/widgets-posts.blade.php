<div class="flex-auto p-4 border-2 bg-white rounded-lg">
  <div class="flex flex-wrap">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-blueGray-400 uppercase font-bold text-xs">
        Posts
      </h5>
      <span class="font-semibold text-xl text-blueGray-700">
        {{$posts}}
      </span>
    </div>
    <div class="relative w-auto pl-4 flex-initial">
      <div
        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-yellow-500">
        <i class="far fa-image"></i>
      </div>

    </div>
  </div>
</div>
<div class="flex-auto p-4 border-2 bg-white rounded-lg">
  <div class="flex flex-wrap">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-blueGray-400 uppercase font-bold text-xs">
        Likes
      </h5>
      <span class="font-semibold text-xl text-blueGray-700">
        {{$likes}}
      </span>
    </div>
    <div class="relative w-auto pl-4 flex-initial">
      <div
        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
        <i class="far fa-heart"></i>
      </div>
    </div>
  </div>

</div>
<div class="flex-auto p-4 border-2 bg-white rounded-lg">
  <div class="flex flex-wrap">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-blueGray-400 uppercase font-bold text-xs">
        Comments
      </h5>
      <span class="font-semibold text-xl text-blueGray-700">
        {{$comments}}
      </span>
    </div>
    <div class="relative w-auto pl-4 flex-initial">
      <div
        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-green-500">
        <i class="far fa-comment"></i>
      </div>
    </div>
  </div>

</div>
<div class="flex-auto p-4 border-2 bg-white rounded-lg">
  <div class="flex flex-wrap">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-blueGray-400 uppercase font-bold text-xs">
        Tags
      </h5>
      <span class="font-semibold text-xl text-blueGray-700">
        {{$hashtags}}
      </span>
    </div>
    <div class="relative w-auto pl-4 flex-initial">
      <div
        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
        <i class="fas fa-tag"></i>
      </div>
    </div>
  </div>

</div>