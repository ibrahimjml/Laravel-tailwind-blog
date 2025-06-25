@props([
  'top' =>'top-10',
  'right' =>'-right-6',
])
<div
  id="sharemodel"
  class="absolute {{$top}} {{$right}} z-10 w-36 h-fit rounded-lg bg-slate-50 px-2 py-4 space-y-2 hidden">
<button onclick="copyPermalink(window.location.href)" class="block text-left text-sm font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200 transition-all duration-150">
    <i class="fas fa-link text-black"></i> Permalink
  </button>
<a
  onclick="shareTo('linkedin')"
  href="#"
  class="block text-left text-sm font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200 transition-all duration-150">
  <i class="fab fa-linkedin text-blue-500"></i> LinkedIn
</a>
  <a 
   onclick="shareTo('whatsapp')"
   href="#"
   class="block text-left text-sm font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200 transition-all duration-150">
   <i class="fab fa-whatsapp text-green-600"></i> WhatsApp
</a>
  <a 
   onclick="shareTo('twitter')"
   href="#"
   class="block text-left text-sm font-semibold capitalize w-full rounded-md pl-3 hover:bg-gray-200 transition-all duration-150">
   <i class="fab fa-twitter text-blue-500"></i> Twitter
</a>
</div>
  @push('scripts')
  <script>
  function toggleShareMenu() {
    const menu = document.getElementById('sharemodel');
    menu.classList.toggle('hidden');
  }
  </script>
  <script>
function shareTo(platform) {
    const url = encodeURIComponent(window.location.href);

    let shareUrl = '#';

    switch (platform) {
      case 'linkedin':
        shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}`;
        break;
      case 'whatsapp':
        shareUrl = `https://wa.me/?text=${url}`;
        break;
      case 'twitter':
        shareUrl = `https://twitter.com/intent/tweet?url=${url}`;
        break;
    }

    window.open(shareUrl, '_blank');
  }
</script>
  <script>
  function copyPermalink(url) {
    navigator.clipboard.writeText(url).then(() => {
      toastr.options = {
          "closeButton": true,
          "progressBar": true,
          "positionClass": "toast-bottom-right",
          "timeOut": 2000
        };
        toastr.success("Copied To Clibboard");
    });
  }
</script>
  @endpush