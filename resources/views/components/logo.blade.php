
<!-- logo -->
<div   {{ $attributes->class([
        'inline-flex',
        'font-black',
        'tracking-tight',
        'shadow-md',
    ]) }}
       onclick="window.location.href='{{ route('home') }}'">
  <span class="px-2 py-1 bg-gradient-to-r from-white to-gray-100 text-black rounded-l-md shadow-sm">
    My
  </span>
  <span class="px-2 py-1 bg-gradient-to-r from-black to-gray-800 text-white rounded-r-md shadow-sm">
    Blog4U
  </span>
</div>