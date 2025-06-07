<form action="{{route('blog.search')}}" id="search-form"  method="GET">
   @if(request()->has('sort'))
    <input type="hidden" name="sort" value="{{ request('sort') }}">
  @endif
  <input type="text" name="search" 
  id="search-input"
  placeholder="Search...by tags,posts"
  value="{{$searchquery ?? ''}}"
  class=" w-full sm:w-[280px]  border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500 placeholder:text-gray-400 text-sm"
/>
</form>
<div id="applied-filter" class="mt-2 {{ $searchquery ? 'block' : 'hidden' }}">
  <span class="text-sm text-gray-700">Filtering by: <strong>{{ $searchquery }}</strong></span>
  <button id="reset-filter" class="ml-2 text-sm text-gray-500">Clear</button>
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


  resetFilterButton.addEventListener('click', function () {
  searchInput.value = ''; 
  appliedFilter.classList.add = 'hidden';  
  searchForm.submit();
  window.location.href = '/blog';
});

});


</script>
@endpush
