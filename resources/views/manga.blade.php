<x-layout
    title="Daftar Manga - MangaMongo"
    description="Baca manga dan komik terbaru dengan kualitas terbaik di MangaMongo. Update setiap hari."
> 
    <div class="min-h-screen bg-linear-to-b from-card-2 to-transparent">
        {{-- Navigation Top --}}
        {{-- Breadcrumb --}}
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-text-second">
                <a href="{{ route('home') }}" class="hover:text-accent-hover transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Manga</span>
                @if(request('genre'))
                    <span>/</span>
                    <span class="text-accent-hover">{{ ucfirst(request('genre')) }}</span>
                @endif
            </nav>
        </div>
        
        {{-- Header --}}
        <div class="px-4 sm:px-6 lg:px-8 py-6 pt-2">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">
                    Daftar Manga
                    @if(request('genre'))
                        <span class="text-accent-hover">- {{ ucfirst(request('genre')) }}</span>
                    @endif
                </h1>
                <p class="text-text-second">Temukan manga favoritmu</p>
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
                            class="w-full bg-gray-900/70 border border-gray-800 rounded-xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-transparent"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-text-second hover:text-accent-hover">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Sort & Filter --}}
                    <div class="flex gap-3">
                        {{-- Sorting Dropdown --}}
                        <select name="sort" 
                                class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent/50 text-sm"
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
                                Rating
                            </option>
                        </select>

                        {{-- Filter Button (untuk modal/more filters) --}}
                        <button type="button" 
                                onclick="openFilterModal()"
                                class="hidden lg:flex bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-3 hover:bg-gray-800/70 transition-colors text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter
                        </button>

                        <button type="button" 
                                onclick="openFilterModal()"
                                class="lg:hidden px-4 py-3 bg-gray-900/70 border border-gray-800 text-white rounded-xl hover:bg-gray-800/70 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
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
                        <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    
                    <select name="type" class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-2 text-sm">
                        <option value="">Semua Tipe</option>
                        <option value="manga" {{ request('type') == 'manga' ? 'selected' : '' }}>Manga</option>
                        <option value="manhwa" {{ request('type') == 'manhwa' ? 'selected' : '' }}>Manhwa</option>
                        <option value="manhua" {{ request('type') == 'manhua' ? 'selected' : '' }}>Manhua</option>
                    </select>

                    {{-- Genre Filter --}}
                    <select name="genre" class="bg-gray-900/70 border border-gray-800 text-white rounded-xl px-4 py-2 text-sm">
                        <option value="">Semua Genre</option>
                        @foreach($genres as $genreItem)
                            <option value="{{ $genreItem->slug }}" {{ request('genre') == $genreItem->slug ? 'selected' : '' }}>
                                {{ $genreItem->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="bg-accent hover:bg-accent-hover text-white rounded-xl px-4 py-2 text-sm">
                        Terapkan Filter
                    </button>
                </div>
            </form>

            {{-- Active Filters Display --}}
            @if(request('genre') || request('status') || request('type') || request('search'))
                <div class="mb-6 flex flex-wrap items-center gap-2">
                    <span class="text-text-second text-sm">Filter Aktif:</span>
                    
                    @if(request('genre'))
                        <span class="bg-accent/20 text-accent-hover px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            Genre: {{ ucfirst(request('genre')) }}
                            <a href="{{ route('manga.list', array_merge(request()->except('genre'), request()->only(['search', 'sort', 'status', 'type']))) }}" 
                               class="hover:text-white">×</a>
                        </span>
                    @endif

                    @if(request('status'))
                        <span class="bg-accent/20 text-accent-hover px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            Status: {{ request('status') }}
                            <a href="{{ route('manga.list', array_merge(request()->except('status'), request()->only(['search', 'sort', 'genre', 'type']))) }}" 
                               class="hover:text-white">×</a>
                        </span>
                    @endif

                    @if(request('type'))
                        <span class="bg-accent/20 text-accent-hover px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            Tipe: {{ ucfirst(request('type')) }}
                            <a href="{{ route('manga.list', array_merge(request()->except('type'), request()->only(['search', 'sort', 'genre', 'status']))) }}" 
                               class="hover:text-white">×</a>
                        </span>
                    @endif

                    @if(request('search'))
                        <span class="bg-accent/20 text-accent-hover px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            Pencarian: "{{ request('search') }}"
                            <a href="{{ route('manga.list', array_merge(request()->except('search'), request()->only(['sort', 'genre', 'status', 'type']))) }}" 
                               class="hover:text-white">×</a>
                        </span>
                    @endif
                </div>
            @endif

            {{-- Grid Manga --}}
            <div class="grid md:gap-5 gap-2.5 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @forelse($mangas as $manga)
                    <a href="{{ route('manga.detail', $manga->slug) }}" class="block group">
                        <x-manga-card-list :manga="$manga" />
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-text-second text-lg">Tidak ada manga ditemukan</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination dengan menjaga query parameters --}}
            @if($mangas->hasPages())
                <div class="mt-10 flex justify-center">
                    <nav class="flex items-center gap-1">
                        {{-- Previous Button --}}
                        @if($mangas->onFirstPage())
                            <span class="px-3 py-2 bg-gray-900/50 text-gray-600 rounded-lg cursor-not-allowed text-sm">
                                &lt;
                            </span>
                        @else
                            <a href="{{ $mangas->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 bg-gray-900 hover:bg-accent text-white rounded-lg transition-colors text-sm">
                                &lt;
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach(range(1, min(5, $mangas->lastPage())) as $page)
                            @if($page == $mangas->currentPage())
                                <span class="px-4 py-2 bg-accent text-black font-bold rounded-lg text-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $mangas->appends(request()->query())->url($page) }}" class="px-4 py-2 bg-gray-900 hover:bg-accent text-white rounded-lg transition-colors text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if($mangas->hasMorePages())
                            <a href="{{ $mangas->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 bg-gray-900 hover:bg-accent text-white rounded-lg transition-colors text-sm">
                                &gt;
                            </a>
                        @else
                            <span class=" px-3 py-2 bg-gray-900/50 text-gray-600 rounded-lg cursor-not-allowed text-sm">
                                &gt;
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