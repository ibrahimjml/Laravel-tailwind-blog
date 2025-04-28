@if ($notification->data['type'] === 'follow')
@php
$avatarUrl = $notification->data['follower_avatar_url'];
$username = $notification->data['follower_username'];
@endphp
@elseif($notification->data['type'] === 'like')
@php
$avatarUrl = $notification->data['user_avatar'];
$username = $notification->data['user_username'];
@endphp
@elseif($notification->data['type'] === 'Postcreated')
@php
$avatarUrl = $notification->data['postedby_avatar'];
$username = $notification->data['postedby_username'];
@endphp
@elseif($notification->data['type'] === 'comments')
@php
  $avatarUrl = $notification->data['commenter_avatar'];
  $username = $notification->data['commenter_username'];
@endphp
@elseif($notification->data['type'] === 'reply')
@php
  $avatarUrl = $notification->data['replier_avatar'];
  $username = $notification->data['replier_username'];
@endphp
@elseif($notification->data['type'] === 'viewedprofile')
@php
  $avatarUrl = $notification->data['viewer_avatar'];
  $username = $notification->data['viewer_username'];
@endphp
@endif