<nav class=" bg-manga px-10 py-3 top-0 z-50 font-manga fixed w-full">
    <div class=" flex items-center md:justify-between max-w-7xl mx-auto justify-center">
        <div>
            <a href="">
                <img src="manga.png" alt="Manga" class=" h-10 w-auto hidden md:block">
                <img src="manga-mobile.png" alt="Manga" class=" h-10 w-auto md:hidden mr-4">
            </a>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('manga.list') }}"">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}" class=" min-w-0 flex-auto rounded-md bg-white/5 px-3.5 py-1 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-second sm:text-sm/6">
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-second">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>
        <div class="gap-5 justify-end text-white mr-4 hidden md:flex font-bold">
            <a href="{{ route('home') }}" class="hover:text-second">Beranda</a>
            <a href="" class="hover:text-second">New Update</a>
            <a href="{{ route('manga.list') }}" class="hover:text-second">List</a>
            <a href="" class="hover:text-second">Akun</a>
        </div>
    </div>
</nav>