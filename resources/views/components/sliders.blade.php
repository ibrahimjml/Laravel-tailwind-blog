@props([
    'model',
    'sliders',
    'type' => 'Category',
])

@php
    $slideClass = 'slider-' . strtolower($type);
@endphp

<div class="relative container mx-auto my-4 w-[90%] lg:h-72 h-48 overflow-hidden rounded-xl">

    @if($model->posts_count > 0)

        @foreach($sliders as $index => $slide)
            <img
                src="{{ $slide->image_url }}"
                alt="{{ $slide->title }}"
                class="{{ $slideClass }} absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}">
        @endforeach

        <div class="absolute inset-0 bg-black/30"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-start ml-4 text-white">
            <div class="flex lg:flex-row lg:items-center flex-col gap-2">
                <p class="text-sm uppercase tracking-[.3em] text-slate-200/60">
                    {{ $type }}
                </p>

                <p class="text-4xl font-extrabold">
                    {{ $model->name }}
                </p>
            </div>

            <p class="mt-3 text-xl">
                {{ $model->posts_count }}
                {{ Str::plural('article', $model->posts_count) }}
            </p>
        </div>

    @else

        <div class="absolute inset-0 bg-slate-100 flex items-center justify-center rounded-xl">
            <div class="text-center px-6 py-10">
                <p class="text-2xl font-semibold text-slate-900">
                    {{ $model->name }}
                </p>

                <p class="mt-3 text-base text-slate-600">
                    This {{ strtolower($type) }} has no articles yet.
                </p>
            </div>
        </div>

    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const slides = document.querySelectorAll('.{{ $slideClass }}');

    if (slides.length <= 1) return;

    let current = 0;

    setInterval(() => {

        slides[current].classList.remove('opacity-100');
        slides[current].classList.add('opacity-0');

        current = (current + 1) % slides.length;

        slides[current].classList.remove('opacity-0');
        slides[current].classList.add('opacity-100');

    }, 4000);

});
</script>
@endpush