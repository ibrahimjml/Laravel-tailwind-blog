@if($isPrivate())
<div>
    <span class="h-16 w-16 px-5 py-5 flex place-content-center rounded-full border-2 border-black/50">
        <i class="fas fa-lock text-black/50"></i>
    </span>
    <p class="text-md text-left text-black/50 font-semibold mt-2">
        {{ $user->name }}'s profile is private.
    </p>
</div>
@else
{{ $slot }}
@endif
