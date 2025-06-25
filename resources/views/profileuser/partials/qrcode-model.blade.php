<div id="qrModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
  <div class="bg-white p-6 rounded-lg shadow-xl w-80 relative text-center">
    <h2 class="text-lg font-semibold mb-4">Your QR Code</h2>

    <div id="qrContainer" class="flex items-center justify-center mb-4">
      <img id="qrImage" src="{{route('qr-code.image')}}" alt="QR Code" class="w-48 h-48 object-contain">
    </div>

    <div class="flex justify-center gap-4">
      <a id="downloadQrBtn" href="#" download class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Download</a>
      <button onclick="closeQrModal()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</button>
    </div>
  </div>
</div>
@push('scripts')
<script>
   function openQrModal() {
    const modal = document.getElementById('qrModal');
    const qrImage = document.getElementById('qrImage');
    const downloadBtn = document.getElementById('downloadQrBtn');
    const imageUrl = qrImage.src;

    downloadBtn.href = imageUrl;

    downloadBtn.setAttribute('download', 'qr-code.png');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeQrModal() {
    const modal = document.getElementById('qrModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endpush