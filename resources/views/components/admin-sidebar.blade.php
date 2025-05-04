<aside id="sidebar" class="border-2 border-gray-600  rounded-lg transition-all ease-in-out duration-300">
  <div class="w-full h-[10%] bg-gray-600 text-white text-2xl font-semibold text-center flex justify-center items-center capitalize transition-opacity duration-300">
    admin panel
  </div>
  
  <div class="flex flex-col items-center justify-start gap-6 mt-6 transition-opacity duration-300">
    <a href="{{route('admin.users')}}" class="{{ (Route::is('admin.users')) ? 'bg-gray-600 text-white h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium rounded-md text-center cursor-pointer' : 'h-12 w-48 capitalize text-xl font-medium bg-gray-400 text-white flex justify-center items-center gap-10 rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-gray-600 active:scale-95' }}">
      <span class="text-xl">
        <i class="fa-regular fa-user"></i>
      </span>
      <span>Users</span>
    </a>
  
    <a href="{{route('admin.posts')}}" class="{{ (Route::is('admin.posts')) ? 'bg-gray-600 text-white h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium rounded-md text-center cursor-pointer' : 'h-12 w-48 capitalize text-xl font-medium bg-gray-400 text-white flex justify-center items-center gap-10 rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-gray-600 active:scale-95' }}">
      <span class="text-xl">
        <i class="fa-solid fa-image"></i>
      </span>
      <span>Posts</span>
    </a>
  
    <a href="{{route('hashtagpage')}}" class="{{ (Route::is('hashtagpage')) ? 'bg-gray-600 text-white h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium rounded-md text-center cursor-pointer' : 'h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium bg-gray-400 text-white rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-gray-600 active:scale-95' }}">
      <span class="text-xl">
        <i class="fa-solid fa-tag"></i>
      </span>
      <span>Tags</span>
    </a>
  
    <a href="{{route('featuredpage')}}" class="{{ (Route::is('featuredpage')) ? 'bg-gray-600 text-white h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium rounded-md text-center cursor-pointer' : 'h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium bg-gray-400 text-white rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-gray-600 active:scale-95' }}">
      <span class="text-xl">
        <i class="fa-solid fa-star"></i>
      </span>
      <span>feature</span>
    </a>
  
    <a href="{{route('admin-page')}}" class="{{ (Route::is('admin-page')) ? 'bg-gray-600 text-white h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium rounded-md text-center cursor-pointer' : 'h-12 w-48 capitalize flex justify-center items-center gap-10 text-xl font-medium bg-gray-400 text-white rounded-md text-center cursor-pointer transition-colors duration-200 hover:bg-gray-600 active:scale-95' }}">
      <span class="text-xl">
        <i class="fa-solid fa-house"></i>
      </span>
      <span>Admin</span>
    </a>
  </div>
</aside>
