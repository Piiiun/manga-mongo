<nav class="bg-linear-to-r from-manga via-manga/95 to-manga px-4 md:px-10 py-3 top-0 z-50 fixed w-full shadow-lg backdrop-blur-sm border-b border-white/10">
    <div class="flex items-center md:justify-between max-w-8xl mx-auto">
        <div class="shrink-0 mr-3 md:mr-0">
            <a href="{{ route('home') }}" class="group">
                <img src="{{ asset('manga.png') }}" alt="Manga" class="h-10 w-auto hidden md:block transition-transform group-hover:scale-105">
                <img src="{{ asset('manga-mobile.png') }}" alt="Manga" class="h-10 w-auto md:hidden transition-transform group-hover:scale-105">
            </a>
        </div>

        <div class="flex-1 md:flex-initial md:w-auto md:mx-6">
            <form method="GET" action="{{ route('manga.list') }}" class="relative group">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari Manga.." 
                    value="{{ request('search') }}" 
                    autocomplete="off"
                    class="w-full md:min-w-[300px] rounded-full bg-white/10 backdrop-blur-sm px-4 py-2 pr-10 text-base text-white border border-white/20 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-second focus:border-transparent transition-all duration-300 sm:text-sm"
                >
                <button 
                    type="submit" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-second transition-colors duration-200"
                >
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>

        <div class="gap-6 justify-end text-white hidden md:flex font-medium items-center">
            <a href="{{ route('home') }}" class="hover:text-second transition-all duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-second after:transition-all hover:after:w-full">Home</a>
            <a href="{{ route('bookmark.index') }}" class="hover:text-second transition-all duration-200 flex items-center gap-1.5 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-second after:transition-all hover:after:w-20">
                Bookmark
                <span id="nav-bookmark-count" class="bg-second text-black text-xs font-bold px-2 py-0.5 rounded-full min-w-5 text-center animate-pulse">0</span>
            </a>
            <a href="{{ route('manga.list') }}" class="hover:text-second transition-all duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-second after:transition-all hover:after:w-full">List</a>
            
            @auth
                {{-- User sudah login --}}
                <div class="relative group">
                    <button class="flex items-center gap-2 hover:text-second transition-colors duration-200 focus:outline-none">
                        <div class="w-8 h-8 rounded-full ring-2 ring-white/20 overflow-hidden">
                                <img src="{{ Auth::user()->profile_picture_url }}" 
                                    class="w-full h-full object-cover" 
                                    alt="{{ Auth::user()->name }}">
                        </div>

                        <span class="hidden lg:block">{{ Auth::user()->name }}</span>

                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    {{-- Dropdown Menu --}}
                    <div class="absolute right-0 mt-2 w-48 bg-manga/95 backdrop-blur-md rounded-xl shadow-xl border border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-white/10">
                                <p class="text-sm text-gray-400">Signed in as</p>
                                <p class="text-sm font-medium truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-white/10 hover:text-second transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </span>
                            </a>
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm hover:bg-white/10 hover:text-second transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    Dashboard
                                </span>
                            </a>
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.manga.index') }}" class="block px-4 py-2 text-sm hover:bg-white/10 hover:text-second transition-colors">
                                <span class="flex items-center gap-2 text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wrench-icon lucide-wrench"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"/></svg>
                                    Admin Panel
                                </span>
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10 mt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/10 hover:text-red-300 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- User belum login --}}
                <a href="{{ route('login') }}" class="px-4 py-2 bg-amber-500 hover:bg-second/90 text-black font-semibold rounded-full transition-all duration-200 hover:shadow-lg hover:shadow-second/30 hover:scale-105">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>