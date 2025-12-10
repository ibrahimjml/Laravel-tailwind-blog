<form action="{{route('blog.search')}}" id="search-form"  method="GET" class="w-full">
   @if(request()->has('sort'))
    <input type="hidden" name="sort" value="{{ request('sort') }}">
  @endif
  <div class="relative">
    <input type="text" name="search" 
    id="search-input"
    placeholder="Search posts & tags..."
    value="{{$searchquery ?? ''}}"
    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent placeholder:text-gray-400 text-sm transition-all duration-200"
    />
    <i class="fas fa-search absolute right-3 top-3 text-gray-400 text-sm pointer-events-none"></i>
  </div>
</form>
<div id="applied-filter" class="mt-2 {{ $searchquery ? 'block' : 'hidden' }}">
  <span class="text-xs text-gray-600 font-medium">Searching for: <strong class="text-gray-800">{{ $searchquery }}</strong></span>
  <button id="reset-filter" type="button" class="ml-2 text-xs text-gray-500 hover:text-gray-700 transition-colors">✕ Clear</button>
</div>
@push('scripts')
    
<script>
  document.addEventListener('DOMContentLoaded', function () {

  const searchInput = document.getElementById('search-input');
  const searchForm = document.getElementById('search-form');
  const appliedFilter = document.getElementById('applied-filter');
  const resetFilterButton = document.getElementById('reset-filter');


  searchInput.addEventListener('input', function () {
  
    searchForm.submit();  
  });


  resetFilterButton.addEventListener('click', function (e) {
    e.preventDefault();
  searchInput.value = ''; 
  appliedFilter.classList.add('hidden');  
  searchForm.submit();
  window.location.href = '/blog';
});

});


</script>
@endpush
