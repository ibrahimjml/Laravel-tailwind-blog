<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex h-full items-center justify-center">
 <div class="relative bg-white h-2/4 rounded-lg p-6 w-full max-w-2xl ">
  <p class="font-bold text-lg mb-4">Report this post. What's wrong ?</p>
<form action="{{ route('comment.report',$comment->id) }}" method="POST" class="report-form">
  @csrf
  @method('POST')
  @foreach (\App\Enums\ReportReason::commentReasons() as $reason)
    <div class="flex gap-2 items-center">
      <input type="radio" name="report_reason" value="{{ $reason->value }}" 
             class="reason cursor-pointer">
      <span>{{ $reason->label() }}</span>
    </div>
  @endforeach
  <textarea disabled name="other" class="other border-0 w-full mt-2 p-2 rounded-lg bg-gray-100 cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400" rows="4" placeholder="Describe your reason if other"></textarea>
  @error('other')
  @enderror
  <button disabled type="submit" class="submit block p-1 px-2 mt-2 text-white font-bold rounded-full bg-blue-500 disabled:bg-blue-300 cursor-not-allowed">
    Submit
  </button>
</form>
  <button class="close-reports-modal absolute top-1 right-3 text-lg mt-4 text-black"><i class="fas fa-times"></i></button>
  </div>
</div>

@push('scripts')
<script>
function openReport(id) {
  const modal = document.getElementById(id);
  modal.classList.remove('hidden');

  const closeBtn = modal.querySelector('.close-reports-modal');
  const reasons = modal.querySelectorAll('.reason');
  const other = modal.querySelector('.other');
  const submitBtn = modal.querySelector('.submit');

  reasons.forEach(reason => {
    reason.addEventListener('change', () => {
      submitBtn.disabled = false;
      submitBtn.classList.remove('cursor-not-allowed','bg-blue-300');

      if (reason.value === 'other') {
        other.disabled = false;
        other.classList.remove('cursor-not-allowed','bg-gray-100','text-gray-400');
      } else {
        other.disabled = true;
        other.value = '';
        other.classList.add('cursor-not-allowed','bg-gray-100','text-gray-400');
      }
    });
  });

  const closeHandler = () => {
    modal.classList.add('hidden');
    closeBtn.removeEventListener('click', closeHandler);
  };
  closeBtn.addEventListener('click', closeHandler);
}

</script>
@endpush