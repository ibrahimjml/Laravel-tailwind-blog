<div class="w-full lg:w-4/12 px-4 lg:order-1">
  <div class="flex justify-center py-4 lg:pt-4 pt-8">
    <div 
    class="mr-4 p-3 text-center"
    title="{{ Number::format($postcount) }} {{ Str::plural('Post', $postcount) }}"
    >
      <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
        {{Number::format($postcount)}}
      </span>
      <span  class="text-sm text-blueGray-400"  >
      {{ Str::plural('Post', $postcount) }}
    </span>
    </div>
    <div 
    class="mr-4 p-3 text-center"
    title="{{ Number::format($likescount) }} {{ Str::plural('Like', $likescount) }}"
    >
      <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
        {{Number::abbreviate($likescount)}}
      </span>
      <span class="text-sm text-blueGray-400">
        {{ Str::plural('Like', $likescount) }}
      </span>
    </div>
    <div 
    class="lg:mr-4 p-3 text-center"
    title="{{ Number::format($user->followers_count) }} {{ Str::plural('Follower', $user->followers_count) }}"
    >
      <span
        id="followers-count"
        class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{Number::abbreviate($user->followers_count)}}</span>
      <span  class="text-sm text-blueGray-400">
    {{ Str::plural('Follower', $user->followers_count) }}
      </span>
    </div>
    <div 
    class="lg:mr-4 p-3 text-center"
    title="{{ Number::format($user->followings_count) }} Following"
    >
      <span
        class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{Number::abbreviate($user->followings_count)}}</span>
      <span class="text-sm text-blueGray-400">Following</span>
    </div>
  </div>
</div>