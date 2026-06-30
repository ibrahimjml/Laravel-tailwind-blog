<div id="scraped-data" class="tab-panel hidden">
    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-700 mb-2">
              Scraped Data
          </h3>
          <button id="delete-scraped" data-delete-route="{{ route('admin.scraping.delete.data') }}" class="p-1 rounded-lg bg-red-100 text-red-500">
            <i class="fas fa-trash "></i>
            Clear All Scraped
          </button>
        </div>
        <div id="scraped-posts-container">
            @include('admin.scraping.partials.scraped-data-list')
        </div>
    </div>
</div>

@push('scripts')
  <script>
// delete scraped data
      const deleteButton = document.getElementById('delete-scraped');
      
        deleteButton.addEventListener('click', async () => {
          const route = deleteButton.dataset.deleteRoute;
          if (!route) return;
          if (!confirm(`Delete All Scraped Data ?`)) return;

          try {
            const response = await fetch(route, {
              method: 'DELETE',
              headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              }
            });

            const data = await response.json();
            if (!response.ok) {
              throw new Error(data.message || 'Delete failed');
            }

            if (window.toastr) toastr.success(data.message || 'Deleted');
            window.location.reload();
          } catch (err) {
            console.error(err);
            if (window.toastr) toastr.error(err.message);
            else alert(err.message);
          }
        });
      
// fetch ajax pagination    
document.addEventListener('click', async function(e) {
    const link = e.target.closest('#scraped-pagination a[href]');

    if (!link) return;

    e.preventDefault();

    try {

        const response = await fetch(link.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const html = await response.text();

        document.getElementById('scraped-posts-container').innerHTML = html;

    } catch (err) {
        console.error(err);
    }

});
</script>
@endpush