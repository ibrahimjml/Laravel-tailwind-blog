@extends('admin.partials.layout')
@section('title', 'Cron Scrap | Dashboard')
@section('content')
  <!-- Header -->
  @include('admin.partials.header', ['linktext' => 'Setup Scrap Cron', 'route' => 'admin.scraping.setting.index', 'value' => request('search')])
  <div class="max-w-6xl mx-auto py-8 px-4 transform -translate-y-48">
    <div class="flex flex-wrap">
      <div class="w-full lg:w-10/12 mx-auto px-4 space-y-6">
        <!-- start/ Setup Scraping Configuration -->
        <div class="relative flex flex-col min-w-0 break-words w-full shadow-lg rounded-xl bg-white border border-gray-200">
          <div class="rounded-t mb-0 px-6 py-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
              <div>
                <h6 class="text-gray-800 text-xl font-bold flex items-center">
                  <i class="fas fa-clock mr-3 text-gray-600"></i>
                  Setup Scraping Configuration
                </h6>
                <p class="mt-2 text-sm text-gray-600">Configure cron to run scraping jobs automatically in the background.</p>
              </div>
              <form action="{{ route('admin.scraping.setting.force.run') }}" method="POST">
                @csrf
                <button
                  class="inline-flex items-center bg-black/70 text-white font-medium text-sm px-4 py-2 rounded-lg shadow hover:bg-black focus:outline-none transition"
                  type="submit">
                  <i class="fas fa-play mr-2"></i>
                  Force Run All
                </button>
              </form>
            </div>
          </div>

          <form action="{{ route('admin.scraping.setting.update') }}" method="POST" class="flex-auto px-6 lg:px-10 py-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
              <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 md:flex-row md:items-center md:justify-between">
                <div>
                  <p class="text-lg font-semibold text-gray-800">Enable Auto Schedule</p>
                  <p class="text-xs text-gray-500 mt-1">If <b>disabled</b>, hitting the cron link forces an instant run.</p>
                  <p class="text-xs text-gray-500 mt-1">If <b>enabled</b>, it respects the interval rules below.</p>
                </div>
                <div class="flex items-center space-x-4">
                  <input type="hidden" name="auto_scrap_enabled" value="0">
                  <x-toggle name="auto_scrap_enabled" value="1" :checked="$settings['auto_scrap_enabled'] ?? true" />
                </div>
              </div>

              <div class="rounded-xl border border-gray-200 bg-white p-4">
                <label for="crawl_frequency" class="block text-sm font-medium text-gray-700 mb-2">Crawl Frequency</label>
                <div class="relative">
                  <select id="crawl_frequency" name="crawl_frequency"
                    class="w-full pl-3 pr-8 appearance-none bg-gray-100 text-gray-700 border border-gray-200 text-sm rounded-lg py-2">
                    @foreach(\App\Enums\ScrapFrequency::cases() as $case)
                      <option value="{{ $case->value }}" @selected(old('crawl_frequency', $settings['crawl_frequency'] ?? '') == $case->value)>
                        {{ $case->label() }}
                      </option>
                    @endforeach
                  </select>

                  <p class="text-xs text-gray-500 mt-2">Applied only if 'Enable Auto Schedule' is enabled.</p>
                </div>
              </div>

              <div class="flex justify-end">
                <button
                  class="inline-flex items-center bg-green-600 text-white font-medium text-sm px-4 py-2 rounded-lg shadow hover:bg-green-700 focus:outline-none transition"
                  type="submit">
                  <i class="fas fa-save mr-2"></i>
                  Save preferences
                </button>
              </div>
            </div>
          </form>
        </div><!-- end/ Setup Scraping Configuration -->
        
       <!-- start/ Crawl Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="rounded-xl border border-gray-200 bg-white shadow-lg p-6">
            <div class="flex items-center justify-between">
              <h6 class="text-gray-800 text-xl font-bold flex items-center">
                <i class="fas fa-calendar mr-3 text-gray-600"></i>
                Crawl Status
              </h6>
            </div>
            <p class="mt-2 text-sm text-gray-600">View Last Crawl and Next Date.</p>
            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm font-semibold text-gray-700">Last Crawl</p>
                <p class="mt-1 text-sm text-gray-600">{{ $settings['last_crawl_at'] ?? 'not set yet' }}</p>
              </div>
              <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm font-semibold text-gray-700">Next Crawl</p>
                <p class="mt-1 text-sm text-gray-600">
                  {{ ($settings['auto_scrap_enabled'] ?? false) ? ($settings['next_crawl_at'] ?? 'N/A') : 'auto scrap disabled' }}
                </p>
              </div>
            </div>
          </div><!-- end/ Crawl Status -->

          <!-- start/ Web Cron Url -->
          <div class="rounded-xl border border-gray-200 bg-white shadow-lg p-6">
            <div class="flex items-center justify-between">
              <h6 class="text-gray-800 text-xl font-bold flex items-center">
                <i class="fas fa-link mr-3 text-gray-600"></i>
                Web Cron Url
              </h6>
            </div>
            <p class="mt-2 text-sm text-gray-600">Setup this URL in cron-job.org or CPanel to automate.</p>

            @php
              $fullUrl = ($settings['crawl_token'] ?? '') ? route('cron.run', $settings['crawl_token']) : '';
            @endphp

            <div class="mt-5 flex flex-col gap-3">
              <div class="relative">
                <span
                  data-url="{{ $fullUrl }}"
                  class="block border border-gray-300 bg-black/80 text-green-400 rounded-lg px-3 py-2 pr-12 w-full overflow-x-auto">
                  {{ $fullUrl ? Str::limit($fullUrl, 60) : 'regenerate new token' }}
                </span>
                <span
                  onclick="navigator.clipboard.writeText(this.previousElementSibling.getAttribute('data-url')); toastr.success('URL copied!');"
                  class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-600 p-1.5 rounded-lg text-sm text-gray-300 cursor-pointer hover:bg-gray-500 transition">
                  <i class="fas fa-copy"></i>
                </span>
              </div>

              <form id="ragenerate_token_form" action="{{ route('admin.scraping.setting.regenerate.token') }}" method="POST" class="w-full">
                @csrf
                @method('PATCH')
              </form>

              <button
                type="submit"
                form="ragenerate_token_form"
                class="inline-flex w-fit items-center bg-red-500 text-white font-medium text-sm px-4 py-2 rounded-lg shadow hover:bg-red-700 focus:outline-none transition"
              >
                <i class="fas fa-recycle mr-2"></i>
                Regenerate Token
              </button>
            </div>
          </div>
          <!-- end/ Web Cron Url -->
        </div>
      </div>
    </div>
  </div>

@endsection