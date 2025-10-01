<div id="editModel-{{ $user->id }}" class="hidden fixed w-2/6 z-[20] max-h-[80%] overflow-y-auto py-8 left-[50%]  top-[50%] transform translate-x-[-50%] translate-y-[-50%] items-center space-y-2 font-bold bg-gray-700 rounded-lg drop-shadow-lg border border-gray-300 transition-all duration-300">

  <div class="ml-6">
    <p class="text-xl text-gray-100">Edit User {{$user->name}}</p>
 <form  action="{{route('admin.users.update',$user->id)}}" method="POST">
 @csrf
 @method("PUT")
 <label for="name" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">Name:</label>
 <input  type="text" 
         value="{{ old('name', $user->name) }}" 
         class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('name') border-red-500 @enderror"
         name="name" >
@error('name')
<p class="text-red-500 text-xs italic mt-4">
  {{ $message }}
</p>
@enderror
<label for="username" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Username:</label>
 <input  type="text"
         value="{{ old('username') ?: $user->username }}" 
         class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('username') border-red-500 @enderror"
         name="username" >
@error('username')
<p class="text-red-500 text-xs italic mt-4">
  {{ $message }}
</p>
@enderror
<label for="email" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Email:</label>
 <input  type="text" 
         value="{{ old('email') ?: $user->email }}" 
         class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('email') border-red-500 @enderror"
         name="email" >
@error('email')
<p class="text-red-500 text-xs italic mt-4">
  {{ $message }}
</p>
@enderror

<label for="age" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Age:</label>
<input  type="number" 
        value="{{ old('age', $user->age) }}" 
        class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('age') border-red-500 @enderror"
        name="age" >
@error('age')
<p class="text-red-500 text-xs italic mt-4">
  {{ $message }}
</p>
@enderror
<label for="phone" class="mt-2 block text-slate-200 text-sm mb-1 font-bold  ">phone:</label>
<input 
       name="phone"
       type="tel"
       value="{{ old('username', $user->phone) }}"
       class=" block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('phone') border-red-500 @enderror">
 @error('phone')
     <p class="text-red-500 text-xs italic mt-4">
         {{ $message }}
     </p>
     @enderror
<label for="password" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Password:</label>
 <input  type="password" 
         class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('password') border-red-500 @enderror"
         name="password" >
  @error('password')
      <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
      </p>
      @enderror
<label for="password_confirmation" class="mt-2 block text-slate-200 text-sm mb-1 font-bold ">Confirm password:</label>
 <input  type="password" 
         class="block  w-full rounded-lg p-2 border-2 text-white  bg-transparent @error('password_confirmation') border-red-500 @enderror"
         name="password_confirmation" >
@error('password_confirmation')
<p class="text-red-500 text-xs italic mt-4">
  {{ $message }}
</p>
@enderror
<div class="flex flex-col ">
  <label for="roles" class="mt-2 block text-slate-200 text-sm mb-1 font-bold">Roles:</label>
  @foreach ($roles as $role)  
  @php
$selectedRole = $user->roles->first()?->name;
@endphp
    <label class="mr-4 text-white">
      <input type="radio" name="roles" value="{{ $role->name }}" class="mr-1" {{$selectedRole === $role->name ? 'checked' : ''}}>
      {{ ucfirst($role->name) }}
    </label>
  @endforeach
</div>
@if($selectedRole === \App\Enums\UserRole::USER->value)
<label for="permissions" class="text-white">Permissions:</label>
<div class="flex flex-col h-52 overflow-y-auto">
@foreach ($permissions as $module => $modulePermissions)
    <div class="mb-4">
        <h3 class="text-white font-bold mb-2">{{ $module }}</h3>
        <div class="flex flex-wrap gap-2">
            @foreach ($modulePermissions as $permission)
                <label class="text-white mr-4">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                        {{ $user->hasPermission($permission->name) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </label>
            @endforeach
        </div>
    </div>
@endforeach
</div>
@endif
<button type="submit" class="w-42 bg-green-700  text-slate-200 py-2 px-5 rounded-lg font-bold capitalize mb-6 mt-6 text-center cursor-pointer">Update</button>
</form> 
<button id="closeEditModel-{{ $user->id }}" class=" bg-transparent border-2 text-slate-200 py-2 px-5 rounded-lg font-bold capitalize hover:border-gray-500 transition duration-300 mt-2">Cancel</button>
</div>
</div>

