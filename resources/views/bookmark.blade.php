<x-layout
    title="Bookmark - MangaMongo"
    description="Baca manga dan komik terbaru dengan kualitas terbaik di MangaMongo. Update setiap hari."
> 
    <div class="min-h-screen">
        {{-- Header --}}
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            {{-- Back Button --}}
            <a href="{{ route('home') }}" class="inline-flex items-center text-amber-600 dark:text-amber-400 hover:text-amber-500 hover:dark:text-amber-300 mb-6 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            {{-- Title --}}
            <div class="md:flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-xl md:text-4xl font-bold text-black dark:text-white mb-2 flex items-center gap-3">
                        <svg class="w-10 h-10 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"></path>
                        </svg>
                        Bookmark Manga
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        <span id="bookmark-count">0</span> manga
                    </p>
                </div>

                {{-- Display Toggle --}}
                <div class="flex items-center justify-end gap-2">
                    <span class="text-gray-600 dark:text-gray-400 text-sm mr-2">Tampilan:</span>
                    <button id="grid-view-btn" class="p-2 bg-amber-500 text-black rounded-lg transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button id="list-view-btn" class="p-2 bg-slate-300 dark:bg-gray-900 text-gray-600 dark:text-gray-400 rounded-lg transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Loading State --}}
            <div id="loading-state" class="text-center py-20">
                <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-amber-400 mx-auto mb-4"></div>
                <p class="text-gray-600 dark:text-gray-400">Memuat bookmark...</p>
            </div>

            {{-- Empty State --}}
            <div id="empty-state" class="hidden">
                <div class="bg-slate-300/50 dark:bg-gray-900/50 rounded-2xl p-12 text-center max-w-md mx-auto border border-gray-800">
                    <div class="w-24 h-24 bg-slate-400 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-black dark:text-white mb-3">Bookmark Kosong</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Kamu belum menambahkan manga ke bookmark</p>
                    <a href="{{ route('manga.list') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-black font-semibold px-6 py-3 rounded-xl transition-colors">
                        Jelajahi Manga
                    </a>
                </div>
            </div>

            {{-- Manga Grid --}}
            <div id="manga-grid" class="grid md:gap-5 gap-2.5 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                {{-- Will be populated by JavaScript --}}
            </div>

            {{-- Manga List --}}
            <div id="manga-list" class="hidden space-y-4">
                {{-- Will be populated by JavaScript --}}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingState = document.getElementById('loading-state');
            const emptyState = document.getElementById('empty-state');
            const mangaGrid = document.getElementById('manga-grid');
            const mangaList = document.getElementById('manga-list');
            const bookmarkCount = document.getElementById('bookmark-count');
            const gridViewBtn = document.getElementById('grid-view-btn');
            const listViewBtn = document.getElementById('list-view-btn');
            
            let currentView = 'grid'; // default view

            const isLoggedIn = Boolean(window.authUser);

            // Load bookmarks
            loadBookmarks();

            // View toggle
            gridViewBtn.addEventListener('click', function() {
                currentView = 'grid';
                mangaList.classList.add('hidden');
                mangaGrid.classList.remove('hidden');
                gridViewBtn.classList.add('bg-amber-500', 'text-black');
                gridViewBtn.classList.remove('dark:bg-gray-900', 'bg-slate-300', 'text-gray-600', 'dark:text-gray-400');
                listViewBtn.classList.remove('bg-amber-500', 'text-black');
                listViewBtn.classList.add('bg-slate-300', 'dark:bg-gray-900', 'text-gray-600', 'dark:text-gray-400');
            });
            listViewBtn.addEventListener('click', function() {
                currentView = 'list';
                mangaGrid.classList.add('hidden');
                mangaList.classList.remove('hidden');
                listViewBtn.classList.add('bg-amber-500', 'text-black');
                listViewBtn.classList.remove('dark:bg-gray-900', 'bg-slate-300', 'text-gray-600', 'dark:text-gray-400');
                gridViewBtn.classList.remove('bg-amber-500', 'text-black');
                gridViewBtn.classList.add('bg-slate-300', 'dark:bg-gray-900', 'text-gray-600', 'dark:text-gray-400');
            });

            async function loadBookmarks() {
                let bookmarkIds = [];
                try {
                    bookmarkIds = isLoggedIn
                        ? await window.fetchUserBookmarks()
                        : window.bookmarkLocal.getBookmarkIds();
                } catch (error) {
                    console.error('Gagal mengambil bookmark', error);
                }

                bookmarkCount.textContent = bookmarkIds.length;

                if (bookmarkIds.length === 0) {
                    loadingState.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    return;
                }

                try {
                    const response = await fetch("{{ route('bookmark.get-mangas') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: bookmarkIds })
                    });

                    const data = await response.json();
                    
                    loadingState.classList.add('hidden');
                    
                    if (data.mangas.length === 0) {
                        emptyState.classList.remove('hidden');
                    } else {
                        renderMangas(data.mangas);
                        mangaGrid.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Error loading bookmarks:', error);
                    loadingState.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                }
            }

            function renderMangas(mangas) {
                // Render Grid View
                mangaGrid.innerHTML = mangas.map(manga => `
                    <div class="group relative">
                        <a href="/manga/${manga.slug}" class="block">
                            <div class="relative aspect-[2/3] rounded-xl overflow-hidden mb-3 bg-gray-800">
                                <img src="${manga.cover_image}" 
                                     alt="${manga.title}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-white/40 dark:from-black/80 via-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <h3 class="text-black dark:text-white font-semibold text-sm line-clamp-2 mb-1">${manga.title}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-xs">${manga.author || 'Unknown'}</p>
                        </a>
                        <button onclick="removeBookmark(${manga.id})" 
                                class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg transition-colors z-10">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                            </svg>
                        </button>
                    </div>
                `).join('');

                // Render List View
                mangaList.innerHTML = mangas.map(manga => `
                    <div class="bg-slate-200 dark:bg-gray-900/50 border border-gray-800 rounded-xl p-4 flex gap-4 hover:border-amber-500 hover:dark:border-amber-500/50 transition-colors shadow-md shadow-black/20">
                        <a href="/manga/${manga.slug}" class="flex-shrink-0">
                            <img src="${manga.cover_image}" 
                                 alt="${manga.title}"
                                 class="w-20 h-28 object-cover rounded-lg">
                        </a>
                        <div class="flex-1">
                            <a href="/manga/${manga.slug}">
                                <h3 class="text-black dark:text-white font-bold text-lg mb-2 hover:text-amber-400 transition-colors">${manga.title}</h3>
                            </a>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">${manga.author || 'Unknown'}</p>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="flex items-center gap-1 text-amber-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                    </svg>
                                    ${manga.rating || 'N/A'}
                                </span>
                                <span class="text-xs font-medium px-2 py-1 rounded
                                ${manga.status === 'Ongoing'
                                    ? 'bg-green-900/80 text-green-400 border-green-800/50'
                                    : 'bg-blue-700/70 text-blue-300 border-gray-700/50'
                                }">
                                ${manga.status || 'Ongoing'}
                                </span>
                            </div>
                        </div>
                        <button onclick="removeBookmark(${manga.id})" 
                                class="flex-shrink-0 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors h-fit">
                            <svg class="w-4 h-4 sm:hidden" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                            </svg>
                            <span class="hidden sm:block">Hapus</span>
                        </button>
                    </div>
                `).join('');
            }

            // Global function untuk remove bookmark
            window.removeBookmark = async function(mangaId) {
                if (!confirm('Hapus manga dari bookmark?')) return;

                try {
                    if (isLoggedIn) {
                        await window.toggleUserBookmark(mangaId);
                    } else {
                        window.bookmarkLocal.removeBookmark(mangaId);
                    }
                } catch (error) {
                    console.error('Gagal menghapus bookmark', error);
                }

                loadBookmarks();
            };
        });
    </script>
</x-layout>