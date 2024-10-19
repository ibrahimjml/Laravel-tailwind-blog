<x-header-blog/>
@if(session()->has('error'))
<div id="parag2"  class="fixed bg-red-500 p-[10px] text-center   transform translate-x-[30vw] sm:translate-x-[38vw] translate-y-[60vh] sm:translate-y-[72vh] z-20 rounded-lg">
<p  class="text-center  font-bold text-2xl text-white">{{session('error')}}</p>
</div>
@endif
<div class="container mx-auto pt-[40px]">
  <h1 class=" text-3xl font-bold text-center py-5 capitalize">edit profile</h1>
</div>


<div class="flex flex-col mx-auto pt-5 w-[50%] sm:w-[40%]">
  <form action="/change-name/{{$user->id}}" method="POST">
    @csrf
    @method('PUT')

    <div class="flex flex-wrap">
      <label for="name" class=" text-gray-700 text-sm font-bold mb-2 sm:mb-4">
        Name:
      </label>

      <input id="name" type="text" class="rounded-sm p-2 border-2 form-input w-full @error('name')  border-red-500 @enderror"
          name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" >

      @error('name')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      @can('update',$user)
      <div class=" w-42 mx-auto bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
        <button type="submit" class=" cursor-pointer">update name</button>
      </div>
      @endcan
  </div>
  </form>
  <form action="/edit-email/{{$user->id}}" method="POST">
    @csrf
    @method('PUT')
  <div class="flex flex-wrap mt-2">
    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
      E-Mail Address:
    </label>

    <input id="email" type="email"
        class="rounded-sm p-2 border-2 form-input w-full @error('email') border-red-500 @enderror" name="email"
        value="{{ old('email', $user->email) }}" required autocomplete="email">

    @error('email')
    <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
    </p>
    @enderror
    @can('update',$user)
    <div class=" w-42 mx-auto bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
      <button type="submit" class=" cursor-pointer">update email</button>
    </div>
    @endcan
</div>
  </form>
  <form action="/change-phone/{{$user->id}}" method="POST">
    @csrf
    @method('PUT')
<div class="flex flex-wrap mt-2">
  <label for="phone" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
    Phone:
  </label>

  <input id="phone" type="text"
      class="rounded-sm p-2 border-2 form-input w-full @error('phone') border-red-500 @enderror" name="phone"
      value="{{ old('phone', $user->phone) }}" required autocomplete="phone">

  @error('phone')
  <p class="text-red-500 text-xs italic mt-4">
      {{ $message }}
  </p>
  @enderror
  @can('update',$user)
  <div class=" w-42 mx-auto bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
    <button type="submit" class=" cursor-pointer">update phone</button>
  </div>
  @endcan
</div>
  </form>
    <form action="/change-pass/{{$user->id}}" method="POST">
      @csrf
      @method('PUT')
      <div class="flex flex-wrap">
        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Current Password
        </label>
        <input id="current_password" type="password"
        class="rounded-sm p-2 border-2 form-input w-full @error('current_password') border-red-500 @enderror" name="current_password"
        required >
      <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
       New Password:
      </label>
      <input id="password" type="password"
      class="rounded-sm p-2 border-2 form-input w-full @error('password') border-red-500 @enderror" name="password"
      required >
      
    
        <label for="password-confirm" class="mt-2 block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
          Confirm Password:
        </label>

        <input id="password-confirmation" type="password" class="rounded-sm p-2 border-2 form-input w-full"
            name="password_confirmation" required >
            @can('update',$user)
            <div class=" w-42 mx-auto bg-blue-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center">
              <button type="submit" class=" cursor-pointer">update password</button>
            </div>
            @endcan
          </div>
</form>
</div>

<x-footer/>