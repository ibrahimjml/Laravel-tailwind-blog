<x-layout>
  <main class="sm:container mx-auto  max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">

    <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md  sm:shadow-lg">

      <header class=" font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
        Two Factor Authentication Code
      </header>

      <form  action="{{route('2fa.verify')}}" method="POST"
        class="border-2 w-full px-6 p-3 space-y-6 sm:px-10 sm:space-y-8">
        @csrf
        <div class="flex flex-wrap">
          <p class='text-slate-900'>
            Enter the 6-digits code from your authenticator app.
          </p>
          <input type="hidden" name="code" id="twofa_code">
          <div class="flex gap-2 justify-center mt-3">
            @for ($i = 0; $i < 6; $i++)
              <input type="text" inputmode="numeric" maxlength="1"
                class="twofa-input w-12 h-12 text-center text-xl font-bold border rounded-lg focus:ring-2 focus:ring-black/70 outline-none">
            @endfor
          </div>
          @error('code')
          <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
          </p>
          @enderror
        </div>
        <button type="submit" class="bg-black/60 mt-3 text-white  font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
          Login
        </button>
        <p class="text-blueGray-400 text-xs hover:text-gray-400">
          having problem ?
          <a href="{{ route('2fa.recovery') }}" class="text-black/70 hover:underline">verify with recovery codes</a>
        </p>
      </form>
    </section>
  </main>

  @push('scripts')
    <script>
    const inputs = document.querySelectorAll('.twofa-input');
    const hidden = document.getElementById('twofa_code');

    inputs.forEach((input, index) => {
      input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/, '');

        if (input.value && inputs[index + 1]) {
          inputs[index + 1].focus();
        }

        updateCode();
      });

      input.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !input.value && inputs[index - 1]) {
          inputs[index - 1].focus();
        }
      });
    });

    document.getElementById('confirm2faBtn').addEventListener('paste', e => {
      const paste = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
      paste.split('').forEach((char, i) => {
        if (inputs[i]) inputs[i].value = char;
      });
      updateCode();
    });

    function updateCode() {
      hidden.value = [...inputs].map(i => i.value).join('');
    }
  </script>
  @endpush
</x-layout>