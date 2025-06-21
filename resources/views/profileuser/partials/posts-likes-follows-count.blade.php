<div class="w-full lg:w-4/12 px-4 lg:order-1">
  <div class="flex justify-center py-4 lg:pt-4 pt-8">
    <div class="mr-4 p-3 text-center">
      <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{$postcount}}</span>
      <span class="text-sm text-blueGray-400">{{ Str::plural('Post', $postcount) }}</span>
    </div>
    <div class="mr-4 p-3 text-center">
      <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{$likescount}}</span>
      <span class="text-sm text-blueGray-400">{{ Str::plural('Like', $likescount) }}</span>
    </div>
    <div class="lg:mr-4 p-3 text-center">
      <span
        id="followers-count"
        class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{$user->followers()->count()}}</span>
      <span class="text-sm text-blueGray-400">Followers</span>
    </div>
    <div class="lg:mr-4 p-3 text-center">
      <span
        class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{$user->followings()->count()}}</span>
      <span class="text-sm text-blueGray-400">Following</span>
    </div>
  </div>
</div>