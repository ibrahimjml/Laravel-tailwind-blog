@php
 use App\Enums\ReportReason;
@endphp
<div id="reportprofilemodel" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
 <div class="relative bg-white h-2/4 rounded-lg p-6 w-full max-w-2xl ">
  <p class="font-bold text-lg mb-4 text-left">Report for profile <b class="text-red-500">{{'@'.$user->username}}</b> What's wrong ?</p>
<form action="{{route('profile.report',$user->username)}}" method="POST">
  @csrf
  @method('POST')
    @foreach (ReportReason::profileReasons() as $reason)
  <div class="flex gap-2 items-center">
    <input type="radio" name="report_reason" value="{{ $reason->value}}" class="reason cursor-pointer">
    <span>{{ $reason->label() }}</span>
  </div>
@endforeach
   <textarea disabled id="other" name="other" class="border-0 w-full mt-2 p-2 rounded-lg bg-gray-100 cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400" rows="4" placeholder="Describe your reason .if other"></textarea>
   @error('other')
   <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
   @enderror
   <button disabled id="submit" type="submit" class="block p-1 px-2 mt-2 text-white font-bold rounded-full bg-blue-500 disabled:bg-blue-300 cursor-not-allowed">
    Submit
   </button>
  </form>
  <button id="close-report-modal" class="absolute top-1 right-3 text-lg mt-4 text-black"><i class="fas fa-times"></i></button>
  </div>
</div>
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const radiobtns = document.querySelectorAll('.reason');
    const textarea = document.getElementById('other');
    const submit = document.getElementById('submit');

    radiobtns.forEach(radio => {
      radio.addEventListener('change', function () {
        submit.disabled = false;
        submit.classList.remove("bg-blue-300", "cursor-not-allowed");
        if (this.value === "Other") {
          textarea.disabled = false;
          textarea.classList.remove("text-gray-400", "cursor-not-allowed");
          textarea.focus();
        } else {
          textarea.disabled = true;
          textarea.classList.add("text-gray-400", "cursor-not-allowed");
          textarea.value = ""; 
        }
      });
    });
  });
</script>
{{-- open report menu --}}
<script>
  function openReort(){
    const reportsmodel = document.getElementById('reportprofilemodel');
    const closereportsmodel = document.getElementById('close-report-modal');

   reportsmodel.classList.remove('hidden');

 closereportsmodel.addEventListener('click',()=>{
  reportsmodel.classList.add('hidden');
 })
  }
</script>

@endpush