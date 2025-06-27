  <main class=" relative lg:w-4/6 w-full h-full lg:mx-auto mx-0 mt-5">
        <p class="text-xl font-medium text-black">Account</p>
        <p class="text-md font-medium text-gray-400">Configure your account</p>
        <hr class="mt-6">
        <div>
          <form id="myform" action="{{route('update.account')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mt-2 flex flex-col">
             <!-- username -->
             <label for="username" class="mt-5">Username</label>
             <p class="text-md font-medium text-gray-400">you can change your username only once.</p>
             <input type="text" name="username" value="{{ old('username', $user->username) }}" class="rounded-xl p-2 mt-2 font-bold border border-gray-300 @error("username") border-2 border-red-500 @enderror">
              @error('username')
             <p class="text-red-500 text-xs italic mt-4">
             {{ $message }}
             </p>
              @enderror
              <!-- email -->
             <label for="email" class="mt-5">email </label>
             <p class="text-md font-medium text-gray-400">Please verify your email after modifying for full controll pages.</p>
             <input type="text" name="email" value="{{ old('email', $user->email) }}" class="rounded-xl p-2 mt-2 font-bold border border-gray-300 @error("email") border-2 border-red-500 @enderror">
            @if(is_null($user->email_verified_at))
            <div class="text-sm mt-2 flex items-center ">
              <span>
                <b class="text-red-500">UNVERIFIED:</b> Please verify using the verification link sent to the above mail.
              </span>
              <button type="button"
                      class="text-blue-600 underline"
                      onclick="document.getElementById('resend-email').submit();">
                Resend verification email
              </button>
            </div>
             @endif
             @error('email')
             <p class="text-red-500 text-xs italic mt-4">
             {{ $message }}
             </p>
            @enderror
            <p class="text-xl font-medium text-black mt-4">Password</p>
            <p class="text-md font-medium text-gray-400">Modify your password.</p>
             <hr class="mt-4">
             <!-- current password -->
             <label for="current_password" class="mt-5">Current password </label>
             <input type="password" name="current_password"    class="rounded-xl p-2 mt-2 font-bold border border-gray-300 @error("current_password") border-2 border-red-500 @enderror">
             @error('current_password')
             <p class="text-red-500 text-xs italic mt-4">
             {{ $message }}
             </p>
             @enderror
              <!-- new password -->
             <label for="password" class="mt-5">Password </label>
             <input type="password" name="password" rows="10"   class="rounded-xl p-2 mt-2 font-bold border border-gray-300 @error("password") border-2 border-red-500 @enderror">
             @error('password')
             <p class="text-red-500 text-xs italic mt-4">
             {{ $message }}
             </p>
             @enderror
              <!-- confirmation password -->
             <label for="password_confirmation" class="mt-5">Confirm password </label>
             <input type="password" name="password_confirmation" rows="10"   class="rounded-xl p-2 mt-2 font-bold border border-gray-300 @error("password_confirmation") border-2 border-red-500 @enderror">
             @error('password_confirmation')
             <p class="text-red-500 text-xs italic mt-4">
             {{ $message }}
             </p>
             @enderror
            </div>
          </form>
          <!-- resend verification email -->
          <form id="resend-email" action="{{route('verification.send')}}" method="POST" class="p-3">
          @csrf
          @method('POST')
          </form>
          <!-- Danger area -->
          <p class="text-xl font-medium text-red-500 mt-4">Danger Area</p>
          <p class="text-md font-medium text-gray-400">Once your account is deleted, all of its resources and data will be permanetly
          deleted.</p>
          <hr class="mt-4">
          <button id="show-menu"
          class=" w-42  bg-red-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">Delete
          account</button>
          <!-- password model for deleting account -->
          @include('partials.confirmation-delete-menu')
          <div class="sticky inset-0 z-10 flex justify-end border-t border-t-gray-400 bg-white py-4 ">
           <button type="submit" form="myform" class="rounded-xl text-white font-bold bg-blue-600  p-2">update</button>
          </div>
        </div>
      </main>