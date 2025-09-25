<header x-data="{ open: false }" class="bg-white border-b shadow-sm">
    <div class="px-4 py-3 flex items-center justify-between bg-[rgb(31,61,123)]">
        <a href="{{ route('students.index') }}" class="flex items-center gap-2">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            <span class="font-semibold mt-auto text-white text-3xl">Student Roster</span>
        </a>

        <div class="mt-auto flex items-center gap-2 w-fit">
            @auth
                <span class="mr-2 hidden sm:inline text-white">Hi, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline flex items-center gap-1">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1 text-red-600 hover:underline focus:outline-none">
                    <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 12H9m9 0l-3-3m3 3l-3 3"/>
                        </svg>
                        <span class="mt-0.5">Logout</span>
                    </button>
                </form>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="hidden sm:inline hover:underline">Login</a>
                @if(Route::has('register'))
                <a href="{{ route('register') }}" class="hidden sm:inline hover:underline">Register</a>
            @endif
            @endguest

            <button
                type="button"
                class="inline-flex sm:hidden items-center justify-center h-9 w-9 rounded
                text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/40"
              @click="open = !open"
                :aria-expanded="open.toString()"
                aria-controls="mobile-menu"
                aria-label="Toggle navigation"
                >
                {{-- Icon: bars / x --}}
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>

        <div id="mobile-menu"
             class="sm:hidden border-t"
             x-show="open"
             x-transition.origin.top
             x-cloak>
            <nav class="p-2 space-y-1 bg-white">
                <x-nav-link />
                {{-- Optional: show auth actions on mobile too --}}
                <div class="mt-2 border-t pt-2">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-3 py-2 rounded text-red-600 hover:bg-gray-50">Logout</button>
                        </form>
                    @endauth
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded hover:bg-gray-50">Login</a>
                  @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="block px-3 py-2 rounded hover:bg-gray-50">Register</a>
                    @endif
                    @endguest
                </div>
            </nav>
        </div>
    </div>
</header>
