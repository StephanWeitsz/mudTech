<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center"> <!-- Ensure vertical centering with items-center -->
            <div class="flex items-center"> <!-- Ensure the logo and menu are aligned vertically -->
                <!-- Logo -->
                <div class="shrink-0 flex items-center text-gray-800 font-semibold">
                    @if(auth()->check())
                        <a href="{{ route('home') }}" style="display: flex; align-items: center;">
                        <span class="text-yellow-500 text-xl ml-2">eziMeeting</span>
                        </a>

                        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center;">
                            <x-application-mark class="block h-9 w-auto" />
                            <span class="text-yellow-500 text-xl ml-2">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center;">
                            <span class="text-yellow-500 text-xl ml-2">&lt;{{ config('app.name', 'mudTeck*') }}&gt;</span> eziMeeting**
                        </a>
                    @endif
                </div>
            </div>

            @if (Route::has('login'))
                @if(auth()->check())
                    <!-- Menu Items -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    @foreach($menuItems as $item)
                        @if(($item['auth'] === true) || (auth()->check() && verify_user($item['auth'])))
                            @if(!empty($item['submenus']))
                                <x-dropdown width="48">
                                    <x-slot name="trigger">
                                        {{ __($item['label']) }}
                                    </x-slot>
                                
                                    <x-slot name="content">
                                        <!-- Loop through submenus -->
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

                    <div class="border-t border-gray-200"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                @else
                    <nav class="-mx-3 flex flex-1 justify-end">
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </a>
                        @endif
                    </nav>
                @endif
            @endif            
        </div>
    </div>
</nav>