<div class="px-4 md:px-10 mx-auto w-full">
  <div class="flex flex-wrap gap-2">
    <x-widgets-posts :posts="$post" :hashtags="$hashtags" :likes="$likes" :comments="$comments" />
    <x-widgets-users :users="$user" :blocked="$blocked" />
  </div>
</div>