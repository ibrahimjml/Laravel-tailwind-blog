@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between ">
        <div class="flex justify-between gap-6 flex-1 ">
            @if ($paginator->onFirstPage())
                <span class="disabled relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg  font-bold text-gray-200 bg-white border border-gray-300 leading-5   focus:outline-none focus:ring ring-gray-300 focus:border-blue-300   transition ease-in-out duration-150  dark:text-gray-300 dark:focus:border-blue-700  dark:active:text-gray-300">
                    &lt;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class=" relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg  font-bold text-black bg-white border border-gray-300 leading-5  hover:text-gray-500 active:translate-x-[-10px] focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                    &lt;
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg font-bold text-black bg-white border border-gray-300 leading-5  hover:text-gray-500 active:translate-x-[10px] focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                    &gt;
                </a>
            @else
                <span class="disabled relative inline-flex items-center p-4 py-2 ml-3 text-lg rounded-lg  font-bold text-gray-200 bg-white border border-gray-300 leading-5   focus:outline-none focus:ring ring-gray-300 focus:border-blue-300   transition ease-in-out duration-150  dark:text-gray-300 dark:focus:border-blue-700  dark:active:text-gray-300">
                  &gt;
                </span>
            @endif
        </div>

        

                  
                </span>
            </div>
        </div>
    </nav>
@endif
