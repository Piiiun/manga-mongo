<x-layout
    :title="'Chapter ' . $chapter->number . ' - ' . Str::limit($manga->title, 20) . ' - Baca di MangaMongo'"
    :description="Str::limit($manga->description, 150)"
    :noNav="true"
    :noPadding="true    "
>
    <div id="reader-area" class="min-h-screen">
        @php
            // Ensure safe variables when $chapter comes from external API (stdClass)
            if (!isset($chapterCommentsCount)) {
                $chapterCommentsCount = (is_object($chapter) && method_exists($chapter, 'comments'))
                    ? $chapter->comments()->topLevel()->count()
                    : 0;
            }

            if (!isset($comments)) {
                if (is_object($chapter) && method_exists($chapter, 'comments')) {
                    $comments = $chapter->comments()
                        ->topLevel()
                        ->with(['user', 'replies.user', 'replies.replies.user'])
                        ->orderBy('created_at', 'desc')
                        ->get();
                } else {
                    $comments = collect();
                }
            }

            if (!isset($chapterPagesCount)) {
                if (isset($chapterPages)) {
                    $chapterPagesCount = is_countable($chapterPages) ? count($chapterPages) : (method_exists($chapterPages, 'count') ? $chapterPages->count() : 0);
                } else {
                    $chapterPagesCount = (is_object($chapter) && method_exists($chapter, 'pages'))
                        ? $chapter->pages->count()
                        : (isset($chapter->pages) && is_countable($chapter->pages) ? count($chapter->pages) : 0);
                }
            }

            // Determine a safe published date string using API field names if necessary
            if (!isset($chapterPublishedAt)) {
                $chapterPublishedAt = '';
                try {
                    if (isset($chapter->published_at) && $chapter->published_at) {
                        $chapterPublishedAt = \Carbon\Carbon::parse($chapter->published_at)->format('d M Y');
                    } elseif (isset($chapter->release_date) && $chapter->release_date) {
                        $chapterPublishedAt = \Carbon\Carbon::parse($chapter->release_date)->format('d M Y');
                    } elseif (isset($chapter->created_at) && $chapter->created_at) {
                        $chapterPublishedAt = \Carbon\Carbon::parse($chapter->created_at)->format('d M Y');
                    }
                } catch (\Exception $e) {
                    // fallback to raw values if parsing fails
                    if (isset($chapter->published_at)) $chapterPublishedAt = $chapter->published_at;
                    elseif (isset($chapter->release_date)) $chapterPublishedAt = $chapter->release_date;
                    elseif (isset($chapter->created_at)) $chapterPublishedAt = $chapter->created_at;
                }
            }
        @endphp
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
                            @if($chapterCommentsCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] rounded-full w-3 h-3 flex items-center justify-center">
                                    {{ $chapterCommentsCount }}
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
                                @if($chapterCommentsCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] rounded-full w-3.5 h-3.5 flex items-center justify-center">
                                    {{ $chapterCommentsCount }}
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
                        Halaman <span id="current-page">1</span> dari {{ $chapterPagesCount }} - Dibaca Selama: <span id="reading-time">0m 0s</span>
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
                <span>{{ $chapterPublishedAt }}</span>
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
                                            @php
                                                $chapDateText = '';
                                                try {
                                                    if (isset($chap->published_at) && $chap->published_at) {
                                                        $chapDateText = \Carbon\Carbon::parse($chap->published_at)->diffForHumans();
                                                    } elseif (isset($chap->release_date) && $chap->release_date) {
                                                        $chapDateText = \Carbon\Carbon::parse($chap->release_date)->diffForHumans();
                                                    } elseif (isset($chap->created_at) && $chap->created_at) {
                                                        $chapDateText = \Carbon\Carbon::parse($chap->created_at)->diffForHumans();
                                                    }
                                                } catch (\Exception $e) {
                                                    $chapDateText = isset($chap->published_at) ? $chap->published_at : (isset($chap->created_at) ? $chap->created_at : '');
                                                }
                                            @endphp
                                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                                {{ $chapDateText }}
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
                @foreach( isset($chapterPages) ? $chapterPages : (is_object($chapter) && method_exists($chapter, 'pages') ? $chapter->pages->sortBy('page_number') : (isset($chapter->pages) ? collect($chapter->pages) : collect())) as $page)
                    @php
                        $pageSrc = (isset($page->image_path) && str_starts_with($page->image_path, 'http'))
                            ? $page->image_path
                            : (isset($page->image_path) ? asset('storage/' . $page->image_path) : '');
                    @endphp
                    <div class="manga-page w-full" data-page="{{ $page->page_number }}">
                        <img 
                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                            data-src="{{ $pageSrc }}"
                            alt="Page {{ $page->page_number }}"
                            class="lazyload w-full h-auto"
                            loading="lazy"
                            decoding="async"
                            draggable="false"
                            onerror="this.src='https://via.placeholder.com/800x1200/1f2937/9ca3af?text=Image+Not+Found'"
                        >
                        <noscript>
                            <img
                                src="{{ $pageSrc }}"
                                alt="Page {{ $page->page_number }}"
                                class="w-full h-auto"
                                decoding="async"
                                draggable="false"
                                onerror="this.src='https://via.placeholder.com/800x1200/1f2937/9ca3af?text=Image+Not+Found'"
                            >
                        </noscript>
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

        {{-- Comment Button (opens modal) --}}
        <div class="max-w-4xl mx-auto px-4 mt-8 mb-16">
            <button onclick="window.openCommentsModal()"
                    class="w-full flex items-center justify-between gap-3 bg-slate-200/50 dark:bg-gray-900/50 border border-gray-800 hover:border-amber-500/50 rounded-xl p-4 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-black dark:text-white font-semibold text-sm sm:text-base">Diskusi Chapter {{ $chapter->number }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">{{ $chapterCommentsCount }} komentar</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-amber-400 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <x-chapter-comments-modal :comments="$comments" :manga="$manga" :chapter="$chapter" :chapterCommentsCount="$chapterCommentsCount" />
    <x-share-modal :manga="$manga"/>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lazyImages = [].slice.call(document.querySelectorAll('img.lazyload'));

            if ('IntersectionObserver' in window) {
                const lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            const dataSrc = img.getAttribute('data-src');
                            if (dataSrc) {
                                img.src = dataSrc;
                                img.removeAttribute('data-src');
                            }
                            img.classList.remove('lazyload');
                            lazyImageObserver.unobserve(img);
                        }
                    });
                }, {
                    rootMargin: '200px 0px',
                    threshold: 0.01
                });

                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            } else {
                // Fallback for browsers without IntersectionObserver
                lazyImages.forEach(function(lazyImage) {
                    const dataSrc = lazyImage.getAttribute('data-src');
                    if (dataSrc) {
                        lazyImage.src = dataSrc;
                        lazyImage.removeAttribute('data-src');
                    }
                    lazyImage.classList.remove('lazyload');
                });
            }
        });
    </script>
    @endpush
</x-layout>
