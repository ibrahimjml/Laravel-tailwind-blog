<div id="sources" class="tab-panel">
  <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
    <div class="flex justify-between items-center">
      <h3 class="font-semibold text-gray-700 mb-2">Sources</h3>
        <button id="openSourceModel" class="bg-blueGray-200 text-blueGray-500 py-2 px-5 rounded-lg font-bold capitalize">
          <i class="fas fa-plus-circle"></i>
          Create Source
        </button>
    </div>
    <x-tables.table id='' :headers="['#','Source','Type','Filters','Posts Scraped','Actions']" title="Scraping Sources Table" >
      @forelse($sources as $source)
      <tr>
        <td>{{ ($sources->currentPage() - 1) * $sources->perPage() + $loop->iteration }}</td>
        <td>
          <div class="flex justify-start items-center gap-4">
            <span>
              <img src="{{ $source->favicon_url }}" alt="{{ $source->title }}" width="26" height="26" class="rounded-full">
            </span>
            <div class="flex flex-col gap-2 ">
             <span class="font-bold">
              {{ $source->name }}
             </span>
             <span class="text-md font-thin text-blue-400">
              {{ $source->url }}
             </span>
            </div>
          </div>
        </td>
        <td><span class="p-1 rounded-md bg-gray-200 text-md">{{ $source->type->label() }}</span></td>
        <td>
          <span class="p-1 rounded-md bg-gray-200 text-sm">{{ $source->max_links ? 'MAX : ' . $source->max_links : '' }}</span>
          @if($source->skip_no_image )
          <i class="fas fa-image p-1 rounded-md bg-gray-200 text-sm"></i>
          @endif
        </td>
        <td>
          {{ $source->posts_count }}
        </td>
        <td>
          <div class="flex items-center gap-3">
            <form action="{{ route('admin.scraping.sources.run',$source) }}" method="POST">
              @csrf
              <button type="submit" class="crawl-btn">
                <i class="fas fa-play text-xs text-green-500"></i>
              </button>
            </form>
            <button data-update-route="{{ route('admin.scraping.sources.update',$source) }}"
                    data-sources='@json($sourcePayload[$source->id] ?? [])' 
                    class="edit-btn w-6 h-6 rounded-[50%] bg-slate-50 text-blue-500 hover:bg-opacity-65 transition-bg-opacity duration-100">
              <i class="fas fa-edit"></i>
            </button>
            <button data-delete-route="{{ route('admin.scraping.sources.destroy',$source) }}"
                   data-source-name="{{$source->name}}" 
                   class="delete-btn rounded-lg text-red-600 p-2  hover:text-red-300 transition-colors duration-100">
               <i class="fas fa-trash"></i>
             </button>
          </div>
        </td>
      </tr>
      @empty 
      <tr>
        <td colspan="7" class="p-4 text-center font-bold text-blueGray-500">No Sources found.</td>
      </tr>
      @endforelse
    </x-tables.table>
  </div>
</div>

@push('scripts')
  <script>
      const createModel = document.getElementById('openSourceModel');
      const closeModel = document.getElementById('closeModel');
      const menu = document.getElementById("SourceModel");

      if (createModel && closeModel && menu) {
        createModel.addEventListener('click', () => {
          if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
          }
        });

        closeModel.addEventListener('click', () => {
          if (menu.classList.contains('fixed')) {
            menu.classList.add('hidden');
          }
        });
      }
      // delete handler
      const deleteButtons = document.querySelectorAll('.delete-btn');
      deleteButtons.forEach((btn) => {
        btn.addEventListener('click', async () => {
          const route = btn.dataset.deleteRoute;
          const sourceName = btn.dataset.sourceName;
          if (!route) return;
          if (!confirm(`Delete this source ${sourceName}`)) return;

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
            btn.closest('tr')?.remove();
          } catch (err) {
            console.error(err);
            if (window.toastr) toastr.error(err.message);
            else alert(err.message);
          }
        });
      });
      </script>
@endpush      