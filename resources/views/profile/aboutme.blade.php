<x-private-profile :user="$user" :status="$authFollowings[$user->id] ?? null">
@if(isset($user->aboutme))
  <p class="text-center text-lg font-semibold mt-6">{{$user->aboutme}}</p>
@else
<p class="text-center text-lg font-semibold mt-6">About me {{$user->username}} content goes here...</p>
@endif
</x-private-profile>