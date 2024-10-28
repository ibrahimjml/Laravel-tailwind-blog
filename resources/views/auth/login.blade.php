<x-header-blog/>
  @if(session()->has('error'))
  <div id="parag2"  class="fixed bg-red-500 p-[10px] text-center   transform translate-x-[30vw] sm:translate-x-[38vw] translate-y-[60vh] sm:translate-y-[72vh] z-20 rounded-lg">
  <p  class="text-center  font-bold text-2xl text-white">{{session('error')}}</p>
  </div>
  @endif
  @if(session()->has('success'))
  <div id="parag2"  class="fixed bg-red-500 p-[10px] text-center   transform translate-x-[30vw] sm:translate-x-[38vw] translate-y-[60vh] sm:translate-y-[72vh] z-20 rounded-lg">
  <p  class="text-center  font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif
  <main class="sm:container mx-auto  max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">
    <div class="flex">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md  sm:shadow-lg">

                <header class=" font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                    Login
                </header>

                <form class="border-2 w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST"
                    action="{{ route('login.post') }}">
                    @csrf

                  

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
                        <button type="submit"
                            class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-gray-700 hover:bg-gray-500 sm:py-4">
                            Login
                        </button>
                        
                          <a class="text-gray-500 mt-2 hover:text-blue-700 no-underline hover:underline" href="{{ route('forgot.password') }}">
                            forgot your password ?
                          </a>
                      
                        <p class="w-full text-xs text-center text-gray-700 my-6 sm:text-sm sm:my-8">
                            {{ __('Dont have an account?') }}
                            <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline" href="{{ route('register') }}">
                              Register
                            </a>
                        </p>
                    </div>
                </form>

            </section>
        </div>
    </div>
</main>

<x-footer/>