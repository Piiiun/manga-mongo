<x-layout
    :title="$manga->title . ' - Baca di MangaMongo'"
    :description="Str::limit($manga->description, 150)"
>
    <div class="min-h-screen bg-linear-to-b from-slate-950 to-transparent">
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
                            <button type="button"
                                    data-manga-id="{{ $manga->id }}"
                                    class="bookmark-toggle bg-gray-900 hover:bg-amber-500 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors">
                                <svg class="bookmark-icon-filled hidden w-5 h-5" fill="#f59e0b" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                </svg>
                                <svg class="bookmark-icon-outline w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                </svg>
                                <span class="bookmark-text text-sm font-medium">Bookmark</span>
                            </button>
                            @auth
                               <button onclick="openRatingModal()" 
                                        class="bg-gray-900 hover:bg-gray-800 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors {{ $manga->isRatedBy(Auth::user()) ? 'border-amber-500' : '' }}">
                                    <svg class="w-5 h-5 {{ $manga->isRatedBy(Auth::user()) ? 'text-amber-400 fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ $manga->isRatedBy(Auth::user()) ? 'Update Rating' : 'Rate' }}
                                    </span>
                                </button>
                            @else
                                <button onclick="showRatingLoginModal()" 
                                        class="bg-gray-900 hover:bg-gray-800 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Rate</span>
                                </button>
                            @endauth    
                        </div>

                        <button
                            type="button"
                            id="share-button"
                            class="share-button w-full bg-gray-900 hover:bg-gray-800 border border-gray-800 text-white rounded-xl px-4 py-3 flex items-center justify-center gap-2 transition-colors mb-4 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-gray-950 disabled:opacity-50 disabled:cursor-not-allowed"
                            aria-label="Share {{ $manga->title }}"
                            data-manga-title="{{ $manga->title }}"
                            data-manga-url="{{ route('manga.detail', $manga->slug) }}"
                        >
                            <x-icons.share class="share-icon" />
                            <span class="text-sm font-medium">Share</span>
                        </button>

                        @if($manga->chapters->count() > 0)
                            <a href="{{ route('manga.read', [$manga->slug, $manga->chapters->first()->number]) }}" 
                               class="flex items-center justify-center gap-2 w-full bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-xl px-4 py-3 text-center transition-colors">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023"/>
                                </svg>
                                <span class="text-sm font-semibold">Baca Dari Awal</span>
                            </a>
                        @else
                            <div class="flex items-center justify-center gap-2 w-full bg-gray-800 text-gray-500 font-bold rounded-xl px-4 py-3 text-center cursor-not-allowed">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023"/>
                                </svg>
                                <span class="text-sm font-semibold">Belum Ada Chapter</span>
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
                                <a class="mb-2 sm:mb-0" href="{{ route('manga.list', ['genre' => $genre->slug]) }}">
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
                                <p class="text-2xl font-bold text-white">{{ $manga->formatted_views }}</p>
                                <p class="text-gray-400 text-sm mt-1">Views</p>
                            </div>
                            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 text-center">
                                <p class="text-2xl font-bold text-white">{{ $manga->bookmarks->count() }}</p>
                                <p class="text-gray-400 text-sm mt-1">Bookmark</p>
                            </div>
                            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 text-center cursor-pointer hover:border-amber-500 transition-colors"
                                onclick="showRatings()">
                                <div class="flex items-center justify-center gap-1">
                                    <p class="text-2xl font-bold text-white">{{ $manga->average_rating ?? 0 }}</p>
                                    <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 text-sm mt-1">{{ $manga->total_ratings }} rating by users</p>
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
                            <p class="text-gray-300 leading-relaxed line-clamp-3">
                                {{ $manga->description ?? 'Deskripsi belum tersedia untuk manga ini.' }}
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
                           <div class="sm:flex items-center justify-between mb-2 sm:mb-6">
                                <h2 class="text-xl font-bold text-white">
                                    Comment
                                </h2>
                                <span class="text-xs sm:text-sm font-normal text-gray-400">({{ $manga->comments()->topLevel()->count() }} komentar)</span>
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
                                <form method="POST" action="{{ route('comments.store.manga', $manga) }}" class="mb-8">
                                    @csrf
                                    
                                    <textarea name="content" 
                                            rows="4" 
                                            required
                                            placeholder="Tulis komentar kamu tentang manga ini..."
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-amber-500 resize-none"></textarea>
                                    
                                    <div class="flex items-center justify-between mt-3">
                                        <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                                            <input type="checkbox" name="is_spoiler" value="1" class="rounded border-gray-600 text-amber-500 focus:ring-amber-500">
                                            Tandai sebagai spoiler
                                        </label>
                                        
                                        <button type="submit"
                                            class="px-4 py-2 text-sm sm:px-6 sm:py-2.5 sm:text-base
                                                bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-2xl sm:rounded-lg transition-colors">
                                            <span class="hidden sm:block">Kirim Komentar</span>
                                            <svg class="sm:hidden w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                                <path d="M11.5003 12H5.41872M5.24634 12.7972L4.24158 15.7986C3.69128 17.4424 3.41613 18.2643 3.61359 18.7704C3.78506 19.21 4.15335 19.5432 4.6078 19.6701C5.13111 19.8161 5.92151 19.4604 7.50231 18.7491L17.6367 14.1886C19.1797 13.4942 19.9512 13.1471 20.1896 12.6648C20.3968 12.2458 20.3968 11.7541 20.1896 11.3351C19.9512 10.8529 19.1797 10.5057 17.6367 9.81135L7.48483 5.24303C5.90879 4.53382 5.12078 4.17921 4.59799 4.32468C4.14397 4.45101 3.77572 4.78336 3.60365 5.22209C3.40551 5.72728 3.67772 6.54741 4.22215 8.18767L5.24829 11.2793C5.34179 11.561 5.38855 11.7019 5.407 11.8459C5.42338 11.9738 5.42321 12.1032 5.40651 12.231C5.38768 12.375 5.34057 12.5157 5.24634 12.7972Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-6 text-center mb-8">
                                    <p class="text-gray-400 mb-4">Login untuk berkomentar</p>
                                    <a href="{{ route('login') }}" 
                                    class="inline-block bg-amber-500 hover:bg-amber-600 text-black font-bold px-6 py-2.5 rounded-lg transition-colors">
                                        Login
                                    </a>
                                </div>
                            @endauth

                            {{-- Comments List --}}
                            @php
                                $comments = $manga->comments()
                                    ->topLevel()
                                    ->with(['user', 'replies.user', 'replies.replies.user'])
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            @endphp

                            @if($comments->count() > 0)
                                <div class="space-y-4">
                                    @foreach($comments as $comment)
                                        <x-comment-item :comment="$comment" />
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p class="text-gray-400">Belum ada komentar. Jadilah yang pertama!</p>
                                </div>
                            @endif
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
                                            <a class="" href="{{ route('manga.list', ['genre' => $genre->slug]) }}">
                                                <span class="bg-gray-800 hover:bg-amber-500 text-gray-300 hover:text-white text-sm px-3 py-1.5 rounded-lg border border-gray-700 hover:border-amber-500 transition-colors cursor-pointer">
                                                    {{ $genre->name }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="content-gallery" class="tab-content hidden">
                        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-white">Gallery</h2>
                                
                                @auth
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.gallery.create', $manga) }}" 
                                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-black font-bold px-4 py-2 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span class="hidden sm:block">Upload Gambar</span>
                                        </a>
                                    @endif
                                @endauth
                            </div>

                            @if($manga->galleries->count() > 0)
                                {{-- Gallery Grid with Lightbox --}}
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($manga->galleries as $index => $gallery)
                                        <div class="group relative aspect-3/4 rounded-lg overflow-hidden bg-gray-800 cursor-pointer"
                                            onclick="openLightbox({{ $index }})">
                                            <img src="{{ $gallery->image_url }}" 
                                                alt="{{ $gallery->title ?? 'Gallery Image' }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            
                                            {{-- Overlay --}}
                                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                                </svg>
                                            </div>

                                            {{-- Type Badge --}}
                                            <div class="absolute top-2 left-2">
                                                <span class="bg-amber-500 text-black text-xs font-bold px-2 py-1 rounded">
                                                    {{ ucfirst($gallery->type) }}
                                                </span>
                                            </div>

                                            {{-- Admin Actions --}}
                                            @auth
                                                @if(Auth::user()->isAdmin())
                                                    <div class="absolute top-2 right-2 flex gap-1">
                                                        <button onclick="event.stopPropagation(); editGallery({{ $gallery->id }})"
                                                                class="p-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.gallery.destroy', $gallery) }}" class="inline"
                                                            onsubmit="event.stopPropagation(); return confirm('Hapus gambar ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="p-1.5 bg-red-500 hover:bg-red-600 text-white rounded transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Lightbox Modal --}}
                                <div id="lightbox" class="hidden fixed inset-0 bg-black/80
                                 z-50 flex items-center justify-center p-4">
                                    <button onclick="closeLightbox()" 
                                            class="absolute top-4 right-4 text-white hover:text-amber-400 transition-colors z-10">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>

                                    <button onclick="previousImage()" 
                                            class="absolute left-4 text-white hover:text-amber-400 transition-colors">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>

                                    <div class="max-w-6xl max-h-full flex flex-col items-center ">
                                        <img id="lightbox-image" 
                                            src="" 
                                            alt="" 
                                            class="max-w-full max-h-[80vh] object-contain">
                                        
                                        <div id="lightbox-info" class="mt-4 text-center text-white">
                                            <h3 id="lightbox-title" class="text-xl font-bold mb-2"></h3>
                                            <p id="lightbox-description" class="text-gray-400"></p>
                                            <p id="lightbox-counter" class="text-sm text-gray-500 mt-2"></p>
                                        </div>
                                    </div>

                                    <button onclick="nextImage()" 
                                            class="absolute right-4 text-white hover:text-amber-400 transition-colors">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>

                            @else
                                <div class="text-center py-12">
                                    <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-400 text-lg mb-4">Belum ada gambar di gallery</p>
                                    
                                    @auth
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('admin.gallery.create', $manga) }}" 
                                            class="inline-block bg-amber-500 hover:bg-amber-600 text-black font-bold px-6 py-3 rounded-lg transition-colors">
                                                Upload Gambar Pertama
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
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
                button.classList.remove('text-amber-400', 'border-amber-400', 'font-bold', 'hover:text-amber-400');
                button.classList.add('text-gray-400', 'border-transparent', 'font-normal', 'hover:text-white');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            activeTab.classList.remove('text-gray-400', 'border-transparent', 'font-normal', 'hover:text-white');
            activeTab.classList.add('text-amber-400', 'border-amber-400', 'font-bold', 'hover:text-amber-400');
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
        @php
            $galleriesData = $manga->galleries->map(function($g) {
                return [
                    'url' => $g->image_url,
                    'title' => $g->title,
                    'description' => $g->description,
                    'type' => $g->type
                ];
            });
        @endphp
        const galleries = @json($galleriesData);

        let currentImageIndex = 0;

        function openLightbox(index) {
            currentImageIndex = index;
            updateLightbox();
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + galleries.length) % galleries.length;
            updateLightbox();
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleries.length;
            updateLightbox();
        }

        function updateLightbox() {
            const gallery = galleries[currentImageIndex];
            document.getElementById('lightbox-image').src = gallery.url;
            document.getElementById('lightbox-title').textContent = gallery.title || 'Untitled';
            document.getElementById('lightbox-description').textContent = gallery.description || '';
            document.getElementById('lightbox-counter').textContent = `${currentImageIndex + 1} / ${galleries.length}`;
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const lightbox = document.getElementById('lightbox');
            if (!lightbox.classList.contains('hidden')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') previousImage();
                if (e.key === 'ArrowRight') nextImage();
            }
        });

        // Close on click outside
        document.getElementById('lightbox')?.addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });

        // Show rating login modal for guest users
        function showRatingLoginModal() {
            if (window.showLoginModal) {
                window.showLoginModal('rating-login-modal');
            }
        }
    </script>
    <x-share-modal :manga="$manga"/>
    <x-modal-rating :manga="$manga" />
    <x-modal-user-rating :manga="$manga" />
    <x-login-modal 
        id="rating-login-modal"
        title="Login untuk Memberikan Rating"
        :icon="'<svg class=\'w-8 h-8 text-amber-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z\'/></svg>'"
        description="Berikan rating untuk manga ini dan bantu pembaca lain menemukan manga berkualitas. Login untuk mengakses fitur rating."
        loginRoute="login"
        />
    </x-layout>