<main class=" relative lg:w-4/6 w-full  lg:mx-auto mx-0 mt-5">

  <div>
    <form id="profileVisibilityForm" action="{{ route('profile.visibility') }}" method="POST">
      @csrf
      <input type="hidden" name="visibility" value="{{ $user->profile->is_public ? 1 : 0 }}" />
    </form>
    <x-toggle :checked="!$user->profile->is_public" label="Private account" onchange="
        const form = document.getElementById('profileVisibilityForm');
        form.querySelector('[name=visibility]').value = this.checked ? 0 : 1;
        form.submit();" />
    <p class="text-black/40 mt-4 text-sm">
      When your account is public, your profile and posts can be seen by anyone.
    </p>
    <p class="text-black/40 mt-2 text-sm">
      When your account is private, only followers you approve can see your profile home, activities, and about pages.
    </p>
  </div>


</main>