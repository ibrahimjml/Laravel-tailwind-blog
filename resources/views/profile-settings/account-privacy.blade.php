<main class=" relative lg:w-4/6 w-full  lg:mx-auto mx-0 mt-5">

  <div>
    <form id="profileVisibilityForm" action="{{ route('profile.visibility') }}" method="POST">
      @csrf
      <input type="hidden" name="visibility" value="{{ $user->profile->is_public ? 1 : 0 }}" />
    </form>
    <label class="inline-flex items-center cursor-pointer">
      <input type="checkbox" 
        class="sr-only peer"
        onchange="document.getElementById('profileVisibilityForm').querySelector('[name=visibility]').value = this.checked ? 0 : 1;
               document.getElementById('profileVisibilityForm').submit();"   
         @checked(!$user->profile->is_public)>
      <div class="relative w-9 h-5 bg-black/20 rounded-full peer peer-checked:bg-black
           peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-soft
           after:content-[''] after:absolute after:top-[2px] after:left-[2px]
           after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all
           peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full">
      </div>
      <span class="ml-3 text-sm font-medium text-gray-900 select-none">Private account</span>
    </label>
    <p class="text-black/40 mt-4 text-sm">
      When your account is public, your profile and posts can be seen by anyone.
    </p>
    <p class="text-black/40 mt-2 text-sm">
      When your account is private, only followers you approve can see your profile home, activities, and about pages.
    </p>
  </div>


</main>