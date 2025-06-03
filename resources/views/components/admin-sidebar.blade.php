<ul class="md:flex-col md:min-w-full flex flex-col list-none">
  <li class="items-center">
    <a href="{{route('admin.users')}}" class="text-sm uppercase py-3 font-bold block {{ Route::is('admin.users') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-user mr-2 text-sm opacity-75"></i>
      Users
    </a>
  </li>

  <li class="items-center">
    <a href="{{route('admin.posts')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is(patterns: 'admin.posts') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-image mr-2 text-sm opacity-75"></i>
      Posts
    </a>
  </li>

  <li class="items-center">
    <a href="{{route('hashtagpage')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('hashtagpage') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-tag mr-2 text-sm opacity-75"></i>
      Tags
    </a>
  </li>
  <li class="items-center">
    <a href="{{route('roles.index')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('featuredpage') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-user-cog mr-2 text-sm opacity-75"></i>
      Roles
    </a>
  </li>
    <li class="items-center">
    <a href="{{route('permissions.index')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('featuredpage') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-user-cog mr-2 text-sm opacity-75"></i>
      Permissions
    </a>
  </li>
  <li class="items-center">
    <a href="{{route('featuredpage')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('featuredpage') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-star mr-2 text-sm opacity-75"></i>
      Featured
    </a>
  </li>

  <li class="items-center">
    <a href="{{route('admin-page')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('admin-page') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-home mr-2 text-sm opacity-75"></i>
      Admin
    </a>
  </li>

  <li class="items-center">
    <a href="{{route('admin.notify')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('admin.notify') ? 'text-blue-500 hover:text-blue-600' : ''}}">
       <span class="text-sm relative">
        <i class="fas fa-bell"></i>
        <small class="absolute top-[-6px] left-2 h-4 w-4 bg-blue-500 text-white flex justify-center items-center rounded-full p-1 text-xs"> 
          {{ auth()->user()->unreadNotifications->count() }}
        </small>
      <p class="ml-3 inline-block">Notifications</p>
      </span>

    </a>
  </li>
</ul>
  <!-- Divider -->
 <hr class="my-4 md:min-w-full" />

  <h6 class="md:min-w-full text-blueGray-500 text-sm uppercase font-bold block pt-1 pb-4 no-underline">
            Site
          </h6>
  <ul class="md:flex-col md:min-w-full flex flex-col list-none">
    <li class="items-center">
     <a href="{{route('home')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('home') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-globe mr-2 text-sm opacity-75"></i>
      View Site
    </a>
    </li>
    <li class="items-center">
     <a href="{{route('admin.settings')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('admin.settings') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-cog mr-2 text-sm opacity-75"></i>
      Settings
    </a>
    </li>
    <li class="items-center">
     <a href="{{route('logout')}}"
      class="text-sm uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500 {{ Route::is('logout') ? 'text-blue-500 hover:text-blue-600' : ''}}">
      <i class="fas fa-sign-out-alt mr-2 text-sm opacity-75"></i>
      Log out
    </a>
    </li>
  </ul>