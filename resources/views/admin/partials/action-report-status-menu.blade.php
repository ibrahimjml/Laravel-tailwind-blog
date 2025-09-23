{{-- show statuses not in db --}}
  @php /** @var \App\Models\PostReport $report */ @endphp
  @php
      $availableStatuses = collect(\App\Enums\ReportStatus::cases())
              ->filter(fn($status) => $status->value !== $report->status->value);
    @endphp
<div class="statusmodel absolute -top-12 right-0 z-10 w-36 bg-white border border-black rounded-lg px-2 py-4 space-y-2 hidden">
  @foreach($availableStatuses as $status)
  <button  onclick="updateStatus('{{ $report->id }}', '{{ $status->value }}', '{{$type}}')"
         @class([
            'block font-semibold w-full rounded-md pl-3 hover:text-white transition-all duration-150 cursor-pointer',
            'hover:bg-green-600'  => $status === \App\Enums\ReportStatus::Reviewed,
            'hover:bg-yellow-600' => $status === \App\Enums\ReportStatus::Pending,
            'hover:bg-red-600'    => $status === \App\Enums\ReportStatus::Rejected,
           ])>
      {{ ucfirst($status->value) }}
    </button>
    @if(!$loop->last)<hr>@endif
  @endforeach
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.body;

  container.addEventListener('click', (e) => {
    document.querySelectorAll('.statusmodel').forEach(menu => menu.classList.add('hidden'));


    if (e.target.closest('.toggle-menu')) {
      const wrapper = e.target.closest('.relative, .inline-block');
      const menu = wrapper.querySelector('.statusmodel');
      menu.classList.toggle('hidden');
      e.stopPropagation();
    }
  });

});
</script>
<script>
function updateStatus(reportId, newStatus, type) {
  if (!confirm(`Change status to ${newStatus}?`)) return;
   let url = '';

   if(type === 'post'){
    url = `/admin/postreports/toggle/${reportId}/status`;
   } else if(type ==='profile'){
    url = `/admin/profilereports/toggle/${reportId}/status`;
   } else {
    alert('Invalid report type');
    return;
   }
   
  fetch(url, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({ status: newStatus }),
  })
   .then(res => {
    if (!res.ok) throw new Error('Failed to update');
    return res.json(); 
  })
  .then(data => {
   if (data.updated) {
        toastr.success(data.message);
        setTimeout(() => location.reload(), 1000); 
    } else {
        toastr.error(data.message);
    }
  })
  .catch(() => alert('Error updating status'));
}
</script>
@endpush