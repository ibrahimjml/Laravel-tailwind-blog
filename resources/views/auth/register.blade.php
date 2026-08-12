@extends('layouts.guest')

@section('content')
<main class="mx-auto max-w-md sm:max-w-lg px-4 mt-5 mb-20 sm:mt-10">
  <div class="flex">
    <div class="w-full">
      <div class="flex">
        <x-logo class="mx-auto text-2xl my-4 cursor-pointer" />
      </div>
      <section class="flex flex-col break-words bg-white border border-gray-200 rounded-2xl shadow-sm">

        <header class="font-bold text-center bg-gray-100 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 rounded-t-2xl">
          Register
        </header>

        <form id="registerForm" class="w-full px-4 py-6 space-y-6 sm:px-10 sm:space-y-5 h-fit" method="POST"
          action="{{ route('register.post') }}">
          @csrf

          <div class="flex flex-wrap">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
              Name:
            </label>

            <input id="name" type="text"
              class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('name') border-red-500 bg-white @enderror"
              name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
              <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
              </p>
            @enderror
            <p data-error-for="name" class="hidden text-red-500 text-xs italic mt-2 w-full"></p>
          </div>
          <div class="flex flex-wrap">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
              Username:
            </label>

            <input id="username" type="text"
              class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('username') border-red-500 bg-white @enderror"
              name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

            @error('username')
              <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
              </p>
            @enderror
            <p data-error-for="username" class="hidden text-red-500 text-xs italic mt-2 w-full"></p>
          </div>
          <div class="flex flex-wrap">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
              E-Mail Address:
            </label>

            <input id="email" type="email" placeholder="e.g. gmail.com, mail.ru"
              class="w-full rounded-2xl border placeholder:text-xs border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('email') border-red-500 bg-white @enderror"
              name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
              <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
              </p>
            @enderror
            <p data-error-for="email" class="hidden text-red-500 text-xs italic mt-2 w-full"></p>
          </div>

          <div class="flex flex-wrap mb-4">
            <label for="phone" class="block w-full text-gray-700 text-sm font-bold mb-2">
              Phone:
            </label>

            <input id="phone" type="tel"
              class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('phone') border-red-500 bg-white @enderror"
              name="phone" value="{{ old('phone') }}" required autocomplete="tel">

            @error('phone')
              <p class="text-red-500 text-xs italic mt-2 w-full">
                {{ $message }}
              </p>
            @enderror
            <p data-error-for="phone" class="hidden text-red-500 text-xs italic mt-2 w-full"></p>
          </div>

          <div class="flex flex-wrap">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
              Password:
            </label>

            <input id="password" type="password"
              class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('password') border-red-500 bg-white @enderror"
              name="password" required autocomplete="new-password">

            @error('password')
              <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
              </p>
            @enderror
            <p data-error-for="password" class="hidden text-red-500 text-xs italic mt-2 w-full"></p>
          </div>

          <div class="flex flex-wrap">
            <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
              Confirm Password:
            </label>

            <input id="password-confirm" type="password"
              class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
              name="password_confirmation" required autocomplete="new-password">
            <p data-error-for="password_confirmation" class="hidden text-red-500 text-xs italic mt-2 w-full"></p>
          </div>
          @if($terms && $privacy)
            <!-- accept terms checkbox -->
            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:gap-3">
              <div class="flex items-center gap-2">
                <input id="accept" type="checkbox" name="accept"
                  class="h-4 w-4 rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="accept" class="text-sm text-gray-700">I agree to <a class="text-blue-500 underline"
                    href="{{ route('custom.page', $terms) }}">terms</a> & <a class="text-blue-500 underline"
                    href="{{ route('custom.page', $privacy) }}">privacy policy</a>.</label>
              </div>
              @error('accept')
              <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
              <p data-error-for="accept" class="hidden text-red-500 text-xs italic mt-2"></p>
            </div>
          @endif
          <!-- Google reCAPTCHA v2 checkbox -->
          @recaptcha_enabled
          <div class="g-recaptcha" data-sitekey="{{config('services.captcha.sitekey')}}"></div>
          @error('g-recaptcha-response')
            <p class="text-red-500 text-xs italic mt-4">
              {{ $message }}
            </p>
          @enderror
          <p data-error-for="g-recaptcha-response" class="hidden text-red-500 text-xs italic mt-2"></p>
          @endrecaptcha_enabled
          <div class="flex flex-wrap">
            <button type="submit"
              class="w-full font-bold p-3 rounded-2xl text-base leading-normal text-white bg-gray-700 hover:bg-gray-500 transition sm:py-4">
              Register
            </button>

            <p class="w-full text-xs text-center text-gray-700 my-3 sm:text-sm sm:my-8">
              Already have an account?
              <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline" href="{{ route('login') }}">
                Login
              </a>
            </p>
          </div>
        </form>

      </section>
    </div>
  </div>
