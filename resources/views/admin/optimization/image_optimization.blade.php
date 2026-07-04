@extends('admin.partials.layout')
@section('title', 'Image optimization | Dashboard')
@section('content')
  <!-- Header -->
  @include('admin.partials.header', ['linktext' => 'Image Optimization', 'route' => 'admin.optimize.image.optimization', 'value' => request('search')])

  <div class="md:ml-64 w-full mx-auto transform -translate-y-48">
    <div class="flex flex-wrap">
      <div class="w-full lg:w-8/12 px-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
          <div class="rounded-t bg-white mb-0 px-6 py-6">
            <div class="text-center flex justify-between">
              <h6 class="text-blueGray-700 text-xl font-bold">
                Image Optimization
              </h6>

            </div>
          </div>
          {{-- image optimization settings --}}
          <form id="actionForm" action="{{ route('admin.optimize.image.optimization.update') }}" method="POST"
            class="flex-auto px-4  lg:px-10 py-10 pt-0 ">
            @csrf
            @method('PUT')
            <h6 class="text-blueGray-400 text-sm mt-3 mb-2 font-bold uppercase">
              Optimization Settings
            </h6>
            <p class="text-sm text-blueGray-400">Powered by Laravel Intervention Package.</p>
            <div class="rounded-lg p-5 w-full mt-3 flex justify-between items-center border-2 border-gray-300">
              <div class="">
                <p class="text-lg font-bold">Enable Image Optimization</p>
                <p class="text-xs text-blueGray-400 mt-1">If disabled, images will be uploaded exactly as users submit them (which may drain server storage quickly).</p>
              </div>
              <div class="">
                <input type="hidden" name="enable_image_optimization" value="0">
                <x-toggle name="enable_image_optimization" value="1" :checked="$settings['enable_image_optimization'] ?? true"
                  onchange="openImageSettings(this)" />
              </div>
            </div>
            <div id="image-settings-section" class="{{ ($settings['enable_image_optimization'] ?? true) ? '' : 'hidden' }} ">
              <div class="flex flex-col md:flex-row items-center gap-4">
                <div 
                {{-- output format --}}
                  class=" rounded-lg p-5 w-full mt-3 border-2 border-gray-300 h-fit">
                  <p class="text-lg font-bold mb-3"><i class="fas fa-file-image mr-2"></i>Output Format</p>
                  <select name="image_output_format" id="output_format" class="pl-3 pr-8 appearance-none font-bold cursor-pointer bg-blueGray-200 text-blueGray-500 border-0 text-sm rounded-lg p-2.5">
                    @foreach(\App\Enums\ImageTypes::cases() as $imageType)
                      <option value="{{ $imageType->value }}" {{ ($settings['image_output_format'] ?? \App\Enums\ImageTypes::WEBP->value) === $imageType->value ? 'selected' : '' }}>
                        {{ $imageType->label() }}
                      </option>
                    @endforeach
                  </select>
                </div>
                {{-- Compression quality --}}
                <div class=" rounded-lg p-5 w-full mt-3 border-2 border-gray-300 h-full">
                
                  <div class="flex justify-between items-center ">
                    <p class="text-lg font-bold mb-3"><i class="fas fa-compress mr-2"></i>Compression Quality</p>
                    <span id="qualityValue" class="font-bold text-blue-600 p-2 rounded-lg bg-blue-200"></span>
                  </div>
                  <input type="range" id="qualityRange" name="image_compression_quality" min="0" max="100" value="{{ $settings['image_compression_quality'] ?? 80 }}" class="w-full">
                  <p class="text-xs text-blueGray-400 mt-1">80% is the "Sweet Spot". Below 60% may cause visible pixelation..</p>
                
                </div>
              </div>
              {{-- image upload size --}}
                <div class=" rounded-lg p-5 w-full mt-3 border-2 border-gray-300 h-full">
                    <p class="text-lg font-bold mb-3"><i class="fas fa-compress mr-2"></i>Max image upload size (MB)</p>
  
                  <input type="number"  name="image_max_upload_size"  step="0.01" value="{{ $settings['image_max_upload_size'] ?? 5 }}" class="w-full">
                  <p class="text-xs text-blueGray-400 mt-1">Set the maximum size for uploaded images in megabytes.</p>
                
                </div>
            </div>
             @can('imageoptimization.update')
            <button
              class="block bg-green-500 ml-auto mt-2 w-fit text-white active:bg-gray-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
              type="submit">
              <i class="fas fa-save mr-2"></i>
              Save preferences
            </button>  
            @endcan
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const range = document.getElementById('qualityRange');
    const value = document.getElementById('qualityValue');

    function updateValue() {
        value.textContent = range.value + '%';
    }

    updateValue(); 
    range.addEventListener('input', updateValue);

  
});
</script>
<script>
    // open when enabled image optimization
    function openImageSettings(toggle) {
      console.log(toggle.checked);
      const imageSettingsSection = document.getElementById('image-settings-section');
      if (!toggle.checked) imageSettingsSection.classList.add('hidden');
      else imageSettingsSection.classList.remove('hidden');
      }
</script>
@endpush