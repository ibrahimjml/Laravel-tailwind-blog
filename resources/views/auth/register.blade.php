<x-header-blog>
  <main class="sm:container mx-auto  max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">
    <div class="flex">
        <div class="w-full">
            <section class="flex  flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm ">

                <header class="font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                  Register
                </header>

                <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-4  border-2 h-fit" method="POST"
                    action="{{ route('register.post') }}">
                    @csrf

                    <div class="flex flex-wrap">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                          Name:
                        </label>

                        <input id="name" type="text" class="rounded-sm p-2 border-2 form-input w-full @error('name')  border-red-500 @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="flex flex-wrap">
                      <label for="name" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Username:
                      </label>

                      <input id="username" type="text" class="rounded-sm p-2 border-2 form-input w-full @error('username')  border-red-500 @enderror"
                          name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                      @error('username')
                      <p class="text-red-500 text-xs italic mt-4">
                          {{ $message }}
                      </p>
                      @enderror
                  </div>
                    <div class="flex flex-wrap">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                          E-Mail Address:
                        </label>

                        <input id="email" type="email"
                            class="rounded-sm p-2 border-2 form-input w-full @error('email') border-red-500 @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    
                    <div class="flex flex-wrap">
                      <label for="phone" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Phone:
                      </label>

                      <input id="phone" type="text"
                          class="rounded-sm p-2 border-2 form-input w-full @error('phone') border-red-500 @enderror" name="phone"
                          value="{{ old('phone') }}" required autocomplete="phone">

                      @error('phone')
                      <p class="text-red-500 text-xs italic mt-4">
                          {{ $message }}
                      </p>
                      @enderror
                  </div>
             
                  <div class="flex flex-wrap">
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                      Age:
                    </label>

                    <input id="age" type="text"
                        class="rounded-sm p-2 border-2 form-input w-full @error('age') border-red-500 @enderror" name="age"
                        value="{{ old('age') }}" required autocomplete="age">

                    @error('age')
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
<x-footer/>
</x-header-blog>