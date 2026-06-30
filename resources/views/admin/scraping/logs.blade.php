<div id="scraping-logs" class="tab-panel hidden">
  <div  class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
    <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-700 mb-2">
              Scraping Logs
          </h3>
          <button id="delete-logs" data-delete-route="{{ route('admin.scraping.delete.logs') }}" class="p-1 rounded-lg bg-red-100 text-red-500">
            <i class="fas fa-trash "></i>
            Clear All Logs
          </button>
        </div>
    <div id="logs-data-container">
      @include('admin.scraping.partials.logs-list')
    </div>
  </div>
</div>

@push('scripts')
  <script>
    // delete logs
      const deleteLogButton = document.getElementById('delete-logs');
      
        deleteLogButton.addEventListener('click', async () => {
          const route = deleteLogButton.dataset.deleteRoute;
          if (!route) return;
          if (!confirm(`Delete All Logs ?`)) return;

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
      
document.addEventListener('click', async function(e) {
    const link = e.target.closest('#logs-pagination a[href]');

    if (!link) return;

    e.preventDefault();

    try {

        const response = await fetch(link.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const html = await response.text();

        document.getElementById('logs-data-container').innerHTML = html;

    } catch (err) {
        console.error(err);
    }

});
</script>
@endpush