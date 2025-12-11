<nav class="fixed bottom-0 left-0 right-0 z-50 bg-linear-to-t from-[#1A1A1A] to-[#1A1A1A]/95 backdrop-blur-lg text-white border-t border-white/10 md:hidden safe-area-bottom">
    <div class="grid grid-cols-5 text-center py-2 px-2 max-w-lg mx-auto">

        {{-- Home --}}
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 py-1 rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'text-second bg-second/10' : 'text-gray-400 hover:text-white active:scale-95' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 11.5L12 3l9 8.5M5 10v10a1 1 0 001 1h4V14h4v7h4a1 1 0 001-1V10" />
            </svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        {{-- Bookmark --}}
        <a href="{{ route('bookmark.index') }}" class="flex flex-col items-center gap-1 py-1 rounded-xl transition-all duration-200 relative {{ request()->routeIs('bookmark.*') ? 'text-second bg-second/10' : 'text-gray-400 hover:text-white active:scale-95' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('bookmark.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
            </svg>
            <span id="mobile-bookmark-count" class="absolute -top-1 right-1/4 bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full min-w-4 text-center hidden">0</span>
            <span class="text-[10px] font-medium">Bookmark</span>
        </a>

        {{-- List --}}
        <a href="{{ route('manga.list') }}" class="flex flex-col items-center gap-1 py-1 rounded-xl transition-all duration-200 {{ request()->routeIs('manga.list') ? 'text-second bg-second/10' : 'text-gray-400 hover:text-white active:scale-95' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span class="text-[10px] font-medium">List</span>
        </a>

        {{-- History (hanya untuk user login) --}}
        @auth
        <a href="{{ route('history.index') }}" class="flex flex-col items-center gap-1 py-1 rounded-xl transition-all duration-200 {{ request()->routeIs('history.*') ? 'text-second bg-second/10' : 'text-gray-400 hover:text-white active:scale-95' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-[10px] font-medium">History</span>
        </a>
        @endauth

        {{-- Account / Login --}}
        @auth
            <a href="{{ route('profile.show') }}" class="flex flex-col items-center gap-1 py-1 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.*') ? 'text-second bg-second/10' : 'text-gray-400 hover:text-white active:scale-95' }}">
                <div class="w-6 h-6 rounded-full bg-linear-to-br from-second to-yellow-400 flex items-center justify-center text-black font-bold text-[10px] uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-[10px] font-medium">Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 py-1 rounded-xl transition-all duration-200 text-second hover:bg-second/10 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span class="text-[10px] font-medium">Login</span>
            </a>
            
            {{-- Jika belum login, grid 4 kolom --}}
            <style>
                nav.safe-area-bottom > div { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            </style>
        @endauth

    </div>
</nav>

{{-- Safe area untuk iPhone dengan notch --}}
<style>
    .safe-area-bottom {
        padding-bottom: env(safe-area-inset-bottom, 0);
    }
</style>
