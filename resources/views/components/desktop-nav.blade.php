@props([
    'transparent' => false,
])

<ul class="hidden md:flex items-center space-x-6">

    {{-- User dropdown --}}
    <li
        id="dropdown"
        @class([
            'relative pt-2 text-lg',
            'text-white' => $transparent,
            'text-gray-700' => ! $transparent,
        ])
    >
        @include('partials.hover-menu')

        <span class="cursor-pointer">
            {{ auth()->user()->name }}
            <i class="fas fa-angle-down ml-1"></i>
        </span>
    </li>

    {{-- Blog --}}
    <li
        @class([
            'pt-2 text-lg',
            'text-white' => $transparent,
            'text-gray-700' => ! $transparent,
        ])
    >
        <a href="{{ route('blog') }}">Blog</a>
    </li>

    {{-- Notifications --}}
    @unless(request()->is('admin.*'))
        <li
            id="hover-notification"
            data-notification-trigger
            @class([
                'relative cursor-pointer pt-2 text-lg',
                'text-white' => $transparent,
                'text-gray-700' => ! $transparent,
            ])
        >
            <span
                data-notification-count
                class="notification-count absolute top-2 left-3 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 p-1 text-xs font-semibold text-white"
            >
                {{ auth()->user()->unreadNotifications->count() }}
            </span>

            <i class="fas fa-bell"></i>
        </li>

        @include('partials.notifications-menu')
    @endunless

    {{-- Bookmarks --}}
    <li
        @class([
            'pt-2 text-lg',
            'text-white' => $transparent,
            'text-gray-700' => ! $transparent,
        ])
    >
        <a href="{{ route('bookmarks') }}">
            <i class="far fa-bookmark"></i>
        </a>
    </li>

    {{-- Admin --}}
    @if(auth()->user()->hasAnyRole(['Admin','Moderator']) || auth()->user()->hasPermission('Access'))
        <li
            @class([
                'pt-2 text-lg',
                'text-white' => $transparent,
                'text-gray-700' => ! $transparent,
            ])
        >
            <a href="{{ route('admin.panel') }}">
                Admin Panel
            </a>
        </li>
    @endif

    {{-- Home --}}
    @unless(Route::is('home'))
        <li
            @class([
                'pt-2 text-lg',
                'text-white' => $transparent,
                'text-gray-700' => ! $transparent,
            ])
        >
            <a href="{{ route('home') }}">
                Home
            </a>
        </li>
    @endunless

</ul>