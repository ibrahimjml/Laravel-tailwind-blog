<div id="menu" class="hidden fixed z-[20]  py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">
  <div  class="w-3/4 mx-auto">
    <h4 class="text-slate-200">Are you sure you want to delete your account</h4><br>
    <p class="text-sm text-gray-400">Once your account is deleted, all of its resources and data will be permanetly deleted.</p>
 @can('delete',$user)
  <form action="{{route('account.delete',$user->id)}}" method="POST">
 @csrf
 @method("DELETE")
 <label for="password-confirm" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
 Password:
</label>
 <input  type="password" class="block  w-72 rounded-lg p-2 border-2 bg-transparent @error('check_pass') border-red-500 @enderror"
  name="check_pass" placeholder="password">
  @error('check_pass')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      @can('delete',$user)
        <button type="submit" class="w-42 bg-red-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Delete Account</button>
      @endcan
    </form> 
    @endcan
<button id="close-menu" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
  </div>
</div>