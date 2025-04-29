<div class="flex flex-col">
  <p class="text-lg font-bold ">posts</p>
  {{-- count posts --}}
  <p class="text-lg font-bold text-center">{{$postcount}}</p>
</div>

<div class="flex  w-30 gap-5">
{{-- likes count --}}
<div class="flex flex-col">
<p class="text-lg font-bold text-center">Total likes</p>
<p class="text-lg font-bold text-center">{{$likescount}}</p>
</div>
<div class="flex flex-col">
{{-- followers counts --}}
  <p class="text-lg font-bold text-center">Followers</p>
  <p id="followers-count" class="text-lg font-bold text-center">{{$user->followers()->count()}}</p>
</div>
<div class="flex flex-col">
{{-- followings counts --}}
      <p class="text-lg font-bold text-center">Following</p>
      <p  class="text-lg font-bold text-center">{{$user->followings()->count()}}</p>
    </div>
</div>