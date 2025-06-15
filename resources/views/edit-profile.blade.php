<x-layout>


  <div class="container mx-auto pt-[40px]">
    <h1 class=" text-3xl font-bold text-center py-5 capitalize">edit profile</h1>
  </div>

  <div class="flex flex-col mx-auto pt-5 w-[50%] sm:w-[40%]">
    <div class="flex flex-wrap">
      <div>
        <h2 class="font-bold">Profile Information</h2>
        <p class="text-sm text-gray-600 mb-3">Update your account's profile information and email address.</p>
      </div>
    </div>
        <!-- name -->
    <form action="{{route('edit.name',$user->id)}}" method="POST">
      @csrf
      @method('PUT')

      <div class="flex flex-wrap">
        <label for="name" class=" text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Name:
        </label>

        <input id="name" type="text"
          class="rounded-sm p-2 border-2 form-input w-full @error('name')  border-red-500 @enderror" name="name"
          value="{{ old('name', $user->name) }}" required autocomplete="name">

        @error('name')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
        @can('update', $user)
      <div class=" w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update name</button>
      </div>
    @endcan
      </div>
    </form>
        <!-- email -->
    <form action="{{route('edit.email',$user->id)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap mt-2">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          E-Mail Address:
        </label>

        <input id="email" type="email"
          class="rounded-sm p-2 border-2 form-input w-full @error('email') border-red-500 @enderror" name="email"
          value="{{ old('email', $user->email) }}" required autocomplete="email">
        @if(auth()->user()->email_verified_at == null)
      <p class="text-red-500 text-xs italic mt-4">
        Your email is not verified,please verify your email
      </p>
    @endif
        @error('email')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
        @can('update', $user)
      <div class=" w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update email</button>
      </div>
    @endcan
      </div>
    </form>
        <!-- phone -->
    <form id="phone-form" action="{{route('edit.phone',$user->id)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap mt-2">
        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Phone:
        </label>

        <input id="phone" type="tel"
          class="w-full rounded-sm p-2 border-2 form-input @error('phone') border-red-500 @enderror" name="phone"
          value="{{ old('phone', $user->phone ?? '') }}" required autocomplete="tel">

        @error('phone')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
        @can('update', $user)
      <div class=" w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update phone</button>
      </div>
    @endcan
      </div>
    </form>
    <!-- bio -->
    <form action="{{route('add.bio',$user->id)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap mt-2">
        <label for="bio" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          bio:
        </label>

        <input id="bio" type="text"
          class="rounded-sm p-2 border-2 form-input w-full @error('bio') border-red-500 @enderror" name="bio"
          value="{{ old('bio', $user->bio) }}" required autocomplete="bio">

        @error('bio')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
        @can('update', $user)
      <div class=" w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update</button>
      </div>
    @endcan
      </div>
    </form>
  <!-- social links -->
    <form action="{{route('add.sociallinks',$user)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap mt-2">
        <label for="github" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Github:
        </label>

        <input id="github" type="url"
          class="rounded-sm p-2 border-2 form-input w-full @error('github') border-red-500 @enderror" name="github"
          value="{{ old('github', $user->github) }}"  autocomplete="github">

        @error('github')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
    <label for="linkedin" class="block text-gray-700 text-sm font-bold mt-2 mb-2 sm:mb-4">
          linkedin:
        </label>

        <input id="linkedin" type="url"
          class="rounded-sm p-2 border-2 form-input w-full @error('linkedin') border-red-500 @enderror" name="linkedin"
          value="{{ old('linkedin', $user->linkedin) }}"  autocomplete="linkedin">

        @error('linkedin')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
      <label for="twitter" class="block text-gray-700 text-sm font-bold mt-2 mb-2 sm:mb-4">
          twitter:
        </label>

        <input id="twitter" type="url"
          class="rounded-sm p-2 border-2 form-input w-full @error('twitter') border-red-500 @enderror" name="twitter"
          value="{{ old('twitter', $user->twitter) }}"  autocomplete="twitter">

        @error('twitter')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
@can('update', $user)
      <div class="block w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update</button>
      </div>
    @endcan
      </div>
    </form>
    <!-- custom links -->
    <form action="{{route('add.customlinks',$user)}}" method="POST">
      @csrf
      @method('PUT')
<label for="socail-links" class="block text-gray-700 text-sm font-bold mt-2 mb-2 sm:mb-4">Custom Links</label>
<div id="custom-links">
    @foreach(old('social_links', $user->socialLinks ?? []) as $i => $link)
        <div class="flex gap-2 mb-2"  data-link-id="{{ $link->id }}">
            <input type="text" name="social_links[{{ $i }}][platform]" placeholder="Platform" value="{{ $link['platform'] ?? $link->platform ?? '' }}">
            <input type="url" name="social_links[{{ $i }}][url]" placeholder="URL" value="{{ $link['url'] ?? $link->url ?? '' }}">
            @can('deleteSocial',$link)
            <button type="button" class="delete-link-btn text-red-600 hover:text-red-800"
                data-id="{{ $link->id }}">
            <i class="fas fa-trash"></i>
        </button>
        @endcan
          </div>
    @endforeach
