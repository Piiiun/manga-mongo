<x-layout
    :title="'Chapter ' . $chapter->number . ' - ' . Str::limit($manga->title, 20) . ' - Baca di MangaMongo'"
    :description="Str::limit($manga->description, 150)"
    :noNav="true"
    :noPadding="true    "
>
    <div id="reader-area" class="min-h-screen">
        {{-- Header Navigation --}}
        <div id="reader-topbar" class="sticky top-0 z-50 bg-slate-100/90 dark:bg-gray-900/95 backdrop-blur-sm border-b border-gray-800">
            <div class="px-2 sm:px-4 lg:px-6 py-1.5 sm:py-2">
                {{-- Mobile: Single Row Layout --}}
                <div class="flex items-center justify-between gap-2 sm:hidden">
                    <a href="{{ route('manga.detail', $manga->slug) }}" 
                       class="p-1 text-gray-600 dark:text-gray-300 hover:text-amber-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    
                    {{-- Auto Scroll Controls (Smaller for Mobile) --}}
                    {{-- <button class="bg-slate-200 dark:bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-3 py-1.5 rounded-lg text-xs flex items-center gap-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </button> --}}
                    <div id="autoscroll-container" class="flex items-center gap-1 bg-slate-200 dark:bg-gray-800 border border-gray-700 rounded px-1.5 py-1">
                        <button id="autoscroll-play" type="button" class="p-1 hover:bg-gray-700 rounded text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Mulai Auto Scroll">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <button id="autoscroll-pause" type="button" class="p-1 hover:bg-gray-700 rounded text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors hidden" title="Hentikan Auto Scroll">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <select id="autoscroll-speed-mobile" class="bg-slate-300 dark:bg-gray-900 border border-gray-700 text-black dark:text-white text-[10px] rounded px-1 py-0.5 focus:outline-none focus:ring-1 focus:ring-amber-500 cursor-pointer">
                            <option value="slow">L</option>
                            <option value="normal" selected>N</option>
                            <option value="fast">C</option>
                            <option value="veryFast">SC</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-1">
                        <button 
                            type="button"
                            data-manga-id="{{ $manga->id }}"
                            class="bookmark-toggle p-1.5 hover:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Bookmark">
                            <svg class="bookmark-icon-outline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            <svg class="bookmark-icon-filled w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button onclick="window.scrollToComments && window.scrollToComments()" class="p-1.5 hover:bg-gray-800 rounded text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors relative" title="Comments">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            @if($chapter->comments()->topLevel()->count() > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] rounded-full w-3 h-3 flex items-center justify-center">
                                {{ $chapter->comments()->topLevel()->count() }}
                            </span>
                            @endif
                        </button>
                        <button class="p-1.5 hover:bg-gray-800 rounded text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Fullscreen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Desktop: Multi Row Layout --}}
                <div class="hidden sm:block">
                    <div class="flex items-center justify-between gap-3 mb-2">
                        {{-- Left: Back Button --}}
                        <a href="{{ route('manga.detail', $manga->slug) }}" 
                           class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-amber-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="hidden lg:inline">Kembali Ke Manga</span>
                        </a>

                        {{-- Center: Server Selector & Auto Scroll --}}
                        <div class="flex items-center justify-center gap-2">
                            {{-- <button class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-3 py-1.5 rounded-lg text-xs flex items-center gap-1.5 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                                <span class="hidden md:inline">Server</span>
                            </button> --}}
                            
                            {{-- Auto Scroll Controls (Smaller) --}}
                            <div id="autoscroll-container-desktop" class="flex items-center gap-1.5 bg-slate-200 dark:bg-gray-800 border border-gray-700 rounded-lg px-2 py-1">
                                <button id="autoscroll-play-desktop" type="button" class="p-1 hover:bg-slate-400 hover:dark:bg-gray-700 rounded text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Mulai Auto Scroll">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                                <button id="autoscroll-pause-desktop" type="button" class="p-1  hover:bg-slate-400 hover:dark:bg-gray-700 rounded text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors hidden" title="Hentikan Auto Scroll">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                                <select id="autoscroll-speed" class="bg-slate-300 dark:bg-gray-900 border border-gray-700 text-black dark:text-white text-[11px] rounded px-1.5 py-0.5 focus:outline-none focus:ring-1 focus:ring-amber-500 cursor-pointer">
                                    <option value="slow">Lambat</option>
                                    <option value="normal" selected>Normal</option>
                                    <option value="fast">Cepat</option>
                                    <option value="veryFast">Sangat Cepat</option>
                                </select>
                            </div>
                        </div>

                        {{-- Right: Action Buttons --}}
                        <div class="flex items-center gap-1.5">
                            <button onclick="window.scrollToComments && window.scrollToComments()" class="p-1.5 hover:bg-slate-400 hover:dark:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors relative" title="Comments">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                @if($chapter->comments()->topLevel()->count() > 0)
                                <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] rounded-full w-3.5 h-3.5 flex items-center justify-center">
                                    {{ $chapter->comments()->topLevel()->count() }}
                                </span>
                                @endif
                            </button>
                            <button 
                                type="button"
                                data-manga-id="{{ $manga->id }}"
                                class="bookmark-toggle p-1.5 hover:bg-slate-400 hover:dark:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Bookmark">
                                <svg class="bookmark-icon-outline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                <svg class="bookmark-icon-filled w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <button 
                                type="button"
                                id="share-button"
                                class="share-button p-1.5 hover:bg-slate-400 hover:dark:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Share"
                                aria-label="Share {{ $manga->title }}"
                                data-manga-title="{{ $manga->title }}"
                                data-manga-url="{{ route('manga.read', [$manga->slug, $chapter->number]) }}">
                                <x-icons.share class="share-icon w-4 h-4" />
                            </button>
                            <button class="p-1.5 hover:bg-slate-400 hover:dark:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Settings">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                            <button class="p-1.5 hover:bg-slate-400 hover:dark:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-300 hover:text-black hover:dark:text-white transition-colors" title="Fullscreen">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info Chapter --}}
                <div class="mt-2 sm:mt-3 text-center px-2">
                    <p class="text-gray-700 dark:text-gray-400 text-xs sm:text-sm">
                        Halaman <span id="current-page">1</span> dari {{ $chapter->pages->count() }} - Dibaca Selama: <span id="reading-time">0m 0s</span>
                    </p>
                </div>
            </div>
        </div>
{{-- - Server: Server Gambar 1  --}}
        {{-- Auto Scroll Login Modal (for Guest) --}}
        <x-login-modal 
            id="autoscroll-login-modal"
            title="Login untuk Memakai Fitur Auto Scroll"
            description="Fitur Auto Scroll memungkinkan Anda membaca manga secara otomatis dengan berbagai kecepatan. Login untuk mengakses fitur ini."
            :icon="'<svg class=\'w-8 h-8 text-amber-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M21 12a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>'"
            loginRoute="login"
            closeFunction="closeAutoscrollLoginModal"
        />

        {{-- Title Section --}}
        <div class="text-center py-6 px-4">
            <h1 class="text-2xl md:text-3xl font-bold text-black dark:text-white mb-2">
                {{ $manga->title }}
            </h1>
            <h2 class="text-lg md:text-xl font-semibold text-amber-400">
                Chapter {{ $chapter->number }}
            </h2>
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <span>{{ $chapter->published_at ? $chapter->published_at->format('d M Y') : $chapter->created_at->format('d M Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ number_format($chapter->views ?? 0) }} views</span>
            </div>
        </div>

        {{-- Checkbox untuk mode Webtoon --}}
        <div class="flex justify-center mb-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="webtoon-mode" class="w-4 h-4 accent-amber-500" checked>
                <span class="text-gray-700 dark:text-gray-300 sm:text-sm text-xs">Hilangkan jarak antar gambar (mode Webtoon)</span>
            </label>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-center gap-4 mb-6 px-4">
            <a href="{{ route('manga.detail', $manga->slug) }}" 
               class="bg-slate-300 dark:bg-gray-800 hover:bg-slate-400 hover:dark:bg-gray-700 border border-gray-700 text-black dark:text-white text-sm sm:text-base px-2 sm:px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Manga Info
            </a>
            <button onclick="window.toggleChapterList && window.toggleChapterList()" 
                    class="bg-slate-300 dark:bg-gray-800 hover:bg-slate-400 hover:dark:bg-gray-700 border border-gray-700 text-black dark:text-white text-sm sm:text-base px-2 sm:px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Daftar Chapter
            </button>
        </div>

        {{-- Chapter List Modal --}}
        <div id="chapter-list-modal" class="hidden fixed inset-0 bg-white/50 dark:bg-black/80 backdrop-blur-sm z-50 overflow-y-auto">
            <div class="min-h-screen px-4 py-8">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-slate-200 dark:bg-gray-900 rounded-xl border border-gray-800 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-black dark:text-white">Daftar Chapter</h3>
                            <button onclick="window.toggleChapterList && window.toggleChapterList()" class="text-gray-600 dark:text-gray-400 hover:text-black hover:dark:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-2 max-h-[600px] overflow-y-auto
                            [&::-webkit-scrollbar]:w-2
                            [&::-webkit-scrollbar-track]:bg-gray-100
                            [&::-webkit-scrollbar-thumb]:bg-gray-300
                            dark:[&::-webkit-scrollbar-track]:bg-neutral-700
                            dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                            @foreach($allChapters as $chap)
                                <a href="{{ route('manga.read', [$manga->slug, $chap->number]) }}" 
                                   class="block bg-slate-100/50 dark:bg-gray-800/50 hover:bg-slate-100/50 dark:hover:bg-gray-800 border border-gray-700 hover:border-2 box-border hover:dark:border-amber-500 rounded-lg p-4 transition-all
                                          {{ $chap->id === $chapter->id ? 'ring-2 ring-amber-500 bg-amber-500/10' : '' }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-black dark:text-white font-medium">
                                                Chapter {{ $chap->number }}
                                                @if($chap->title)
                                                    - {{ $chap->title }}
                                                @endif
                                            </h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                                {{ $chap->published_at ? $chap->published_at->diffForHumans() : $chap->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if($chap->id === $chapter->id)
                                            <span class="bg-amber-500 text-black text-xs font-bold px-3 py-1 rounded-full">
                                                Sedang Dibaca
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Manga Pages - Vertical Scroll --}}
        <div class="max-w-4xl mx-auto px-2 pb-16 sm:pb-24">
            <div id="manga-pages" class="space-y-0">
                @foreach($chapter->pages->sortBy('page_number') as $page)
                    <div class="manga-page w-full" data-page="{{ $page->page_number }}">
                        <img 
                            src="{{ asset('storage/' . $page->image_path) }}" 
                            alt="Page {{ $page->page_number }}"
                            class="w-full h-auto"
                            loading="lazy"
                            onerror="this.src='https://via.placeholder.com/800x1200/1f2937/9ca3af?text=Image+Not+Found'"
                        >
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-center gap-4 mb-6 px-4">
            <a href="{{ route('manga.detail', $manga->slug) }}" 
               class="bg-slate-300 dark:bg-gray-800 hover:bg-slate-400 hover:dark:bg-gray-700 border border-gray-700 text-black dark:text-white text-sm sm:text-base px-2 sm:px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Manga Info
            </a>
            <button onclick="window.toggleChapterList && window.toggleChapterList()" 
                    class="bg-slate-300 dark:bg-gray-800 hover:bg-slate-400 hover:dark:bg-gray-700 border border-gray-700 text-black dark:text-white text-sm sm:text-base px-2 sm:px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Daftar Chapter
            </button>
        </div>

        {{-- Bottom Navigation --}}
        <div id="reader-bottombar">
            {{-- Bottom Navigation - Desktop Version --}}
            <div class="reader-bar hidden sm:block fixed bottom-0 left-0 right-0 bg-slate-100/90 dark:bg-gray-900/95 backdrop-blur-sm border-t border-gray-800 py-4 z-40">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="flex items-center justify-between gap-4">
                        {{-- Previous Chapter --}}
                        @if($previousChapter)
                            <a href="{{ route('manga.read', [$manga->slug, $previousChapter->number]) }}" 
                               class="flex-1 bg-slate-300 dark:bg-gray-800 active:bg-slate-200 active:dark:bg-gray-700 border border-gray-700 text-black dark:text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="font-medium">Chapter {{ $previousChapter->number }}</span>
                            </a>
                        @else
                            <div class="flex-1 bg-slate-400 dark:bg-gray-900 border border-gray-800 text-gray-700 dark:text-gray-600 px-6 py-3 rounded-lg text-center cursor-not-allowed">
                                <span class="font-medium">Tidak Ada</span>
                            </div>
                        @endif

                        {{-- Back to Manga Info --}}
                        <a href="{{ route('manga.detail', $manga->slug) }}" 
                           class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Manga Info
                        </a>

                        {{-- Next Chapter --}}
                        @if($nextChapter)
                            <a href="{{ route('manga.read', [$manga->slug, $nextChapter->number]) }}" 
                               class="flex-1 bg-slate-300 dark:bg-gray-800 active:bg-slate-200 active:dark:bg-gray-700 border border-gray-700 text-black dark:text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <span class="font-medium">Chapter {{ $nextChapter->number }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="flex-1 bg-slate-400 dark:bg-gray-900 border border-gray-800 text-gray-700 dark:text-gray-600 px-6 py-3 rounded-lg text-center cursor-not-allowed">
                                <span class="font-medium">Tidak Ada</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bottom Navigation - Mobile Version --}}
            <div class="reader-bar sm:hidden fixed bottom-0 left-0 right-0 bg-slate-100/90 dark:bg-gray-900/95 backdrop-blur-sm border-t border-gray-800 z-50">
                <div class="px-3 py-2">
                    <div class="flex items-center justify-between gap-2">
                        {{-- Previous Chapter --}}
                        @if($previousChapter)
                            <a href="{{ route('manga.read', [$manga->slug, $previousChapter->number]) }}" 
                               class="flex-1 bg-slate-300 dark:bg-gray-800 active:bg-slate-200 active:dark:bg-gray-700 border border-gray-700 text-black dark:text-white px-3 py-2.5 rounded-lg flex items-center justify-center gap-1.5 transition-colors touch-manipulation">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="text-sm font-medium">Prev</span>
                            </a>
                        @else
                            <div class="flex-1 bg-slate-400 dark:bg-gray-900 border border-gray-800 text-gray-700 dark:text-gray-600 px-3 py-2.5 rounded-lg text-center cursor-not-allowed">
                                <span class="text-sm font-medium">-</span>
                            </div>
                        @endif

                        {{-- Back to Manga Info --}}
                        <a href="{{ route('manga.detail', $manga->slug) }}" 
                           class="bg-amber-500 active:bg-amber-600 text-white px-4 py-2.5 rounded-lg font-medium transition-colors text-sm touch-manipulation">
                            Info
                        </a>

                        {{-- Next Chapter --}}
                        @if($nextChapter)
                            <a href="{{ route('manga.read', [$manga->slug, $nextChapter->number]) }}" 
                               class="flex-1 bg-slate-300 dark:bg-gray-800 active:bg-slate-200 active:dark:bg-gray-700 border border-gray-700 text-black dark:text-white px-3 py-2.5 rounded-lg flex items-center justify-center gap-1.5 transition-colors touch-manipulation">
                                <span class="text-sm font-medium">Next</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="flex-1 bg-slate-400 dark:bg-gray-900 border border-gray-800 text-gray-700 dark:text-gray-600 px-3 py-2.5 rounded-lg text-center cursor-not-allowed">
                                <span class="text-sm font-medium">-</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Scroll to Top Button --}}
            <button id="scroll-to-top" 
                    class="reader-aux hidden fixed bottom-16 sm:bottom-24 right-4 sm:right-6 bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white p-2.5 sm:p-3 rounded-full shadow-lg transition-all z-30 touch-manipulation"
                    onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            </button>
        </div>

        {{-- Comment Section --}}
        <div id="comments-section" class="max-w-4xl mx-auto px-4 mt-12 mb-24">
            <div class="bg-slate-200/50 dark:bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <div class="sm:flex items-center justify-between mb-2 sm:mb-6">
                    <h2 class="text-lg sm:text-xl font-bold text-black dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Diskusi Chapter {{ $chapter->number }}
                    </h2>
                    <span class="text-xs sm:text-sm font-normal text-gray-600 dark:text-gray-400">({{ $chapter->comments()->topLevel()->count() }} komentar)</span>
                </div>

                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Comment Form --}}
                @auth
                    <form method="POST" action="{{ route('comments.store.chapter', [$manga, $chapter]) }}" class="mb-8">
                        @csrf
                        
                        <div class="flex gap-3">
                            {{-- Form --}}
                            <div class="flex-1">
                                <textarea name="content" 
                                        rows="3" 
                                        required
                                        placeholder="Bagaimana pendapat kamu tentang chapter ini?"
                                        class="w-full px-4 py-3 bg-gray-300 dark:bg-gray-800 border border-gray-700 rounded-lg text-black dark:text-white placeholder-gray-600 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"></textarea>
                                
                                <div class="flex items-center justify-between mt-1 sm:mt-3">
                                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer mb-2 sm:mb-0">
                                        <input type="checkbox" name="is_spoiler" value="1" class="rounded border-gray-600 text-amber-500 focus:ring-amber-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Tandai sebagai spoiler
                                        </span>
                                    </label>
                                    
                                    <button type="submit" 
                                            class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-black font-bold rounded-2xl sm:rounded-lg transition-colors">
                                        <span class="hidden sm:block">Kirim Komentar</span>
                                        <svg class="sm:hidden w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                            <path d="M11.5003 12H5.41872M5.24634 12.7972L4.24158 15.7986C3.69128 17.4424 3.41613 18.2643 3.61359 18.7704C3.78506 19.21 4.15335 19.5432 4.6078 19.6701C5.13111 19.8161 5.92151 19.4604 7.50231 18.7491L17.6367 14.1886C19.1797 13.4942 19.9512 13.1471 20.1896 12.6648C20.3968 12.2458 20.3968 11.7541 20.1896 11.3351C19.9512 10.8529 19.1797 10.5057 17.6367 9.81135L7.48483 5.24303C5.90879 4.53382 5.12078 4.17921 4.59799 4.32468C4.14397 4.45101 3.77572 4.78336 3.60365 5.22209C3.40551 5.72728 3.67772 6.54741 4.22215 8.18767L5.24829 11.2793C5.34179 11.561 5.38855 11.7019 5.407 11.8459C5.42338 11.9738 5.42321 12.1032 5.40651 12.231C5.38768 12.375 5.34057 12.5157 5.24634 12.7972Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-slate-200 dark:bg-gray-800/50 border border-gray-700 rounded-lg p-6 text-center mb-8">
                        <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Login untuk berkomentar dan berdiskusi dengan pembaca lain</p>
                        <a href="{{ route('login') }}" 
                        class="inline-block bg-amber-500 hover:bg-amber-600 text-black font-bold px-6 py-2.5 rounded-lg transition-colors">
                            Login Sekarang
                        </a>
                    </div>
                @endauth

                {{-- Comments List --}}
                @php
                    $comments = $chapter->comments()
                        ->topLevel()
                        ->with(['user', 'replies.user', 'replies.replies.user'])
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp

                {{-- Sort Options --}}
                @if($comments->count() > 0)
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800">
                        <h3 class="text-lg font-semibold text-black dark:text-white">
                            Semua Komentar ({{ $comments->count() }})
                        </h3>
                        
                        <select class="bg-slate-200 dark:bg-gray-800 border border-gray-700 text-black dark:text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                                onchange="window.sortComments && window.sortComments(this.value)">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="most-liked">Paling Disukai</option>
                        </select>
                    </div>
                    
                    <div id="comments-container" class="space-y-4">
                        @foreach($comments as $comment)
                            <x-comment-item :comment="$comment" :manga="$manga" :chapter="$chapter" />
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 text-lg mb-2">Belum ada komentar</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm">Jadilah yang pertama berkomentar tentang chapter ini!</p>
                    </div>
                @endif
            </div>

            {{-- Info Tips --}}
            <div class="mt-6 bg-slate-300/30 dark:bg-gray-900/30 border border-gray-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Tips Berkomentar:</p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Gunakan tag spoiler jika membahas plot penting</li>
                            <li>Hormati pendapat pembaca lain</li>
                            <li>Jangan spam atau post link berbahaya</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-share-modal :manga="$manga"/>
</x-layout>