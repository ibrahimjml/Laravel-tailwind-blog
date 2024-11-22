<x-header-blog>
<main class="sm:container mx-auto  max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">
  <div class="flex">
      <div class="w-full">
          <section class="flex  flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm ">

              <header class="font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                Reset Password
              </header>

              <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-4  border-2  h-80" method="POST"
                  action="{{ route('reset.password.post', $token) }}">
                  @csrf
                  @method('POST') 
                  <div class="flex flex-wrap">
                      <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Password:
                      </label>

                      <input id="password" type="password"
                          class="rounded-sm p-2 border-2 form-input w-full @error('password') border-red-500 @enderror" name="password"
                          required autocomplete="new-password">

                      @error('password')
                      <p class="text-red-500 text-xs italic mt-4">
                          {{ $message }}
                      </p>
                      @enderror
                  </div>

                  <div class="flex flex-wrap">
                      <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Confirm Password:
                      </label>

                      <input id="password-confirm" type="password" class="rounded-sm p-2 border-2 form-input w-full"
                          name="password_confirmation" required autocomplete="new-password">
                  </div>

                  <div class="flex flex-wrap">
                      <button type="submit"
                          class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-gray-700 hover:bg-gray-500 sm:py-4">
                          Reset
                      </button>
                  </div>
              </form>

          </section>
      </div>
  </div>
</main>
<x-footer/>
</x-header-blog>