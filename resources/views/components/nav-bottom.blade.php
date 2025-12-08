<nav class="fixed bottom-0 left-0 right-0 z-50 bg-[#1A1A1A] text-white border-t border-white/10 md:hidden">
<div class="grid grid-cols-4 text-center py-2">

    <a href="{{ route('home') }}" class="flex flex-col items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 11.5L12 3l9 8.5M5 10v10a1 1 0 001 1h4V14h4v7h4a1 1 0 001-1V10" />
        </svg>
        <span class="text-xs">Home</span>
    </a>

    <a href="{{ route('bookmark.index') }}" class="flex flex-col items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m6-6H6" />
        </svg>
        <span class="text-xs">Bookmark</span>
    </a>

    <a href="{{ route('manga.list') }}" class="flex flex-col items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h7" />
        </svg>
        <span class="text-xs">List</span>
    </a>

    <a href="#" class="flex flex-col items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zM4.5 19.5a7.5 7.5 0 0115 0" />
        </svg>
        <span class="text-xs">Account</span>
    </a>

</div>
</nav>