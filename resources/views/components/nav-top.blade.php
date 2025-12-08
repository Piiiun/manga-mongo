<nav class="bg-manga px-4 md:px-10 py-3 top-0 z-50 fixed w-full">
    <div class="flex items-center md:justify-between max-w-8xl mx-auto">
        <div class="flex-shrink-0 mr-3 md:mr-0">
            <a href="{{ route('home') }}">
                <img src="{{ asset('manga.png') }}" alt="Manga" class="h-10 w-auto hidden md:block">
                <img src="{{ asset('manga-mobile.png') }}" alt="Manga" class="h-10 w-auto md:hidden">
            </a>
        </div>

        <div class="flex-1 md:flex-initial md:w-auto md:mx-6">
            <form method="GET" action="{{ route('manga.list') }}" class="relative">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari Manga.." 
                    value="{{ request('search') }}" 
                    class="w-full md:min-w-[300px] rounded-md bg-white/15 sm:bg-white/5 px-3.5 py-1 pr-10 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-second sm:text-sm/6"
                >
                <button 
                    type="submit" 
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-second"
                >
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>

        <div class="gap-5 justify-end text-white hidden md:flex font-bold">
            <a href="{{ route('home') }}" class="hover:text-second transition-colors">Home</a>
            <a href="{{ route('bookmark.index') }}" class="hover:text-second transition-colors flex items-center gap-1">
                Bookmark
                <span id="nav-bookmark-count" class="bg-second text-black text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center">0</span>
            </a>
            <a href="{{ route('manga.list') }}" class="hover:text-second transition-colors">List</a>
            <a href="#" class="hover:text-second transition-colors">Account</a>
        </div>
    </div>
</nav>
<script>
    function updateBookmarkCounter() {
        if (typeof bookmarkManager !== 'undefined') {
            const count = bookmarkManager.count();
            const navCounter = document.getElementById('nav-bookmark-count');
            
            if (navCounter) navCounter.textContent = count;
        }
    }

    document.addEventListener('DOMContentLoaded', updateBookmarkCounter);

    window.addEventListener('storage', function(e) {
        if (e.key === 'manga_bookmarks') {
            updateBookmarkCounter();
        }
    });
</script>