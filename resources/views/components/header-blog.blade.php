@php
    $isTransparent = Route::is(['home', 'profile.*']);
    $isFixed = Route::is(['blog', 'news', 'viewhashtag', 'viewcategory']);
    $isHome = Route::is('home');
@endphp

<nav
    id="blog-navigation"
    @class([
        'w-screen h-20 px-6 py-5',
        'absolute z-50 bg-opacity-0' => $isTransparent,
        'bg-white shadow-[0_2px_5px_rgba(0,0,0,0.1)]' => ! $isTransparent,
        'fixed top-0 z-50' => $isFixed,
    ])
>
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-4">
            <x-logo class="cursor-pointer"/>

            @unless($isHome)
                <div class="hidden lg:block max-w-md">
                    <x-search-button />
                </div>
            @endunless
        </div>

        @guest
            <x-guest-links :transparent="$isTransparent" />
        @else
            <x-desktop-nav :transparent="$isTransparent" />
            <x-mobile-nav :transparent="$isTransparent" />
        @endguest

    </div>
</nav>