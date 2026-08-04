@extends('admin.partials.layout')
@section('title', 'Web Scraping | Dashboard')
@push('admin-styles')
  <style>
    .tab-btn.active {
      color: #2563eb !important;
      background-color: #eff6ff !important;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }

    .tab-panel.hidden {
      display: none;
    }
  </style>
@endpush
@section('content')
  <!-- Header -->
  @include('admin.partials.header', ['linktext' => 'Web Scraping', 'route' => 'admin.scraping.index', 'value' => request('search')])
  <div class="md:ml-64 w-full mx-auto transform -translate-y-48 overflow-hidden">
    <div class="flex flex-wrap">
      <div class="w-full lg:w-[80%] mx-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
          <div class="rounded-t bg-white mb-0 px-6 py-6">
            <div class="text-center flex justify-between">
              <h6 class="text-blueGray-700 text-xl font-bold mb-2">
                Web Scraping
              </h6>
            </div>
            <p class="text-sm font-bold text-blueGray-400">
              Automatically crawl URLs or RSS feeds, extract meta data (with Category), and save it.
            </p>
            {{-- scraping source | scraping data | scrapingLogs --}}
            <div class="flex flex-wrap items-center gap-2 ml-4 mt-6">
              <button type="button" class="tab-btn active p-1 font-bold rounded-lg text-gray-400 transition"
              data-tab-target="sources" aria-selected="true">
              <i class="fas fa-globe mr-3"></i>
                Sources
              </button>
              <div class="h-4 w-px bg-gray-400"></div>
              <button type="button" class="tab-btn p-1 font-bold rounded-lg text-gray-400 transition"
              data-tab-target="scraped-data" aria-selected="false">
              <i class="fas fa-database mr-3"></i>
                Scraped Data
              </button>
              <div class="h-4 w-px bg-gray-400"></div>
              <button type="button" class="tab-btn p-1 font-bold rounded-lg text-gray-400 transition"
                data-tab-target="scraping-logs" aria-selected="false">
                <i class="fas fa-heartbeat mr-3"></i>
                Scraping Logs
              </button>
            </div>

            <div class="mt-6 ml-4">
              @include('admin.scraping.sources')
              @include('admin.scraping.scraped-data')
              @include('admin.scraping.logs')
            </div>


          </div>
        </div>

      </div>
    </div>
  </div>
{{-- create source model --}}
@include('admin.scraping.partials.create')
{{-- edit source model --}}
@include('admin.scraping.partials.edit')
  @push('scripts')
  
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.tab-panel');

        tabs.forEach((tab) => {
          tab.addEventListener('click', function () {
            const target = this.getAttribute('data-tab-target');

            tabs.forEach((item) => {
              item.classList.remove('active');
              item.setAttribute('aria-selected', 'false');
            });

            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');

            panels.forEach((panel) => {
              panel.classList.add('hidden');
              if (panel.id === target) {
                panel.classList.remove('hidden');
              }
            });
          });
        });
      });
    </script>
  @endpush
@endsection