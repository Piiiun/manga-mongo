<section class="relative mt-12">
    {{-- Background decoration --}}
    <div class="absolute -top-20 left-0 h-40 w-40 rounded-full bg-accent/10 blur-3xl"></div>
    <div class="absolute -top-10 right-0 h-60 w-60 rounded-full bg-accent-strong/10 blur-3xl"></div>
    
    <div class="relative">
        {{-- Header section --}}
        <div class="mb-8 flex items-center justify-between sm:mx-8">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1.5 rounded-full bg-linear-to-b from-accent-light to-accent-strong"></div>
                <div>
                    <h2 class="bg-linear-to-r from-accent-hover via-accent-light to-accent bg-clip-text text-lg sm:text-2xl font-extrabold text-transparent">
                        UPDATE TERBARU
                    </h2>
                    <p class="text-xs sm:text-sm text-text-second">Manga terbaru yang baru saja di-update</p>
                </div>
            </div>
            <a href="{{ route('manga.list', ['sort' => 'latest']) }}" class="scale-90 sm:scale-100 group flex items-center gap-2 rounded-full bg-linear-to-r from-accent/10 to-accent-strong/10 px-5 py-2.5 font-semibold text-accent-hover ring-1 ring-accent/30 transition-all hover:ring-accent/60">
                <span>See All</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
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
                <p class="mt-4 text-text-second">Belum ada manga yang tersedia</p>
            </div>
        @endif
    </div>
</section>