<header class="full-w flex items-center justify-between py-3 px-6 border-b border-gray-100">
    <!-- Left section: Logo and Navigation -->
    <div id="header-left" class="flex items-center">
        <!-- Logo -->
        <div class="text-gray-800 font-semibold">
            <span class="text-yellow-500 text-xl">&lt;MUDTEC&gt;</span> eziMeeting
        </div>

        <!-- Main Navigation Menu -->
        <nav class="top-menu ml-10">
            <ul class="flex space-x-4">
                @foreach($menuItems as $item)
                    <!--@if(!$item['auth'] || ($item['auth'] === true && auth()->check()) || (auth()->check() && auth()->user()->can($item['auth'])))-->
                    @if(!$item['auth'] || ($item['auth'] === true) || ($item['auth'] === 'Admin'))
                        <li class="relative group {{ $item['label'] === 'Admin' ? 'admin-menu' : '' }}">
                            <!-- Main menu item link -->
                            <a class="flex space-x-2 items-center hover:text-yellow-900 text-sm {{ request()->is(ltrim($item['route'], '/')) ? 'text-yellow-500' : 'text-gray-500' }}"
                               href="{{ $item['route'] }}">
                                {{ $item['label'] }}
                            </a>

                            @if($item['label'] === 'Admin')
                                <button class="ct-toggle-dropdown-desktop-ghost" 
                                        aria-label="Expand dropdown menu" 
                                        aria-haspopup="true" 
                                        aria-expanded="false" 
                                        role="menuitem">
                                </button>
                            @endif
                            


                            <!-- Submenu (visible on hover for Admin only) -->
                            @if(!empty($item['submenus']))
                                <ul class="submenu absolute top-full left-0 hidden group-hover:block bg-white rounded-md shadow-md z-20">
                                    @foreach($item['submenus'] as $submenu)
                                        <li>
                                            <!-- Submenu item with conditional rendering for logout form -->
                                            <a href="{{ $submenu['route'] != '#' ? route($submenu['route']) : '#' }}" 
                                               class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-900">
                                                {{ $submenu['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>

    <!-- Right section: Authentication Links -->
    <div id="header-right" class="flex items-center md:space-x-6">
        @auth
            <form method="POST" action="{{ $submenu['route'] }}">
                @csrf
                <button type="submit" class="block w-full px-4 py-2  text-left text-sm text-gray-700 hover:text-gray-900">
                    {{ $submenu['label'] }}
                </button>
            </form>
        @else
            <div class="flex space-x-5">
            @if (Route::has('login'))
                <a
                    href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Log in
                </a>
            @endif

            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </a>
            @endif

            {{--
            <div class="flex space-x-5">
                <a class="flex space-x-2 items-center hover:text-yellow-500 text-sm text-gray-500" href="/login">Login</a>
                <a class="flex space-x-2 items-center hover:text-yellow-500 text-sm text-gray-500" href="/register">Register</a>
            </div>
            -->
            
        @endauth
    </div>
</header>