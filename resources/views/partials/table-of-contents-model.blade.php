<div id="view-toc" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="relative bg-white h-2/4 rounded-lg p-6 w-full max-w-2xl overflow-y-auto">
    <div id="toc2-container" class="space-y-2 text-sm sticky top-8 p-4 bg-white border rounded shadow-sm">
       <p class="font-bold mb-4">Table Of Contents</p>
       <ul id="toc-links" class="space-y-2"></ul>
    </div>
    <button id="close-toc" class="absolute top-1 right-3 text-lg mt-4 text-black"><i class="fas fa-times"></i></button>
  </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('view-toc');
  const openBtn = document.querySelector('.open-tocmodel');
  const tocContainer = document.getElementById('toc2-container');
  const closebtn = document.getElementById('close-toc');

  const content = document.querySelector('.published-content');
  const headings = content?.querySelectorAll('h1, h2, h3, h4');
  const divider = document.getElementById('divider');
  if (headings && headings.length > 0) {
    openBtn.classList.remove('hidden');
    divider.classList.remove('hidden');
  }

  openBtn.addEventListener('click', () => {
    TocLinks();
    modal.classList.remove('hidden');
  });

  closebtn.addEventListener('click', () => {
    modal.classList.add('hidden');
  });

  modal.addEventListener('click', e => {
    if (e.target === modal) modal.classList.add('hidden');
  });

  function TocLinks() {
    const tocLinks = document.getElementById('toc-links');
    tocLinks.innerHTML = ''; 

    headings.forEach((heading, i) => {
      const id = heading.id || `heading-${i}`;
      heading.id = id;

      const li = document.createElement('li');
      li.className = 'px-3 rounded-full hover:bg-gray-500 hover:text-white transition-bg duration-200-ease';

      const a = document.createElement('a');
      a.href = `#${id}`;
      a.textContent = heading.textContent;
      a.className = 'block text-sm';

      a.addEventListener('click', e => {
        e.preventDefault();
        document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
        modal.classList.add('hidden');
      });

      li.appendChild(a);
      tocLinks.appendChild(li);
    });
  }
});
</script>

@endpush