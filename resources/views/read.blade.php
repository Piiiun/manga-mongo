<x-layout
    :title="'Chapter ' . $chapter->number . ' - ' . Str::limit($manga->title, 20) . ' - Baca di MangaMongo'"
    :description="Str::limit($manga->description, 150)"
    :noNav="true"
    :noPadding="true    "
>
    <div id="reader-area" class="min-h-screen bg-linear-to-b from-gray-950 to-black">
        {{-- Header Navigation --}}
        <div id="reader-topbar" class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800">
            <div class="px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-between">
                    {{-- Left: Back Button --}}
                    <a href="{{ route('manga.detail', $manga->slug) }}" 
                       class="flex items-center gap-2 text-gray-300 hover:text-amber-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="hidden sm:inline">Kembali Ke Manga</span>
                    </a>

                    {{-- Center: Server Selector --}}
                    <div class="flex items-center gap-3">
                        <button class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                            </svg>
                            Server
                        </button>
                    </div>

                    {{-- Right: Action Buttons --}}
                    <div class="flex items-center gap-2">
                        <button onclick="scrollToComments()" class="p-2 hover:bg-gray-800 rounded-lg text-gray-300 hover:text-white transition-colors" title="Comments">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <span class="absolute top-3.5 ml-3 bg-red-500 text-white text-[10px] rounded-full w-3 h-3 flex items-center justify-center">
                                {{ $chapter->comments()->topLevel()->count() }}
                            </span>
                        </button>
                        <button 
                            type="button"
                            data-manga-id="{{ $manga->id }}"
                            class="bookmark-toggle p-2 hover:bg-gray-800 rounded-lg text-gray-300 hover:text-white transition-colors" title="Bookmark">
                            <svg class="bookmark-icon-outline w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            <svg class="bookmark-icon-filled w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button 
                            type="button"
                            id="share-button"
                            class="share-button p-2 hover:bg-gray-800 rounded-lg text-gray-300 hover:text-white transition-colors" title="Share"
                            aria-label="Share {{ $manga->title }}"
                            data-manga-title="{{ $manga->title }}"
                            data-manga-url="{{ route('manga.read', [$manga->slug, $chapter->number]) }}">
                            <x-icons.share class="share-icon" />
                        </button>
                        <button class="p-2 hover:bg-gray-800 rounded-lg text-gray-300 hover:text-white transition-colors" title="Settings">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                        <button class="p-2 hover:bg-gray-800 rounded-lg text-gray-300 hover:text-white transition-colors" title="Fullscreen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Info Chapter --}}
                <div class="mt-3 text-center">
                    <p class="text-gray-400 text-sm">
                        Halaman <span id="current-page">1</span> dari {{ $chapter->pages->count() }} - Server: Server Gambar 1 - Dibaca Selama: <span id="reading-time">0m 0s</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Title Section --}}
        <div class="text-center py-6 px-4">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                {{ $manga->title }}
            </h1>
            <h2 class="text-lg md:text-xl font-semibold text-amber-400">
                Chapter {{ $chapter->number }}
            </h2>
            <div class="mt-2 text-gray-400 text-sm">
                <span>{{ $chapter->published_at ? $chapter->published_at->format('d M Y') : $chapter->created_at->format('d M Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ number_format($chapter->views ?? 0) }} views</span>
            </div>
        </div>

        {{-- Checkbox untuk mode Webtoon --}}
        <div class="flex justify-center mb-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="webtoon-mode" class="w-4 h-4 text-amber-500 bg-gray-800 border-gray-700 rounded focus:ring-amber-500" checked>
                <span class="text-gray-300 text-sm">Hilangkan jarak antar gambar (mode Webtoon)</span>
            </label>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-center gap-4 mb-6 px-4">
            <a href="{{ route('manga.detail', $manga->slug) }}" 
               class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Manga Info
            </a>
            <button onclick="toggleChapterList()" 
                    class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Daftar Chapter
            </button>
        </div>

        {{-- Chapter List Modal --}}
        <div id="chapter-list-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 overflow-y-auto">
            <div class="min-h-screen px-4 py-8">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-white">Daftar Chapter</h3>
                            <button onclick="toggleChapterList()" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-2 max-h-[600px] overflow-y-auto">
                            @foreach($allChapters as $chap)
                                <a href="{{ route('manga.read', [$manga->slug, $chap->number]) }}" 
                                   class="block bg-gray-800/50 hover:bg-gray-800 border border-gray-700 hover:border-amber-500 rounded-lg p-4 transition-all
                                          {{ $chap->id === $chapter->id ? 'ring-2 ring-amber-500 bg-amber-500/10' : '' }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-white font-medium">
                                                Chapter {{ $chap->number }}
                                                @if($chap->title)
                                                    - {{ $chap->title }}
                                                @endif
                                            </h4>
                                            <p class="text-gray-400 text-sm mt-1">
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
        <div class="max-w-4xl mx-auto px-3 pb-16 sm:pb-24">
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

        {{-- Bottom Navigation --}}
        <div id="reader-bottombar">
            {{-- Bottom Navigation - Desktop Version --}}
            <div class="reader-bar hidden sm:block fixed bottom-0 left-0 right-0 bg-gray-900/95 backdrop-blur-sm border-t border-gray-800 py-4 z-40">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="flex items-center justify-between gap-4">
                        {{-- Previous Chapter --}}
                        @if($previousChapter)
                            <a href="{{ route('manga.read', [$manga->slug, $previousChapter->number]) }}" 
                               class="flex-1 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="font-medium">Chapter {{ $previousChapter->number }}</span>
                            </a>
                        @else
                            <div class="flex-1 bg-gray-900 border border-gray-800 text-gray-600 px-6 py-3 rounded-lg text-center cursor-not-allowed">
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
                               class="flex-1 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <span class="font-medium">Chapter {{ $nextChapter->number }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="flex-1 bg-gray-900 border border-gray-800 text-gray-600 px-6 py-3 rounded-lg text-center cursor-not-allowed">
                                <span class="font-medium">Tidak Ada</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bottom Navigation - Mobile Version --}}
            <div class="reader-bar sm:hidden fixed bottom-0 left-0 right-0 bg-gray-900/95 backdrop-blur-sm border-t border-gray-800 z-50">
                <div class="px-3 py-2">
                    <div class="flex items-center justify-between gap-2">
                        {{-- Previous Chapter --}}
                        @if($previousChapter)
                            <a href="{{ route('manga.read', [$manga->slug, $previousChapter->number]) }}" 
                               class="flex-1 bg-gray-800 active:bg-gray-700 border border-gray-700 text-white px-3 py-2.5 rounded-lg flex items-center justify-center gap-1.5 transition-colors touch-manipulation">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="text-sm font-medium">Prev</span>
                            </a>
                        @else
                            <div class="flex-1 bg-gray-900 border border-gray-800 text-gray-600 px-3 py-2.5 rounded-lg text-center cursor-not-allowed">
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
                               class="flex-1 bg-gray-800 active:bg-gray-700 border border-gray-700 text-white px-3 py-2.5 rounded-lg flex items-center justify-center gap-1.5 transition-colors touch-manipulation">
                                <span class="text-sm font-medium">Next</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="flex-1 bg-gray-900 border border-gray-800 text-gray-600 px-3 py-2.5 rounded-lg text-center cursor-not-allowed">
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
            <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Diskusi Chapter {{ $chapter->number }}
                    <span class="text-sm font-normal text-gray-400">({{ $chapter->comments()->topLevel()->count() }} komentar)</span>
                </h2>

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
                            {{-- Avatar --}}
                            <img src="{{ Auth::user()->profile_picture_url }}" 
                                alt="{{ Auth::user()->name }}"
                                class="w-10 h-10 rounded-full border-2 border-gray-700 flex-shrink-0">
                            
                            {{-- Form --}}
                            <div class="flex-1">
                                <textarea name="content" 
                                        rows="3" 
                                        required
                                        placeholder="Bagaimana pendapat kamu tentang chapter ini?"
                                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-amber-500 resize-none"></textarea>
                                
                                <div class="flex items-center justify-between mt-3">
                                    <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                                        <input type="checkbox" name="is_spoiler" value="1" class="rounded border-gray-600 text-amber-500 focus:ring-amber-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Tandai sebagai spoiler
                                        </span>
                                    </label>
                                    
                                    <button type="submit" 
                                            class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-lg transition-colors">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-6 text-center mb-8">
                        <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-400 mb-4">Login untuk berkomentar dan berdiskusi dengan pembaca lain</p>
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
                        <h3 class="text-lg font-semibold text-white">
                            Semua Komentar ({{ $comments->count() }})
                        </h3>
                        
                        <select class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                                onchange="sortComments(this.value)">
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
                        <p class="text-gray-400 text-lg mb-2">Belum ada komentar</p>
                        <p class="text-gray-500 text-sm">Jadilah yang pertama berkomentar tentang chapter ini!</p>
                    </div>
                @endif
            </div>

            {{-- Info Tips --}}
            <div class="mt-6 bg-gray-900/30 border border-gray-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-gray-400">
                        <p class="font-semibold text-gray-300 mb-1">Tips Berkomentar:</p>
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

    <script>
        // Reading Timer
        let readingSeconds = 0;
        let timerInterval;
        
        function startReadingTimer() {
            timerInterval = setInterval(() => {
                readingSeconds++;
                const minutes = Math.floor(readingSeconds / 60);
                const seconds = readingSeconds % 60;
                document.getElementById('reading-time').textContent = `${minutes}m ${seconds}s`;
            }, 1000);
        }

        // Current Page Tracker dengan Intersection Observer
        const pageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const pageNumber = entry.target.getAttribute('data-page');
                    document.getElementById('current-page').textContent = pageNumber;
                }
            });
        }, {
            threshold: 0.5, // 50% dari gambar harus terlihat
            rootMargin: '-100px 0px -100px 0px'
        });
        
        // Observe semua manga pages
        document.addEventListener('DOMContentLoaded', function() {
            const pages = document.querySelectorAll('.manga-page');
            pages.forEach(page => {
                pageObserver.observe(page);
            });
        });

        // Webtoon Mode Toggle
        const webtoonCheckbox = document.getElementById('webtoon-mode');
        const mangaPages = document.getElementById('manga-pages');

        webtoonCheckbox.addEventListener('change', function() {
            if (this.checked) {
                mangaPages.classList.remove('space-y-4');
                mangaPages.classList.add('space-y-0');
            } else {
                mangaPages.classList.remove('space-y-0');
                mangaPages.classList.add('space-y-4');
            }
        });

        // Toggle Chapter List
        function toggleChapterList() {
            const modal = document.getElementById('chapter-list-modal');
            modal.classList.toggle('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('chapter-list-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                toggleChapterList();
            }
        });

        // Scroll to Top Button
        window.addEventListener('scroll', function() {
            const scrollButton = document.getElementById('scroll-to-top');
            if (window.scrollY > 500) {
                scrollButton.classList.remove('hidden');
            } else {
                scrollButton.classList.add('hidden');
            }
        });

        // Fullscreen Toggle
        document.querySelector('[title="Fullscreen"]')?.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });
        
        // Start reading timer on page load
        startReadingTimer();

        // Save reading progress (optional - bisa ditambahkan ke backend)
        window.addEventListener('beforeunload', function() {
            // Kirim data reading progress ke server
            console.log('Reading time:', readingSeconds, 'seconds');
        });
        
        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            // Left Arrow - Previous Chapter
            if (e.key === 'ArrowLeft') {
                const prevButton = document.querySelector('a[href*="Chapter"][href*="{{ $previousChapter?->number ?? '' }}"]');
                if (prevButton) prevButton.click();
            }
            // Right Arrow - Next Chapter
            if (e.key === 'ArrowRight') {
                const nextButton = document.querySelector('a[href*="Chapter"][href*="{{ $nextChapter?->number ?? '' }}"]');
                if (nextButton) nextButton.click();
            }
            // M - Toggle Chapter List
            // if (e.key === 'm' || e.key === 'M') {
            //     toggleChapterList();
            // }
        });
        </script>
        <script>
            function sortComments(sortType) {
                const container = document.getElementById('comments-container');
                const comments = Array.from(container.children);
                
                comments.sort((a, b) => {
                    if (sortType === 'newest') {
                        // Already sorted by default
                        return 0;
                    } else if (sortType === 'oldest') {
                        // Reverse order
                        return Array.from(container.children).indexOf(b) - Array.from(container.children).indexOf(a);
                    } else if (sortType === 'most-liked') {
                        const likesA = parseInt(a.querySelector('.likes-count')?.textContent || 0);
                        const likesB = parseInt(b.querySelector('.likes-count')?.textContent || 0);
                        return likesB - likesA;
                    }
                });
                
                container.innerHTML = '';
                comments.forEach(comment => container.appendChild(comment));
            }

            function scrollToComments() {
                const commentsSection = document.querySelector('#comments-container');
                if (commentsSection) {
                    commentsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    // If no comments yet, scroll to comment form
                    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                }
            }
        </script>
</x-layout>