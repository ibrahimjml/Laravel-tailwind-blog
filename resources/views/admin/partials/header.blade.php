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

<div class="{{ $backgroundColor }} py-6 w-full h-80">
  <nav class="flex flex-col md:flex-row md:items-center md:justify-between px-6">
    <a href="{{ route($route) }}" class="text-white text-lg font-semibold uppercase mb-2 md:mb-0">
      {{ $linktext }}
    </a>

    {{-- Search Form --}}
    <x-forms.filter-form exclude="search" :action="route($route)" class="relative w-full md:w-64">
      <input 
        type="search"
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="w-full rounded border-2 {{ $borderColor }} px-3 py-2 text-black placeholder-gray-500 focus:outline-none"
      />
      <button type="submit" class="absolute right-0 top-0 h-full px-4 {{ $searchColor }} text-white rounded-r">
        <i class="fas fa-search"></i>
      </button>
    </x-forms.filter-form>
  </nav>
</div>
