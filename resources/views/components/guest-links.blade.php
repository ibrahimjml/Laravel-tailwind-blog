@props([
    'transparent' => false,
])

<div class="flex items-center gap-4">

    {{-- Mobile Search --}}
    <div class="lg:hidden">
        <x-search-button />
    </div>

    @unless(Route::is('login'))
        <a
            href="{{ route('login') }}"
            @class([
                'rounded-xl px-4 py-2 text-sm font-bold uppercase transition',
                'bg-white text-black hover:bg-slate-100' => $transparent,
                'bg-black text-white hover:bg-slate-800' => ! $transparent,
            ])
        >
            Sign In
        </a>
    @endunless

</div>