</div>
<div class="block w-fit  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
<button type="button" onclick="addCustomLink()">Add Custom Link</button>
</div>
  @can('update', $user)
<div class="block w-fit  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
    <button type="submit" class=" cursor-pointer">update</button>
  </div>
  @endcan
</form>
    <!-- about me -->
    <form action="{{route('add.about',$user->id)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap mt-2">
        <label for="about" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          About me :
        </label>

        <textarea id="about" type="text"
          class="rounded-sm p-2 border-2 form-input w-full @error('about') border-red-500 @enderror" name="about"
         required autocomplete="about" rows="4">
    {{ old('about', $user->aboutme) }}
        </textarea>
        @error('about')
      <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
      </p>
    @enderror
        @can('update', $user)
      <div class=" w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update</button>
      </div>
    @endcan
      </div>
    </form>
    <div class="flex flex-wrap">
      <div>
        <h2 class="font-bold">Update Password</h2>
        <p class="text-sm text-gray-600 mb-3">Ensure your account is using a long, random password to stay secure.</p>
      </div>
    </div>
        <!-- password -->
    <form action="{{route('edit.pass',$user->id)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap">
        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Current Password
        </label>
        <input id="current_password" type="password"
          class="rounded-sm p-2 border-2 form-input w-full @error('current_password') border-red-500 @enderror"
          name="current_password" required>
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          New Password:
        </label>
        <input id="password" type="password"
          class="rounded-sm p-2 border-2 form-input w-full @error('password') border-red-500 @enderror" name="password"
          required>


        <label for="password-confirm" class="mt-2 block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Confirm Password:
        </label>

        <input id="password-confirmation" type="password" class="rounded-sm p-2 border-2 form-input w-full"
          name="password_confirmation" required>
        @can('update', $user)
      <div class=" w-42  bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update password</button>
      </div>
    @endcan
      </div>
    </form>
    <div class="flex flex-wrap">
      <div>
        <h2 class="font-bold">Delete Account</h2>
        <p class="text-sm text-gray-600">Once your account is deleted, all of its resources and data will be permanetly
          deleted.</p>
        <button id="show-menu"
          class=" w-42  bg-red-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">Delete
          account</button>
      </div>

    </div>
  </div>
  {{-- delete account menu --}}
  @include('partials.confirmation-delete-menu')

  @push('scripts')
    <script>
    const showmenu = document.getElementById('show-menu');
    const closemenu = document.getElementById('close-menu');
    const menu = document.getElementById("menu");
    showmenu.addEventListener('click', () => {
      if (menu.classList.contains('hidden')) {
      menu.classList.remove('hidden');
      }
    })
    closemenu.addEventListener('click', () => {
      if (menu.classList.contains('fixed')) {
      menu.classList.add('hidden');
      }
    })
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
      const phoneInputField = document.querySelector("#phone");

      // Initialize intl-tel-input
      const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });


      fetch('https://get.geojs.io/v1/ip/geo.json')
      .then(response => response.json())
      .then(data => {
        const country = data.country_code;  // Country code like "US", "IN", etc.
        phoneInput.setCountry(country);  // Set the country
      })
      .catch(error => console.error('Error fetching location:', error));
      const form = document.querySelector('#phone-form');
      form.addEventListener('submit', function (eo) {
      eo.preventDefault();


      const countryCode = phoneInput.getSelectedCountryData().dialCode;
      const phoneNumber = phoneInput.getNumber();


      const countryCodeInput = document.createElement('input');
      countryCodeInput.type = 'hidden';
      countryCodeInput.name = 'country_code';
      countryCodeInput.value = countryCode;
      form.appendChild(countryCodeInput);

      phoneInputField.value = phoneNumber;

      form.submit();
      });
    });   
    </script>
    <script>
function addCustomLink() {
    const container = document.getElementById('custom-links');
    const index = container.children.length;
    const div = document.createElement('div');
    div.classList.add('flex', 'gap-2', 'mb-2');
    div.innerHTML = `
        <input type="text" name="social_links[${index}][platform]" placeholder="Platform">
        <input type="url" name="social_links[${index}][url]" placeholder="URL">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
          <i class="fas fa-trash"></i>
        </button>
        `;
    container.appendChild(div);
}
    </script>
    <script>

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-link-btn').forEach(button => {
        button.addEventListener('click', function () {
            const linkId = this.dataset.id;
            const row = this.closest('[data-link-id]');

            if (!confirm('Are you sure you want to delete this link?')) return;

            fetch(`/delete/custom-link/${linkId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            })
            .then(res => {
                if (res.ok) {
                    row.remove();
                    toastr.success('Link deleted successfully');
                } else {
                    toastr.error('Failed to delete link');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Error deleting link');
            });
        });
    });
});
    </script>
  @endpush

</x-layout>