<div id="Model" class="hidden fixed w-2/6 z-[20] max-h-[80%] overflow-y-auto py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Create New User</p>
 <form id="phone-form" action="{{route('create.user')}}" method="POST">
 @csrf
 @method("POST")
 <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Name:
</label>
 <input  type="text" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
  name="name" >
  @error('name')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      <label for="username" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Username:
</label>
 <input  type="text" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('username') border-red-500 @enderror"
  name="username" >
  @error('username')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      <label for="email" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Email:
</label>
 <input  type="text" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('email') border-red-500 @enderror"
  name="email" >
  @error('email')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror

  <label for="age" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Age:
</label>
<input  type="number" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('age') border-red-500 @enderror"
name="age" >
@error('age')
<p class="text-red-500 text-xs italic mt-4">
  {{ $message }}
</p>
@enderror
      <label for="phone" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
phone:
</label>
<input id="phone" type="tel"
 class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('phone') border-red-500 @enderror"
 name="phone" value="{{ old('phone') }}"  autocomplete="tel">
 @error('phone')
     <p class="text-red-500 text-xs italic mt-4">
         {{ $message }}
     </p>
     @enderror
        <label for="password" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Password:
</label>
 <input  type="password" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('password') border-red-500 @enderror"
  name="password" >
  @error('password')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
        <label for="password_confirmation" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">
Confirm password:
</label>
 <input  type="password" class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('password_confirmation') border-red-500 @enderror"
  name="password_confirmation" placeholder="type a tag">
  @error('password_confirmation')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
      <div class="flex flex-col ">
  <label for="roles" class="mt-2 block text-slate-200 text-sm mb-1 font-bold">Roles:</label>
  @foreach ($roles as $role)  
    <label class="mr-4 text-white">
      <input type="radio" name="roles" value="{{ $role->id }}" class="mr-1">
      {{ $role->name }}
    </label>
  @endforeach
</div>
<label for="permissions" class="text-white">Permissions:</label>
<div class="flex flex-col h-52 overflow-y-auto">
  @foreach ($permissions as $module => $modulePermissions)
    <div class="mb-4">
        <h3 class="text-white font-bold mb-2">{{ $module }}</h3>
        <div class="flex flex-wrap gap-2">
            @foreach ($modulePermissions as $permission)
                <label class="text-white mr-4">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                    {{ $permission->name }}
                </label>
            @endforeach
        </div>
    </div>
@endforeach
</div>
<button type="submit" class="w-42 bg-green-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Create</button>
</form> 
<button id="closeModel" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
</div>
</div>
@push('scripts')
  <script>
      document.addEventListener('DOMContentLoaded', function () {
        const phoneInputField = document.querySelector("#phone");

    
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });


fetch('https://get.geojs.io/v1/ip/geo.json')
        .then(response => response.json())
        .then(data => {
            const country = data.country_code;  
            phoneInput.setCountry(country);  
        })
        .catch(error => console.error('Error fetching location:', error));
        const form = document.querySelector('#phone-form');
        form.addEventListener('submit', function (eo) {
            eo.preventDefault();


            const countryCode = phoneInput.getSelectedCountryData().dialCode;
            const phoneNumber = phoneInput.getNumber(); 

            
            const countryCodeInput = document.createElement('input');
            countryCodeInput.type = 'hidden';
            countryCodeInput.name = 'country_code';
            countryCodeInput.value = countryCode;
            form.appendChild(countryCodeInput);

            phoneInputField.value = phoneNumber;

            form.submit();
        });
    });

    
    </script>
@endpush