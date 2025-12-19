<x-layout title="Reading History - MangaMongo">
    <div class="min-h-screen bg-linear-to-b from-slate-950 to-transparent py-6 sm:py-8 px-3 sm:px-4">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2">Reading History</h1>
                            <p class="text-sm sm:text-base text-gray-400">Total {{ $histories->total() }} manga</p>
                        </div>

                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('profile.show') }}" 
                               class="inline-flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-semibold px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg transition-all hover:scale-105 text-sm sm:text-base flex-1 sm:flex-initial">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>

                            @if($histories->count() > 0)
                                <button onclick="if(confirm('Hapus semua history?')) document.getElementById('clear-history-form').submit()" 
                                        class="inline-flex items-center justify-center gap-2 bg-red-600/90 hover:bg-red-500 text-white font-semibold px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg transition-all hover:scale-105 text-sm sm:text-base flex-1 sm:flex-initial cursor-pointer">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="hidden xs:inline">Hapus Semua</span>
                                    <span class="xs:hidden">Hapus</span>
                                </button>

                                <form id="clear-history-form" 
                                      method="POST" 
                                      action="{{ route('history.clear') }}" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-green-400 px-4 sm:px-6 py-3 sm:py-4 rounded-lg mb-4 sm:mb-6 backdrop-blur-sm animate-fade-in">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm sm:text-base">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- History List --}}
            @if($histories->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($histories as $history)
                        <div class="bg-gray-900/50 border border-gray-800 rounded-lg sm:rounded-xl p-3 sm:p-4 hover:border-amber-500/50 hover:bg-gray-900/70 transition-all duration-300 group">
                            <div class="flex gap-3 sm:gap-4">
                                {{-- Thumbnail --}}
                                <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                   class="shrink-0 relative overflow-hidden rounded-lg group/thumb">
                                    <img src="{{ asset('storage/manga/' . $history->manga->cover_image) }}" 
                                         alt="{{ $history->manga->title }}"
                                         class="w-16 h-24 sm:w-20 sm:h-28 object-cover transition-transform duration-300 group-hover/thumb:scale-110">
                                    <div class="absolute inset-0 bg-black/0 group-hover/thumb:bg-black/30 transition-colors flex items-center justify-center">
                                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white opacity-0 group-hover/thumb:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </a>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0 flex flex-col justify-between">
                                    <div>
                                        <a href="{{ route('manga.detail', $history->manga->slug) }}" 
                                           class="block group/title">
                                            <h3 class="text-white font-bold text-sm sm:text-base lg:text-lg mb-1.5 sm:mb-2 group-hover/title:text-amber-400 transition-colors line-clamp-2 sm:line-clamp-1">
                                                {{ $history->manga->title }}
                                            </h3>
                                        </a>

                                        {{-- Genres - Hide on very small screens --}}
                                        <div class="hidden xs:flex flex-wrap gap-1.5 sm:gap-2 mb-2 sm:mb-3">
                                            @foreach($history->manga->genres->take(3) as $genre)
                                                <span class="px-2 py-0.5 sm:py-1 bg-amber-500/20 text-amber-400 rounded text-xs font-medium">
                                                    {{ $genre->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Chapter Info --}}
                                    <div class="flex flex-col gap-1.5 sm:gap-2">
                                        <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                           class="inline-flex items-center gap-1.5 sm:gap-2 text-amber-400 hover:text-amber-300 transition-colors text-xs sm:text-sm">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <span class="font-semibold">Ch {{ $history->chapter_number }}</span>
                                            @if($history->last_page > 1)
                                                <span class="text-gray-500 hidden sm:inline">(Hal {{ $history->last_page }})</span>
                                            @endif
                                        </a>
                                        
                                        <div class="flex items-center gap-1.5 text-gray-500 text-xs sm:text-sm">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $history->last_read_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions - Desktop --}}
                                <div class="hidden sm:flex flex-col gap-2 ml-2">
                                    <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                       class="px-4 lg:px-5 py-2 bg-amber-500 hover:bg-amber-400 text-black font-bold rounded-lg transition-all hover:scale-105 text-center text-sm whitespace-nowrap shadow-lg shadow-amber-500/20">
                                        Lanjut Baca
                                    </a>
                                    
                                    <form method="POST" action="{{ route('history.destroy', $history->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Hapus dari history?')"
                                                class="w-full px-4 lg:px-5 py-2 bg-red-600/90 hover:bg-red-500 text-white font-bold rounded-lg transition-all hover:scale-105 text-sm whitespace-nowrap cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Actions - Mobile --}}
                            <div class="sm:hidden flex gap-2 mt-3 pt-3 border-t border-gray-800">
                                <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                   class="flex-1 px-4 py-2 bg-amber-500 hover:bg-amber-400 text-black font-bold rounded-lg transition-all text-center text-sm shadow-lg shadow-amber-500/20">
                                    Lanjut Baca
                                </a>
                                
                                <form method="POST" action="{{ route('history.destroy', $history->id) }}" class="flex-shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Hapus dari history?')"
                                            class="px-4 py-2 bg-red-500/90 hover:bg-red-600 text-white font-bold rounded-lg transition-all text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($histories->hasPages())
                    <div class="mt-6 sm:mt-8">
                        {{ $histories->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="bg-gray-900/50 border border-gray-800 rounded-xl sm:rounded-2xl p-8 sm:p-12 text-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-2 sm:mb-3">Belum Ada History</h2>
                    <p class="text-gray-400 mb-4 sm:mb-6 text-sm sm:text-base">Mulai baca manga untuk menyimpan history bacaanmu</p>
                    <a href="{{ route('manga.list') }}" 
                       class="inline-block bg-amber-500 hover:bg-amber-400 text-black font-bold px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg transition-all hover:scale-105 text-sm sm:text-base shadow-lg shadow-amber-500/20">
                        Jelajahi Manga
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Custom breakpoint for very small screens */
        @media (min-width: 475px) {
            .xs\:inline {
                display: inline;
            }
            .xs\:hidden {
                display: none;
            }
            .xs\:flex {
                display: flex;
            }
        }
    </style>
</x-layout>