@props(['manga'])

<article class="group relative flex flex-col overflow-hidden rounded-md md:rounded-2xl bg-linear-to-br from-gray-900 to-gray-800 shadow-xl shadow-black/50 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-amber-600/20">
    {{-- COVER + BADGE --}}
    <div class="relative overflow-hidden">
        <img src="{{ asset('storage/manga/' . $manga->cover_image) }}"
             alt="{{ $manga->title }}"
             class="h-72 w-full object-cover transition-transform duration-500 group-hover:scale-110">
        
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent opacity-60 transition-opacity group-hover:opacity-80"></div>

        {{-- Badge Baru --}}
        <div class="absolute left-2 top-2 flex items-center gap-1 rounded-md bg-linear-to-r from-red-600 to-pink-600 px-2 py-1 text-[10px] font-bold text-white shadow-md backdrop-blur-sm md:left-3 md:top-3 md:px-3 md:py-1.5 md:text-xs md:rounded-lg md:shadow-lg">
            NEW
        </div>

        {{-- Icon Bookmark dengan animasi --}}
        <button
            type="button"
            data-manga-id="{{ $manga->id }}"
            class="bookmark-toggle absolute right-1 md:right-3 top-1 md:top-3 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-amber-500 hover:shadow-amber-500/50"
            title="Tambah ke Bookmark">
            {{-- Icon Bookmark Outline (default) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="bookmark-icon-outline h-5 w-5 transition-all">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
            {{-- Icon Bookmark Filled (saat di-bookmark) --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="bookmark-icon-filled h-5 w-5 hidden">
                <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
            </svg>
        </button>

        {{-- Views dengan icon --}}
        <div class="absolute bottom-3 left-1.5 md:left-3 flex items-center gap-1.5 rounded-md md:rounded-lg bg-black/60 px-2 md:px-3 py-0.5 md:py-1.5 text-[10px] font-semibold text-white backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
            </svg>
            {{ number_format($manga->views) }}
        </div>

        {{-- Rating dengan styling lebih baik --}}
        <div class="absolute bottom-3 right-1 md:right-3 flex items-center gap-1.5 rounded-md md:rounded-lg bg-linear-to-r from-amber-500 to-yellow-500 px-1 md:px-3 py-0.5 md:py-1.5 text-xs font-bold text-white shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            {{ number_format($manga->rating ?? 7.0, 1) }}
        </div>
    </div>

    {{-- BODY --}}
    <div class="flex flex-1 flex-col gap-1 md:gap-3 p-2 md:p-5">
        {{-- Title dengan hover effect --}}
        <a href="{{ route('manga.detail', $manga->slug) }}" class="group/title">
            <h3 class="line-clamp-2 text-base font-bold text-white transition-colors group-hover/title:text-amber-400">
                {{ $manga->title }}
            </h3>
        </a>

        {{-- Genres dengan styling lebih menarik --}}
        <div class="flex flex-wrap gap-2">
            @foreach ($manga->genres->take(3) as $genre)
                <span class="md:rounded-full rounded-sm bg-linear-to-r from-amber-500/20 to-yellow-500/20 md:px-3 px-1 md:py-1 py-0.5 md:text-xs text-[10px] font-semibold text-amber-300 ring-1 ring-amber-500/30 transition-all hover:ring-amber-500/60">
                    <a href="{{ route('manga.list', ['genre' => $genre->slug]) }}">
                        {{ $genre->name }}
                    </a>
                </span>
            @endforeach
        </div>

        {{-- Divider --}}
        <div class="h-px bg-linear-to-r from-transparent via-gray-700 to-transparent"></div>

        <div class="space-y-2.5">
            @foreach ($manga->chapters->take(3) as $chapter)
                <div class="group/chapter rounded-lg bg-white/10 sm:bg-white/5 px-2 md:px-3 py-1 md:py-2 transition-all hover:bg-white/10">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('manga.read', [$manga->slug, $chapter->number]) }}"
                           class="flex items-center gap-2 text-sm font-semibold text-amber-400 transition-colors hover:text-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                            <span>Chapter {{ $chapter->number }}</span>
                        </a>

                        <span class="text-xs text-gray-400">
                            {{ optional($chapter->created_at)->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Read button --}}
        <a href="{{ route('manga.detail', $manga->slug) }}">
            <button class="mt-2 w-full rounded-lg bg-linear-to-r from-amber-500 to-yellow-500 px-4 py-2.5 text-sm font-bold text-white shadow-lg transition-all hover:from-amber-600 hover:to-yellow-600 hover:shadow-amber-500/50">
                Read Now
            </button>
        </a>
    </div>
</article>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>