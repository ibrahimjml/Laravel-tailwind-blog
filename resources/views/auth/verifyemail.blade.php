<x-header-blog>
<main class="sm:container mx-auto  max-w-fit mt-5 mb-20 sm:max-w-lg sm:mt-10">

  <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md  sm:shadow-lg">

      <header class=" font-bold text-center bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
          Email verfication
      </header>
      <h1 class="p-3">Please verify your email within the link that we already sent to you .</h1>
      <p class='text-sm p-3 text-gray-500'>Didn't verified your email yet,click resend</p>
      <form action="{{route('verification.send')}}" method="POST" class="p-3">
        @csrf
        @method('POST')
        <button 
        class='px-6 py-2 rounded-lg bg-slate-700 dark:bg-slate-900 text-white '
          type='submit'>
           
          Resend
        </button>
      </form>

      @if(session()->has('message'))
      <p class='bg-green-400 text-slate-200 text-center px-3 '>{{session('message')}}</p>
      @endif
  </section>
</main>
<x-footer/>
</x-header-blog>