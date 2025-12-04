<x-layout title="Daftar Manga">
    <div class="min-h-screen bg-gradient-to-b from-gray-950 to-black">
        {{-- Header --}}
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Daftar Manga</h1>
                <p class="text-gray-400">Temukan manga favoritmu</p>
            </div>

            {{-- FORM UNTUK SORTING DAN FILTER --}}
            <form method="GET" action="{{ route('manga.list') }}" class="mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Search Bar --}}
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari manga..." 
                            value="{{ request('search') }}"
                            class="w-full bg-gray-900/70 border border-gray-800 rounded-xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-transparent"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Sort & Filter --}}
                    <div class="flex gap-3">
                        {{-- Sorting Dropdown --}}
                        <select name="sort" 
                                class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500/50 text-sm"
                                onchange="this.form.submit()">
                            <option value="a-z" {{ request('sort', 'a-z') == 'a-z' ? 'selected' : '' }} class="bg-gray-900">
                                A-Z
                            </option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }} class="bg-gray-900">
                                Terbaru
                            </option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }} class="bg-gray-900">
                                Populer
                            </option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }} class="bg-gray-900">
                                Rating Tertinggi
                            </option>
                        </select>

                        {{-- Filter Button (untuk modal/more filters) --}}
                        <button type="button" 
                                onclick="openFilterModal()"
                                class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-3 hover:bg-gray-800/70 transition-colors text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter
                        </button>

                        {{-- Reset Button --}}
                        <a href="{{ route('manga.list') }}" 
                           class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-3 hover:bg-gray-800/70 transition-colors text-sm flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </div>

                {{-- Additional Filters (bisa disimpan di modal) --}}
                <div class="mt-4 flex flex-wrap gap-3" id="extraFilters" style="display: none;">
                    <select name="status" class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-2 text-sm">
                        <option value="">Semua Status</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    
                    <select name="type" class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-2 text-sm">
                        <option value="">Semua Tipe</option>
                        <option value="manga" {{ request('type') == 'manga' ? 'selected' : '' }}>Manga</option>
                        <option value="manhwa" {{ request('type') == 'manhwa' ? 'selected' : '' }}>Manhwa</option>
                        <option value="manhua" {{ request('type') == 'manhua' ? 'selected' : '' }}>Manhua</option>
                    </select>
                    
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white rounded-xl px-4 py-2 text-sm">
                        Terapkan Filter
                    </button>
                </div>
            </form>

            {{-- Grid Manga --}}
            <div class="grid gap-5 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6">
                @foreach($mangas as $manga)
                    <a href="{{ route('manga.detail', $manga->slug) }}" class="block group">
                        <x-manga-card-list :manga="$manga" />
                    </a>
                @endforeach
            </div>

            {{-- Pagination dengan menjaga query parameters --}}
            @if($mangas->hasPages())
                <div class="mt-10 flex justify-center">
                    <nav class="flex items-center gap-1">
                        {{-- Previous Button --}}
                        @if($mangas->onFirstPage())
                            <span class="px-3 py-2 bg-gray-900/50 text-gray-600 rounded-lg cursor-not-allowed text-sm">
                                ←
                            </span>
                        @else
                            <a href="{{ $mangas->previousPageUrl() . $queryString }}" class="px-3 py-2 bg-gray-900 hover:bg-amber-500 text-white rounded-lg transition-colors text-sm">
                                ←
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach(range(1, min(5, $mangas->lastPage())) as $page)
                            @if($page == $mangas->currentPage())
                                <span class="px-4 py-2 bg-amber-500 text-black font-bold rounded-lg text-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $mangas->url($page) . $queryString }}" class="px-4 py-2 bg-gray-900 hover:bg-amber-500 text-white rounded-lg transition-colors text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if($mangas->hasMorePages())
                            <a href="{{ $mangas->nextPageUrl() . $queryString }}" class="px-3 py-2 bg-gray-900 hover:bg-amber-500 text-white rounded-lg transition-colors text-sm">
                                →
                            </a>
                        @else
                            <span class="px-3 py-2 bg-gray-900/50 text-gray-600 rounded-lg cursor-not-allowed text-sm">
                                →
                            </span>
                        @endif
                    </nav>
                </div>
            @endif
        </div>
    </div>

    {{-- JavaScript untuk filter modal --}}
    <script>
        function openFilterModal() {
            const extraFilters = document.getElementById('extraFilters');
            if (extraFilters.style.display === 'none' || extraFilters.style.display === '') {
                extraFilters.style.display = 'flex';
            } else {
                extraFilters.style.display = 'none';
            }
        }
    </script>
</x-layout>