@php
$selectedRole = $user->roles->first()?->name;
@endphp
<form action="{{route('role.update', $user)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="relative w-full">
        <select name="role"
        onchange="this.form.submit()"
        class="pl-3 pr-8 appearance-none font-bold border-0 cursor-pointer bg-blueGray-200 text-blueGray-500 text-sm rounded-lg w-full p-2.5">
         @foreach ($roles as $role)
        <option value="{{ $role->name }}" {{ $selectedRole === $role->name ? 'selected' : '' }}>
        {{ $role->name }}
        </option>
      @endforeach
        </select>
        <!-- white arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-blueGray-500">
        <i class="fas fa-caret-down text-blueGray-500"></i>
        </svg>
        </div>
      </div>
      </form>