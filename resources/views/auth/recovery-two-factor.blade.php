<x-layout>
  <main class="sm:container mx-auto max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">
    <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-lg">
      <header class="font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
        Two Factor Recovery Code
      </header>

      <form action="{{ route('2fa.verify.recovery') }}" method="POST" class="border-2 w-full px-6 p-3 space-y-6 sm:px-10 sm:space-y-8">
        @csrf
        <div>
          <label for="recovery_code" class="block text-gray-700 text-sm font-bold mb-2">Recovery Code</label>
          <input type="text" name="recovery_code" id="recovery_code" class="w-full px-3 py-2 border rounded-md" required>
          @error('recovery_code')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="bg-black/60 mt-3 text-white font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md">
          Verify
        </button>

        <p class="text-blueGray-400 text-xs hover:text-gray-400 mt-2">
          Back to <a href="{{ route('2fa.confirmation') }}" class="hover:underline">Authenticator verification</a>
        </p>
      </form>
    </section>
  </main>
</x-layout>
