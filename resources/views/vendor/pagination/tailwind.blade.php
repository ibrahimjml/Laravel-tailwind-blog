@if ($paginator->hasPages())
<div class="container mx-auto gap-6 mt-2 mb-2">
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between ">
        <div class="flex justify-center gap-6  ">
            @if ($paginator->onFirstPage())
                <span class="disabled relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg  font-bold text-gray-200 bg-white border border-gray-300 leading-5   focus:outline-none focus:ring ring-gray-300 focus:border-blue-300   transition ease-in-out duration-150  dark:text-gray-300 dark:focus:border-blue-700  dark:active:text-gray-300">
                    &lt;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class=" relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg  font-bold text-black bg-white border border-gray-300 leading-5  hover:text-gray-500 active:translate-x-[-10px] focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150  dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                    &lt;
                </a>
            @endif  
    <div class="flex justify-center">
                    {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span aria-disabled="true">
                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 ">{{ $element }}</span>
            </span>
        @endif
      
        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page">
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-black bg-white border border-gray-300 cursor-default leading-5 ">{{ $page }}</span>
                    </span>
                @else
                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-300 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150  dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
      @endforeach
    </div>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg font-bold text-gray-800 bg-white border border-gray-300 leading-5  hover:text-gray-500 active:translate-x-[10px] focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150  dark:border-gray-600 ">
                    &gt;
                </a>
            @else
                <span class="disabled relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg  font-bold text-gray-200 bg-white border border-gray-300 leading-5   focus:outline-none focus:ring ring-gray-300 focus:border-blue-300   transition ease-in-out duration-150  dark:text-gray-300 dark:focus:border-blue-700  dark:active:text-gray-300">
                  &gt;
                </span>
            @endif
        </div>

        
        <div class="flex gap-4">
          <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
              {!! __('Showing') !!}
              @if ($paginator->firstItem())
                  <span class="font-medium">{{ $paginator->firstItem() }}</span>
                  {!! __('to') !!}
                  <span class="font-medium">{{ $paginator->lastItem() }}</span>
              @else
                  {{ $paginator->count() }}
              @endif
              {!! __('of') !!}
              <span class="font-medium">{{ $paginator->total() }}</span>
              {!! __('results') !!}
          </p>
      </div>



                </span>
            </div>
        </div>
    </nav>
  </div>
@endif