</main>

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const registerForm = document.getElementById('registerForm');
      if (!registerForm) {
        return;
      }

      const submitButton = registerForm.querySelector('button[type="submit"]');
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      const phoneInputField = document.querySelector('#phone');
      const phoneInput = phoneInputField && (window.intlTelInputGlobals?.getInstance(phoneInputField) || window.intlTelInput(phoneInputField, {
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
      }));

      if (phoneInput) {
        fetch('https://get.geojs.io/v1/ip/geo.json')
          .then((response) => response.json())
          .then((data) => {
            const country = data.country_code;
            phoneInput.setCountry(country);
          })
          .catch((error) => console.error('Error fetching location:', error));
      }

      function clearRegisterErrors() {
        registerForm.querySelectorAll('[data-error-for]').forEach((element) => {
          element.textContent = '';
          element.classList.add('hidden');
        });

        registerForm.querySelectorAll('input, textarea, select').forEach((input) => {
          input.classList.remove('border-red-500', 'bg-white');
          input.classList.add('border-gray-300', 'bg-gray-50');
        });
      }

      function showRegisterErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
          const errorElement = registerForm.querySelector(`[data-error-for="${field}"]`);
          const input = registerForm.querySelector(`[name="${field}"]`);

          if (input) {
            input.classList.remove('border-gray-300', 'bg-gray-50');
            input.classList.add('border-red-500', 'bg-white');
          }

          if (errorElement) {
            const message = Array.isArray(messages) ? messages[0] : messages;
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
          }
        });
      }

      registerForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearRegisterErrors();

        submitButton.disabled = true;
        const originalLabel = submitButton.textContent;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        try {
          if (phoneInput && phoneInputField) {
            const countryCodeInput = registerForm.querySelector('input[name="country_code"]') ?? document.createElement('input');
            countryCodeInput.type = 'hidden';
            countryCodeInput.name = 'country_code';
            countryCodeInput.value = phoneInput.getSelectedCountryData()?.dialCode || '';
            if (!countryCodeInput.parentElement) {
              registerForm.appendChild(countryCodeInput);
            }
            phoneInputField.value = phoneInput.getNumber();
          }

          const response = await fetch(registerForm.action, {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: new FormData(registerForm),
          });

          const data = await response.json();

          if (!response.ok) {
            if (response.status === 422 && data.errors) {
              showRegisterErrors(data.errors);
              return;
            }

            const message = data.message || Object.values(data.errors || {})?.flat()?.[0] || 'Registration failed.';
            if (window.toastr) {
              toastr.error(message);
            } else {
              alert(message);
            }
            return;
          }

          if (window.toastr) {
            toastr.success(data.message || 'Registered successfully.');
          }

          registerForm.reset();
          clearRegisterErrors();

          if (data.redirect) {
            window.location.assign(data.redirect);
          } else {
            window.location.assign('/login');
          }
        } catch (error) {
          if (window.toastr) {
            toastr.error(error.message || 'Registration failed.');
          } else {
            alert(error.message || 'Registration failed.');
          }
        } finally {
          submitButton.disabled = false;
          submitButton.textContent = originalLabel;
        }
      });
    });
  </script>
@endpush
@endsection