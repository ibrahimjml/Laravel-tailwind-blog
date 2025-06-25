<div id="reportsmodel" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
 <div class="relative bg-white h-2/4 rounded-lg p-6 w-full max-w-2xl ">
  <p class="font-bold text-lg mb-4">Report this post. What's wrong ?</p>
<form action="{{route('post.report',$post->id)}}" method="POST">
  @csrf
  @method('POST')
    @foreach ($reasons as $reason)
        <div class="flex gap-2 items-center">
          <input type="radio" name="report_reason" value="{{$reason['value']}}" class="reason cursor-pointer">
          <span>{{$reason['value']}}</span>
        </div>
    @endforeach
   <textarea disabled id="other" name="other" class="border-0 w-full mt-2 p-2 rounded-lg bg-gray-100 cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400" rows="4" placeholder="Describe your reason .if other"></textarea>
   <button disabled id="submit" type="submit" class="block p-1 px-2 mt-2 text-white font-bold rounded-full bg-blue-500 disabled:bg-blue-300 cursor-not-allowed">
    Submit
   </button>
  </form>
  <button id="close-reports-modal" class="absolute top-1 right-3 text-lg mt-4 text-black"><i class="fas fa-times"></i></button>
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
    const more = document.getElementById('moremodel');
    const reportsmodel = document.getElementById('reportsmodel');
    const closereportsmodel = document.getElementById('close-reports-modal');

   if(!more.classList.contains('hidden')) more.classList.add('hidden');
   reportsmodel.classList.remove('hidden');

 closereportsmodel.addEventListener('click',()=>{
  reportsmodel.classList.add('hidden');
 })
  }
</script>

@endpush