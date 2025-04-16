<x-header-blog>
<main class="admin w-screen   grid grid-cols-[25%,75%] transition-all ease-in-out duration-300 p-5">
<x-admin-sidebar/>
  <section id="main-section" class="p-5 transition-all ease-in-out duration-300 ">
  
    <div class="top-section flex gap-5">
      <span id="spn" class="text-4xl text-gray-400  cursor-pointer">&leftarrow;</span>
      <h2 id="title-body" class="text-black text-2xl font-bold p-3">Admin Panel</h2>
    </div>
    <div class="flex flex-wrap gap-2 md:flex-nowrap items-center ">

      <x-widgets-posts 
      :posts="$post" 
      :hashtags="$hashtags"
      :likes="$likes"
      :comments="$comments"/>
      <x-widgets-users :users="$user" :blocked="$blocked"/>
    </div>
  </section>
</main>
<x-footer/>
</x-header-blog>
