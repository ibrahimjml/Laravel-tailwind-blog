<x-layout>
<main class="sm:container mx-auto  max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">

  <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md  sm:shadow-lg">

      <header class=" font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
          Confirm Password
      </header>

      <form action="{{route('confirm.password')}}" method="POST" class="border-2 w-full px-6 p-3 space-y-6 sm:px-10 sm:space-y-8" >
       @csrf
       @method('POST')
          <div class="flex flex-wrap">
          <p class='text-slate-900'>
      This is a secure area of the application. Please confirm your
      password before continuing.
  </p>
    <label for="password" class="block text-gray-700 text-sm font-bold mb-2 mt-4 sm:mb-4">
      Password:
    </label>
    <input id="password" type="password"
        class="rounded-sm p-2 border-2 text-black w-full @error('password') border-red-500 @enderror" name="password"/>
      
        @error('password')
        <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
        </p>
          @enderror
                     
          </div>
          <button 
          class='px-6 py-2 rounded-lg bg-slate-700 dark:bg-slate-900 text-white '
            type='submit'>
             
            Confirm
          </button>
          </form>
          </section>
          </main>

</x-layout>