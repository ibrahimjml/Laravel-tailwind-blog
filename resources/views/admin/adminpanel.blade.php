<x-header-blog/>
<main class="admin w-screen   grid grid-cols-[25%,75%] transition-all ease-in-out duration-300 p-5">
<x-admin-sidebar/>
  <section id="main-section" class="p-5 transition-all ease-in-out duration-300 ">
  
    <div class="top-section flex gap-5">
      <span id="spn" class="text-4xl text-gray-400  cursor-pointer">&leftarrow;</span>
      <h2 id="title-body" class="text-black text-2xl font-bold p-3">Admin Panel</h2>
    </div>
    <div class="flex  items-center gap-2 flex-wrap">
      <x-widgets-posts 
      :posts="$post" 
      :hashtags="$hashtags"
      :likes="$likes"
      :comments="$comments"/>
    </div>
    <div class="flex  items-center gap-2 flex-wrap mt-3">
      <x-widgets-users :users="$user" :blocked="$blocked"/>
    </div>
  </section>
</main>
<x-footer/>

