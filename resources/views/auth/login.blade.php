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
            Login
          </header>

          <form id="recaptcha" class="w-full border border-transparent px-4 py-6 space-y-6 sm:px-10 sm:space-y-5" method="POST"
            action="{{ route('login.post') }}">
            @csrf
            @method('POST')
            <div class="flex flex-wrap">
              <label for="login" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                Username or Email
              </label>

              <input id="login" type="text"
                class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('login') border-red-500 bg-white @enderror" name="login"
                value="{{ old('login') }}" required >

              @error('login')
                <p class="text-red-500 text-xs italic mt-4">
                  {{ $message }}
                </p>
              @enderror
            </div>

            <div class="flex flex-wrap">
              <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                Password:
              </label>

              <input id="password" type="password"
                class="w-full rounded-2xl border border-gray-300 bg-gray-50 p-3 text-gray-900 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('password') border-red-500 bg-white @enderror"
                name="password"  required >

              @error('password')
                <p class="text-red-500 text-xs italic mt-4">
                  {{ $message }}
                </p>
              @enderror
            </div>
  
              <div class="flex items-center gap-2">
                <input id="remember" type="checkbox" name="remember"
                  class="h-4 w-4 rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="remember" class="text-sm text-gray-700">Remember Me</label>
              </div>
            <div class="flex flex-col gap-4">
              <button type="submit"
                class="w-full font-bold p-3 rounded-2xl text-base leading-normal text-white bg-gray-700 hover:bg-gray-500 transition sm:py-4">
                Login
              </button>

              <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline"
                href="{{ route('forgot.password') }}">
                Forgot your password?
              </a>

              <p class="w-full text-xs text-center text-gray-700 my-6 sm:text-sm sm:my-8">
                {{ __('Dont have an account?') }}
                <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline"
                  href="{{ route('register') }}">
                  Register
                </a>
              </p>
            </div>
          </form>

        </section>
      </div>
    </div>
    @if(config('demo.enabled'))
      <div class="mt-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">Admin Credentials</p>
        <p>Username: <span class="font-mono">{{ config('demo.admin.username') }}</span></p>
        <p>Pass: <span class="font-mono">{{ config('demo.admin.password') }}</span></p>
      </div>
      <div class="mt-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">User Credentials</p>
        <p>Username: <span class="font-mono">{{ config('demo.user.username') }}</span></p>
        <p>Pass: <span class="font-mono">{{ config('demo.user.password') }}</span></p>
      </div>
      
    @endif
  </main>
  @push('scripts')
   <script>
    document.addEventListener('DOMContentLoaded', () => {
      const loginForm = document.getElementById('recaptcha');
      if (! loginForm) {
        return;
      }

      const submitButton = loginForm.querySelector('button[type="submit"]');
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const login = loginForm.querySelector('#login')?.value.trim();
        const password = loginForm.querySelector('#password')?.value;
        const remember = loginForm.querySelector('#remember')?.checked ?? false;

        if (! login || ! password) {
          return;
        }

        submitButton.disabled = true;
        const originalLabel = submitButton.textContent;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        try {
          const response = await fetch(loginForm.action, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken ,
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ login, password, remember }),
          });

          const data = await response.json();

          if (! response.ok) {
            const message = data.message || Object.values(data.errors || {})?.flat()?.[0] || 'Login failed.';
            toastr.error(message);
            return;
          }

          if (data.redirect) {
            window.location.assign(data.redirect);
             if (!data.require_2fa) {
                   toastr.success(data.message);
                 }
            return;
          }

          window.location.reload();
        } catch (error) {
          console.error(error);
        } finally {
          submitButton.disabled = false;
          submitButton.textContent = originalLabel;
        }
      });
    });
   </script>
  @endpush
@endsection

