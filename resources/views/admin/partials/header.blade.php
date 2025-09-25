@props([
  'route',
  'name' => 'search',
  'value' => null,
  'placeholder' => 'Search here...',
  'linktext' => 'Back',
  'searchColor' => 'bg-gray-600',
  'borderColor' => 'border-gray-600',
  'backgroundColor' => 'bg-gray-600'
])

<div class="{{$backgroundColor}} py-12 lg:ml-64 h-60 overflow-x-hidden">
  <nav class="relative top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
    <div class="w-full mx-auto items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
      <a class="text-white text-lg uppercase hidden lg:inline-block font-semibold" href="{{ route($route) }}">{{ $linktext }}</a>

      <!-- Search Form -->
      <form action="{{ route($route) }}" method="GET" class="relative flex items-center w-[150px] sm:w-[250px]">
        <input type="search" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
          class="peer block min-h-[auto] w-full rounded border-2 {{$borderColor}} bg-white px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear placeholder:text-gray-500 text-black"
          placeholder="{{ $placeholder }}" />
        <button type="submit"
          class="absolute right-0 z-10 h-full px-4 flex items-center {{$searchColor}} text-white rounded-e">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </nav>
</div>
