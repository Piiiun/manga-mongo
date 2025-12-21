@props(['popularMangas'])

<section class="relative mt-12 px-4 sm:px-8">
    {{-- Background decoration --}}
    <div class="absolute -top-20 left-0 h-40 w-40 rounded-full bg-accent/10 blur-3xl"></div>
    <div class="absolute -top-10 right-0 h-60 w-60 rounded-full bg-accent-strong/10 blur-3xl"></div>

    {{-- Header dengan Tabs --}}
    <div class="mb-6">
        <div class="flex gap-4 items-center justify-between">
            {{-- Title --}}
            <h2 class="bg-linear-to-r from-amber-400 via-yellow-400 to-amber-500 bg-clip-text text-2xl font-extrabold text-transparent">
                POPULER
            </h2>
            
            {{-- Lihat Semua - Desktop --}}
            <a href="{{ route('manga.list', ['sort' => 'popular']) }}" 
               class="scale-90 sm:scale-100 flex group items-center gap-2 rounded-full bg-linear-to-r from-amber-500/10 to-red-500/10 px-5 py-2.5 font-semibold text-amber-400 ring-1 ring-amber-500/30 transition-all hover:ring-amber-500/60">
                <span>See All</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        {{-- Tabs Filter --}}
        {{-- <div class="mt-4 sm:mt-2 flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            <button class="shrink-0 rounded-lg bg-amber-500 px-4 py-2 text-sm font-bold text-white transition-all hover:bg-amber-600 sm:px-6">
                Hari Ini
            </button>
            <button class="shrink-0 rounded-lg bg-gray-700/50 px-4 py-2 text-sm font-semibold text-gray-300 transition-all hover:bg-gray-700 hover:text-white sm:px-6">
                Minggu Ini
            </button>
            <button class="shrink-0 rounded-lg bg-gray-700/50 px-4 py-2 text-sm font-semibold text-gray-300 transition-all hover:bg-gray-700 hover:text-white sm:px-6">
                Bulan Ini
            </button>
        </div> --}}

        {{-- Lihat Semua - Mobile --}}
        {{-- <a href="{{ route('manga.list', ['sort' => 'popular']) }}" 
           class="mt-3 flex items-center justify-center gap-2 rounded-lg bg-gray-800/50 py-2.5 text-sm font-semibold text-amber-500 transition-colors hover:bg-gray-800 sm:hidden">
            <span>Lihat Semua</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </a> --}}
    </div>

    {{-- List Populer Manga --}}
    <div class="space-y-3 sm:space-y-4">
        @foreach ($popularMangas as $index => $manga)
            <article class="group relative flex items-center gap-3 sm:gap-4 overflow-hidden rounded-xl bg-white/90 dark:bg-gray-800/80 backdrop-blur-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800 shadow-md shadow-black/50 hover:shadow-xl hover:shadow-amber-500/5 dark:hover:shadow-amber-500/10 border border-gray-200 dark:border-transparent">
                
                {{-- Background Image Overlay --}}
                <div class="absolute inset-0 dark:opacity-50 transition-opacity group-hover:opacity-30 dark:group-hover:opacity-40">
                    <img src="{{ asset('storage/manga/' . $manga->cover_image) }}" 
                         alt="{{ $manga->title }}"
                         class="h-full w-full object-cover blur-sm">
                    <div class="absolute inset-0 bg-linear-to-r from-white via-white/95 to-white/30 dark:from-gray-900 dark:via-gray-900/90 dark:to-gray-900/20"></div>
                </div>

                {{-- Nomor Ranking --}}
                <div class="relative z-10 flex h-full items-center">
                    <div class="flex h-20 sm:h-24 w-12 sm:w-16 items-center justify-center">
                        <span class="text-2xl sm:text-3xl font-black {{ $index === 0 ? 'text-amber-500' : ($index === 1 ? 'text-gray-500 dark:text-gray-400' : ($index === 2 ? 'text-orange-500 dark:text-orange-600' : 'text-gray-400 dark:text-gray-500')) }}">
                            {{ $index + 1 }}
                        </span>
                    </div>
                </div>

                {{-- Cover Image --}}
                <div class="relative z-10 h-24 w-16 sm:h-32 sm:w-24 shrink-0 overflow-hidden rounded-lg shadow-lg ring-1 ring-gray-200 dark:ring-transparent">
                    <img src="{{ asset('storage/manga/' . $manga->cover_image) }}" 
                         alt="{{ $manga->title }}"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>

                {{-- Content --}}
                <div class="relative z-10 flex flex-1 flex-col gap-1.5 sm:gap-2 py-3 sm:py-4 pr-3 sm:pr-4">
                    {{-- Title dan Badge --}}
                    <div class="flex items-start gap-2">
                        <a href="{{ route('manga.detail', $manga->slug) }}" class="group/title flex-1">
                            <h3 class="line-clamp-2 text-sm sm:text-base font-bold text-gray-900 dark:text-white transition-colors group-hover/title:text-amber-500 dark:group-hover/title:text-amber-400">
                                {{ $manga->title }}
                            </h3>
                        </a>
                        
                        @if ($manga->rating >= 8.0)
                            <span class="shrink-0 rounded bg-linear-to-r from-red-600 to-red-500 px-1.5 sm:px-2 py-0.5 sm:py-1 text-xs font-bold text-white shadow-lg">
                                HOT
                            </span>
                        @endif
                    </div>

                    {{-- Genres - Hidden on very small screens --}}
                    <div class="hidden sm:flex flex-wrap gap-1.5 sm:gap-2">
                        @foreach ($manga->genres->take(2) as $genre)
                            <span class="rounded bg-amber-500/30 dark:bg-amber-500/20 px-2 sm:px-2.5 py-0.5 text-xs font-semibold text-amber-600 dark:text-amber-400 ring-1 ring-amber-500/40 dark:ring-amber-500/30">
                                {{ $genre->name }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Stats - Mobile Layout --}}
                    <div class="flex items-center gap-3 sm:hidden text-xs text-gray-600 dark:text-gray-400">
                        {{-- Rating --}}
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="font-bold text-amber-600 dark:text-amber-400">{{ number_format($manga->rating ?? 8.5, 1) }}</span>
                        </div>

                        {{-- Views --}}
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">{{ number_format($manga->views) }}</span>
                        </div>

                        {{-- Chapters --}}
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">{{ $manga->chapters_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                {{-- Stats - Desktop Layout --}}
                <div class="hidden sm:flex relative z-10 flex-col items-end gap-2 pr-6">
                    {{-- Rating --}}
                    <div class="flex items-center gap-1.5 rounded-full bg-amber-500/30 dark:bg-amber-500/20 px-3 py-1.5 ring-1 ring-amber-500/50 dark:ring-amber-500/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-bold text-amber-600 dark:text-amber-400">{{ number_format($manga->rating ?? 8.5, 1) }}</span>
                    </div>

                    {{-- Views --}}
                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">{{ number_format($manga->views) }}</span>
                    </div>

                    {{-- Chapters Count --}}
                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">{{ $manga->chapters_count ?? 0 }}</span>
                    </div>
                </div>

                {{-- Hover Indicator --}}
                <div class="absolute right-0 top-0 h-full w-1 bg-linear-to-b from-amber-500 to-red-500 opacity-0 transition-opacity group-hover:opacity-100"></div>
            </article>
        @endforeach
    </div>
</section>