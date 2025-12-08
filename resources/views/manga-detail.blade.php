<x-layout title="Manga Detail - MangaMongo">
    <div class="min-h-screen bg-linear-to-b from-gray-950 to-black">
        {{-- Breadcrumb --}}
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('manga.list') }}" class="hover:text-amber-400 transition-colors">Manga</a>
                <span>/</span>
                <span class="text-white">{{ $manga->title }}</span>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="px-4 sm:px-6 lg:px-8 pb-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Left Side - Cover & Info --}}
                <div class="lg:col-span-3">
                    <div class="sticky top-24">
                        {{-- Cover Image --}}
                        <div class="relative rounded-xl overflow-hidden shadow-2xl mb-4 md:mx-auto md:max-w-xs">
                            @if($manga->rating >= 8.5)
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="bg-linear-to-r from-red-600 to-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                        {{ number_format($manga->rating, 1) }} ★
                                    </span>
                                </div>
                            @endif
                            <img 
                                src="{{ asset('storage/manga/' . $manga->cover_image) }}" 
                                alt="{{ $manga->title }}"
                                class="w-full aspect-3/4 object-cover"
                            >
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <button id="bookmark-btn"
                                    data-manga-id="{{ $manga->id }}"
                                    class="bg-gray-900 hover:bg-amber-800 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                </svg>
                                <span id="bookmark-text" class="text-sm font-medium">Bookmark</span>
                            </button>
                            <button class="bg-gray-900 hover:bg-gray-800 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span class="text-sm font-medium">Rate</span>
                            </button>
                        </div>

                        <button class="w-full bg-gray-900 hover:bg-gray-800 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            <span class="text-sm font-medium">Share</span>
                        </button>

                        @if($manga->chapters->count() > 0)
                            <a href="{{ route('manga.read', [$manga->slug, $manga->chapters->first()->number]) }}" 
                               class="block w-full bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl px-4 py-3 text-center transition-colors">
                                📖 Baca Dari Awal
                            </a>
                        @else
                            <div class="block w-full bg-gray-800 text-gray-500 font-bold rounded-xl px-4 py-3 text-center cursor-not-allowed">
                                📖 Belum Ada Chapter
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Side - Details --}}
                <div class="lg:col-span-9">
                    {{-- Title & Rating --}}
                    <div class="mb-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ $manga->title }}</h1>
                        
                        {{-- Genres --}}
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($manga->genres as $genre)
                                <a href="{{ route('manga.list', ['genre' => $genre->slug]) }}">
                                    <span class="bg-gray-800 hover:bg-amber-500 text-gray-300 hover:text-white text-sm px-3 py-1.5 rounded-lg border border-gray-700 hover:border-amber-500 transition-colors cursor-pointer">
                                        {{ $genre->name }}
                                    </span>
                                </a>
                            @endforeach
                        </div>

                        {{-- Meta Info --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-900/50 border border-gray-800 rounded-xl p-4">
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Author:</p>
                                <p class="text-white font-medium">{{ $manga->author ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Artist:</p>
                                <p class="text-white font-medium">{{ $manga->artist ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Status:</p>
                                <p class="font-medium
                                    @if($manga->status == 'Ongoing')
                                        text-green-400
                                    @else
                                        text-blue-400
                                    @endif
                                ">
                                    {{ strtoupper($manga->status) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Type:</p>
                                <p class="text-white font-medium">{{ $manga->type ?? 'Manga' }}</p>
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 text-center">
                                <p class="text-2xl font-bold text-amber-400">{{ $manga->formatted_views }}</p>
                                <p class="text-gray-400 text-sm mt-1">Views</p>
                            </div>
                            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 text-center">
                                <p class="text-2xl font-bold text-white">{{ $manga->bookmarks->count() }}</p>
                                <p class="text-gray-400 text-sm mt-1">Bookmark</p>
                            </div>
                            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 text-center">
                                <p class="text-2xl font-bold text-white">{{ number_format($manga->rating ?? 0, 1) }}</p>
                                <p class="text-gray-400 text-sm mt-1">Rating</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="mb-8">
                        <div class="border-b border-gray-800">
                            <nav class="flex gap-6 overflow-auto">
                                <button onclick="showTab('chapters')" id="tab-chapters" class="tab-button text-amber-400 border-b-2 border-amber-400 px-1 py-3 font-bold">
                                    Chapters
                                </button>
                                <button onclick="showTab('comments')" id="tab-comments" class="tab-button text-gray-400 hover:text-white border-b-2 border-transparent px-1 py-3 transition-colors">
                                    Comments
                                </button>
                                <button onclick="showTab('details')" id="tab-details" class="tab-button text-gray-400 hover:text-white border-b-2 border-transparent px-1 py-3 transition-colors">
                                    Details
                                </button>
                                <button onclick="showTab('gallery')" id="tab-gallery" class="tab-button text-gray-400 hover:text-white border-b-2 border-transparent px-1 py-3 transition-colors">
                                    Gallery
                                </button>
                            </nav>
                        </div>
                    </div>

                    {{-- Tab Contents --}}
                    <div id="content-chapters" class="tab-content">
                        {{-- Sinopsis --}}
                        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-6">
                            <h2 class="text-xl font-bold text-white mb-3">Sinopsis</h2>
                            <p class="text-gray-300 leading-relaxed">
                                {{ $manga->description ? Str::limit($manga->description, 300, '...') : 'Deskripsi belum tersedia untuk manga ini.' }}
                            </p>
                        </div>

                        {{-- Chapter List --}}
                        <div id="chapters" class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-white">Daftar Chapter</h2>
                                <select id="chapterSort" class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                                    <option value="desc">Terbaru</option>
                                    <option value="asc">Terlama</option>
                                </select>
                            </div>

                            {{-- Search Chapter --}}
                            <div class="mb-4">
                                <input 
                                    type="number" 
                                    id="chapterSearch"
                                    placeholder="Cari chapter..." 
                                    autocomplete="off"    
                                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                                >
                            </div>

                            {{-- No Results Message --}}
                            <div id="noChaptersMessage" class="hidden text-center py-12">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <p class="text-gray-400">Chapter tidak ditemukan</p>
                            </div>

                            {{-- Chapter Items --}}
                            <div id="chapterList" class="space-y-2 max-h-[600px] overflow-y-auto pr-2">
                                @foreach($manga->chapters->sortByDesc('number') as $chapter)
                                    <div class="chapter-item" 
                                         data-number="{{ $chapter->number }}" 
                                         data-title="{{ $chapter->title ?? '' }}"
                                         data-date="{{ $chapter->published_at ? $chapter->published_at->timestamp : $chapter->created_at->timestamp }}">
                                        <a href="{{ route('manga.read', [$manga->slug, $chapter->number]) }}" 
                                           class="block bg-gray-800/50 hover:bg-gray-800 border border-gray-700 hover:border-amber-500 rounded-lg p-4 transition-all group">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <h3 class="text-white font-medium group-hover:text-amber-400 transition-colors">
                                                        Chapter {{ $chapter->number }}
                                                        @if($chapter->title)
                                                            - {{ $chapter->title }}
                                                        @endif
                                                    </h3>
                                                    <p class="text-gray-400 text-sm mt-1">
                                                        {{ $chapter->published_at ? $chapter->published_at->diffForHumans() : $chapter->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span class="text-gray-400 text-sm">{{ $chapter->views ?? 0 }} views</span>
                                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Empty State --}}
                            @if($manga->chapters->isEmpty())
                                <div id="emptyChapters" class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-gray-400">Belum ada chapter yang tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="content-comments" class="tab-content hidden">
                        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Comments</h2>
                            <p class="text-gray-400 text-center py-12">Fitur komentar akan segera hadir</p>
                        </div>
                    </div>

                    <div id="content-details" class="tab-content hidden">
                        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                            <h2 class="text-2xl font-bold text-white mb-6">Detail Manga</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Informasi --}}
                                <div>
                                    <h3 class="text-xl font-bold text-amber-400 mb-4">Informasi</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Judul Alternatif:</p>
                                            <p class="text-white">{{ $manga->alternative_title ?? $manga->title }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Type:</p>
                                            <p class="text-white">{{ $manga->type ?? 'Manga' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Pengarang:</p>
                                            <p class="text-white">{{ $manga->author ?? 'Unknown' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Artis:</p>
                                            <p class="text-white">{{ $manga->artist ?? 'Unknown' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Status:</p>
                                            <p class="text-white">{{ strtoupper($manga->status) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Tahun Terbit:</p>
                                            <p class="text-white">{{ $manga->released_at ?? 'Unknown' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Di Serialisasi Oleh:</p>
                                            <p class="text-white">{{ $manga->serialization ?? 'Unknown' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Statistik --}}
                                <div>
                                    <h3 class="text-xl font-bold text-amber-400 mb-4">Statistik</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Rating:</p>
                                            <p class="text-white">
                                                {{ number_format($manga->rating ?? 0, 1) }} ★ 
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Dilihat:</p>
                                            <p class="text-white">{{ number_format($manga->views) }} kali</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Bookmark:</p>
                                            <p class="text-white">{{ $manga->bookmarks->count() }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Jumlah Chapter:</p>
                                            <p class="text-white">{{ $manga->chapters->count() }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Di Publish Pada:</p>
                                            <p class="text-white">
                                                {{ $manga->created_at ? $manga->created_at->diffForHumans() : 'Unknown' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm mb-1">Update Terakhir:</p>
                                            <p class="text-white">
                                                {{ $manga->last_update ? $manga->last_update->diffForHumans() : ($manga->updated_at ? $manga->updated_at->diffForHumans() : 'Unknown') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Sinopsis Lengkap --}}
                            <div class="mt-8">
                                <h3 class="text-xl font-bold text-amber-400 mb-4">Sinopsis Lengkap</h3>
                                <div class="text-gray-300 leading-relaxed space-y-3">
                                    @if($manga->description)
                                        @foreach(explode("\n", $manga->description) as $paragraph)
                                            @if(trim($paragraph))
                                                <p>{{ $paragraph }}</p>
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-gray-400 italic">Sinopsis belum tersedia untuk manga ini.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Genres --}}
                            @if($manga->genres->count() > 0)
                                <div class="mt-6">
                                    <h3 class="text-xl font-bold text-amber-400 mb-3">Genres:</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($manga->genres as $genre)
                                            <span class="bg-gray-800 hover:bg-amber-500 text-gray-300 hover:text-white text-sm px-3 py-1.5 rounded-lg border border-gray-700 hover:border-amber-500 transition-colors cursor-pointer">
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="content-gallery" class="tab-content hidden">
                        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Gallery</h2>
                            <p class="text-gray-400 text-center py-12">Galeri akan menampilkan preview halaman manga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('text-amber-400', 'border-amber-400');
                button.classList.add('text-gray-400', 'border-transparent');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            activeTab.classList.remove('text-gray-400', 'border-transparent');
            activeTab.classList.add('text-amber-400', 'border-amber-400');
        }

        // Chapter Search and Sort Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const chapterSearch = document.getElementById('chapterSearch');
            const chapterSort = document.getElementById('chapterSort');
            const chapterList = document.getElementById('chapterList');
            const chapterItems = document.querySelectorAll('.chapter-item');
            const noChaptersMessage = document.getElementById('noChaptersMessage');
            const emptyChapters = document.getElementById('emptyChapters');
            
            // Store original chapters for filtering
            let chapters = Array.from(chapterItems);
            
            // Function to filter and sort chapters
            function updateChapterList() {
                const searchTerm = chapterSearch.value.toLowerCase().trim();
                const sortOrder = chapterSort.value;
                
                // Filter chapters
                let filteredChapters = chapters.filter(chapter => {
                    if (searchTerm === '') return true;
                    
                    const number = chapter.getAttribute('data-number');
                    const title = chapter.getAttribute('data-title').toLowerCase();
                    
                    // Search by chapter number
                    if (number.includes(searchTerm)) return true;
                    
                    // Search by chapter title
                    if (title.includes(searchTerm)) return true;
                    
                    return false;
                });
                
                // Sort chapters
                filteredChapters.sort((a, b) => {
                    const aNumber = parseFloat(a.getAttribute('data-number'));
                    const bNumber = parseFloat(b.getAttribute('data-number'));
                    
                    if (sortOrder === 'desc') {
                        return bNumber - aNumber; // Terbaru (descending)
                    } else {
                        return aNumber - bNumber; // Terlama (ascending)
                    }
                });
                
                // Clear current list
                chapterList.innerHTML = '';
                
                // Show/hide empty state
                if (filteredChapters.length === 0) {
                    noChaptersMessage.classList.remove('hidden');
                    if (emptyChapters) emptyChapters.classList.add('hidden');
                } else {
                    noChaptersMessage.classList.add('hidden');
                    if (emptyChapters) emptyChapters.classList.add('hidden');
                    
                    // Add filtered chapters
                    filteredChapters.forEach(chapter => {
                        chapterList.appendChild(chapter.cloneNode(true));
                    });
                }
                
                // Update URL hash if searching by specific chapter number
                if (searchTerm && !isNaN(searchTerm)) {
                    window.location.hash = '#chapters';
                }
            }
            
            // Event listeners
            chapterSearch.addEventListener('input', function() {
                // Debounce the search for better performance
                clearTimeout(this.timer);
                this.timer = setTimeout(() => updateChapterList(), 300);
            });
            
            chapterSort.addEventListener('change', updateChapterList);
            
            // Function to search specific chapter from URL parameter
            function checkUrlForChapterSearch() {
                const urlParams = new URLSearchParams(window.location.search);
                const chapterParam = urlParams.get('chapter');
                
                if (chapterParam) {
                    chapterSearch.value = chapterParam;
                    updateChapterList();
                }
            }
            
            // Check URL on page load
            checkUrlForChapterSearch();
            
            // Initialize the list
            updateChapterList();
            
            // Keyboard shortcut for search (Ctrl/Cmd + F)
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    chapterSearch.focus();
                    chapterSearch.select();
                }
            });
        });
    </script>
    <script>
        const bookmarkBtn = document.getElementById('bookmark-btn');
        const bookmarkText = document.getElementById('bookmark-text');
        const mangaId = parseInt(bookmarkBtn.dataset.mangaId);

        // Update UI berdasarkan status bookmark
        function updateBookmarkUI() {
            if (bookmarkManager.isBookmarked(mangaId)) {
                bookmarkBtn.classList.remove('bg-gray-900', 'bg-gray-800', 'text-white');
                bookmarkBtn.classList.add('bg-amber-500', 'text-black', 'hover:bg-amber-600');
                bookmarkText.textContent = 'Bookmarked';
            } else {
                bookmarkBtn.classList.remove('bg-amber-500', 'text-black', 'hover:bg-amber-600');
                bookmarkBtn.classList.add('bg-gray-900', 'text-white', 'hover:bg-gray-800');
                bookmarkText.textContent = 'Bookmark';
            }
        }

        // Toggle bookmark
        bookmarkBtn.addEventListener('click', function() {
            const isBookmarked = bookmarkManager.toggle(mangaId);
            updateBookmarkUI();
            
            // Show notification
            const message = isBookmarked ? 'Ditambahkan ke bookmark' : 'Dihapus dari bookmark';
            const bgColor = isBookmarked ? 'bg-green-500' : 'bg-red-500';
            showNotification(message);
        });

        // Initialize
        updateBookmarkUI();

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-18 md:bottom-4 left-5 md:left-6 bg-gray-900 text-white text-sm px-5 py-3 rounded-lg shadow-lg z-50 animate-spin';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-layout>