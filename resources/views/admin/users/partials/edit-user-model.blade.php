<div id="editModel-{{ $user->id }}" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

    <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[60vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Edit {{ $user->name }}</h2>
      <button id="closeEditModel-{{ $user->id }}" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>

     <!-- Modal Body -->
    <div class="p-6 overflow-y-auto">
        @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-700">
          <ul class="list-disc ml-5">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

 <form  action="{{route('admin.users.update',$user->id)}}" method="POST" class="space-y-6">
 @csrf
 @method("PUT")
   <!-- Form Fields -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
          @error('name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username:</label>
          <input type="text" name="username" value="{{ old('username', $user->username) }}"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('username') border-red-500 @enderror">
          @error('username')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
          <input type="text" name="email" value="{{ old('email', $user->email) }}"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
          @error('email')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age:</label>
          <input type="number" name="age" value="{{ old('age', $user->age) }}"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('age') border-red-500 @enderror">
          @error('age')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Phone:</label>
          <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-500 @enderror">
          @error('phone')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password:</label>
          <input type="password" name="password"   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
          @error('password')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm password:</label>
          <input type="password" name="password_confirmation"   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('password_confirmation') border-red-500 @enderror">
          @error('password_confirmation')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <!-- Roles -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Roles:</label>
          <div class="mt-2 space-x-4">
            @foreach ($roles as $role)
              @php
              $selectedRole = $user->roles->first()?->name;
              @endphp
              <label class="inline-flex items-center text-gray-600">
                <input type="radio" name="roles" value="{{ $role->name }}" {{$selectedRole === $role->name ? 'checked' : ''}} class="mr-1 text-indigo-600 focus:ring-indigo-500">
                {{ ucfirst($role->name) }}
              </label>
            @endforeach
          </div>
        </div>

        <!-- Permissions -->
        @if($selectedRole === \App\Enums\UserRole::USER->value)
        <div>
          <label class="block text-sm font-medium text-gray-700">Permissions:</label>
          <div class="mt-2 p-3 border border-gray-200 rounded-md max-h-52 overflow-y-auto space-y-4">
            @foreach ($permissions as $module => $modulePermissions)
              <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2">{{ $module }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                  @foreach ($modulePermissions as $permission)
                    <label class="flex items-center text-sm text-gray-600 font-normal">
                      <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $user->hasPermission($permission->name) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                      {{ $permission->name }}
                    </label>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
       @endif
      <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Edit User
            </button>
        </div>
</form> 
</div>
</div>
</div>