<section class="relative mt-12">
    {{-- Background decoration --}}
    <div class="absolute -top-20 left-0 h-40 w-40 rounded-full bg-amber-500/20 blur-3xl"></div>
    <div class="absolute -top-10 right-0 h-60 w-60 rounded-full bg-red-500/20 blur-3xl"></div>
    
    <div class="relative">
        {{-- Header section --}}
        <div class="mb-8 flex items-center justify-between sm:mx-8">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1.5 rounded-full bg-linear-to-b from-amber-600 to-red-500 dark:from-amber-500 dark:to-red-500"></div>
                <div>
                    <h2 class="bg-linear-to-r from-amber-600 via-yellow-600 to-amber-700 dark:from-amber-400 dark:via-yellow-400 dark:to-amber-500 bg-clip-text text-lg sm:text-2xl font-extrabold text-transparent">
                        UPDATE TERBARU
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Manga terbaru yang baru saja di-update</p>
                </div>
            </div>
            <a href="{{ route('manga.list', ['sort' => 'latest']) }}" class="group flex items-center gap-2 rounded-full bg-linear-to-r from-amber-500/20 to-red-500/20 dark:from-amber-500/10 dark:to-red-500/10 px-2.5 sm:px-5 py-2.5 font-semibold text-amber-600 dark:text-amber-400 ring-1 ring-amber-600/60 dark:ring-amber-500/30 transition-all hover:ring-amber-600 hover:dark:ring-amber-500/60 mr-2 sm:mr-0">
                <span class="text-xs sm:text-base">See All</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 sm:h-4 sm:w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        {{-- Grid manga cards --}}
        <div class="grid gap-3 sm:gap-6 grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-2 sm:mx-8 ">
            @foreach ($latestMangas as $manga)
                <x-home-manga-card :manga="$manga"/>
            @endforeach
        </div>

        {{-- Loading more indicator (optional) --}}
        @if($latestMangas->isEmpty())
            <div class="flex flex-col items-center justify-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Belum ada manga yang tersedia</p>
            </div>
        @endif
    </div>
</section>