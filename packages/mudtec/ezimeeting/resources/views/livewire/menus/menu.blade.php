<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="shrink-0 flex items-center text-gray-800 font-semibold">
                    @if(auth()->check())
                        <a href="{{ route('home') }}" class="flex items-center">
                            <span class="text-yellow-500 text-xl ml-2">eziMeeting</span>
                        </a>

                        <a href="{{ route('dashboard') }}" class="flex items-center ml-4">
                            <x-application-mark class="block h-9 w-auto" />
                            <span class="text-yellow-500 text-xl ml-2">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <span class="text-yellow-500 text-xl ml-2">&lt;{{ config('app.name', 'mudTech') }}&gt;</span> eziMeeting**
                        </a>
                    @endif
                </div>
            </div>

            <!-- Hamburger Menu Button (mobile) -->
            <div class="sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:bg-gray-200 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Menu -->
            @if (Route::has('login') && auth()->check())
                <div class="hidden space-x-8 sm:flex sm:ms-10 items-center">
                    @foreach($menuItems as $item)
                        @if(($item['auth'] === true) || verify_user($item['auth']))
                            @if(!empty($item['submenus']))
                                <x-dropdown width="48">
                                    <x-slot name="trigger">
                                        {{ __($item['label']) }}
                                    </x-slot>
                                    <x-slot name="content">
                                        @foreach($item['submenus'] as $submenu)
                                            @if($submenu['auth'] === true || verify_user($submenu['auth']))
                                                <x-dropdown-link href="{{ route($submenu['route']) }}">
                                                    {{ __($submenu['label']) }}
                                                </x-dropdown-link>
                                            @endif
                                        @endforeach
                                    </x-slot>
                                </x-dropdown>
                            @else
                                <x-nav-link href="{{ $item['route'] }}" :active="request()->routeIs($item['route'])">
                                    {{ __($item['label']) }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endforeach

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @if(auth()->check())
                @foreach($menuItems as $item)
                    @if(($item['auth'] === true) || verify_user($item['auth']))
                        @if(!empty($item['submenus']))
                            <div>
                                <p class="font-bold text-gray-700">{{ __($item['label']) }}</p>
                                <ul class="ml-4 list-disc">
                                    @foreach($item['submenus'] as $submenu)
                                        @if($submenu['auth'] === true || verify_user($submenu['auth']))
                                            <li>
                                                <a href="{{ route($submenu['route']) }}" class="text-gray-700 hover:underline">
                                                    {{ __($submenu['label']) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['route'] }}" class="block text-gray-700 hover:bg-gray-100 rounded px-3 py-2">
                                {{ __($item['label']) }}
                            </a>
                        @endif
                    @endif
                @endforeach

                <form method="POST" action="{{ route('logout') }}" x-data class="mt-2">
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700 hover:bg-gray-100 rounded px-3 py-2">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block text-gray-700 hover:bg-gray-100 rounded px-3 py-2">
                        Register
                    </a>
                @endif
            @endif
        </div>
    </div>
</nav>