<div id="sidebar-menu" class="fixed hidden inset-0 z-50 opacity-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out">
  
  <div id="content-menu" class="relative h-[100vh] w-screen md:w-[40%] overflow-x-hidden bg-white overflow-y-auto shadow-xl translate-x-[-110vw] transition-all duration-300 ease-in-out">
  <span id="close-menu" title="close" class="cursor-pointer absolute top-4 right-4 text-xl">
    <i class="fas fa-times"></i>
  </span>
    <div class="block mt-4  p-6">
        <!-- Popular Tags Section -->
        @include('blog.popular-tags')
        <!-- Categories Section -->
        @include('blog.categories')
        <!-- Who To Follow Section -->
        @include('blog.whotofollow')
      </div>

  </div>
</div>

<!-- begin script -->
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const openSidebar = document.getElementById('open-sidebar');
    const closeSidebar = document.getElementById('close-menu');
    const contentMenu = document.getElementById('content-menu');
    const sidebarMenu = document.getElementById('sidebar-menu');
  
    openSidebar.addEventListener('click', () => {
      document.body.classList.add('no-scroll');

      sidebarMenu.classList.remove('hidden');
      setTimeout(() => {
        sidebarMenu.classList.add('opacity-100');
        sidebarMenu.classList.remove('opacity-0');

        contentMenu.classList.remove('translate-x-[-110vw]');
      contentMenu.classList.add('translate-x-[0]');
      }, 10); 
    });
  
    closeSidebar.addEventListener('click', () => {
      document.body.classList.remove('no-scroll');
      
      sidebarMenu.classList.remove('opacity-100');
      sidebarMenu.classList.add('opacity-0');
  
      contentMenu.classList.remove('translate-x-[0]');
      contentMenu.classList.add('translate-x-[-110vw]');
  
      setTimeout(() => {
        sidebarMenu.classList.add('hidden');
      }, 300); 
    });

    // Close sidebar 
    sidebarMenu.addEventListener('click', (e) => {
      if (e.target === sidebarMenu) {
        closeSidebar.click();
      }
    });
  });
  </script>
@endpush