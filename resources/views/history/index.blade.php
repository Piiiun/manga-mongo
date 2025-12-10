<x-layout title="Reading History - MangaMongo">
    <div class="min-h-screen bg-linear-to-b from-gray-950 to-black py-8 px-4">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">Reading History</h1>
                        <p class="text-gray-400">Total {{ $histories->total() }} manga</p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('profile.show') }}" 
                           class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-bold px-6 py-2.5 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>

                        @if($histories->count() > 0)
                            <button onclick="if(confirm('Hapus semua history?')) document.getElementById('clear-history-form').submit()" 
                                    class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-2.5 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Semua
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

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-500/20 border border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- History List --}}
            @if($histories->count() > 0)
                <div class="space-y-4">
                    @foreach($histories as $history)
                        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-amber-500/50 transition-colors">
                            <div class="flex gap-4">
                                {{-- Thumbnail --}}
                                <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                   class="shrink-0">
                                    <img src="{{ asset('storage/manga/' . $history->manga->cover_image) }}" 
                                         alt="{{ $history->manga->title }}"
                                         class="w-20 h-28 object-cover rounded-lg">
                                </a>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('manga.detail', $history->manga->slug) }}" 
                                       class="block">
                                        <h3 class="text-white font-bold text-lg mb-2 hover:text-amber-400 transition-colors line-clamp-1">
                                            {{ $history->manga->title }}
                                        </h3>
                                    </a>

                                    {{-- Genres --}}
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @foreach($history->manga->genres->take(3) as $genre)
                                            <span class="px-2 py-1 bg-amber-500/20 text-amber-400 rounded text-xs">
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                    </div>

                                    {{-- Chapter Info --}}
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm">
                                        <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                           class="inline-flex items-center gap-2 text-amber-400 hover:text-amber-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <span class="font-semibold">Chapter {{ $history->chapter_number }}</span>
                                            @if($history->last_page > 1)
                                                <span class="text-gray-400">(Halaman {{ $history->last_page }})</span>
                                            @endif
                                        </a>
                                        
                                        <span class="text-gray-400">
                                            {{ $history->last_read_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                       class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-lg transition-colors text-center text-sm whitespace-nowrap">
                                        Lanjut Baca
                                    </a>
                                    
                                    <form method="POST" action="{{ route('history.destroy', $history->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Hapus dari history?')"
                                                class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-colors text-sm whitespace-nowrap">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($histories->hasPages())
                    <div class="mt-8">
                        {{ $histories->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-12 text-center">
                    <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-3">Belum Ada History</h2>
                    <p class="text-gray-400 mb-6">Mulai baca manga untuk menyimpan history bacaanmu</p>
                    <a href="{{ route('manga.list') }}" 
                       class="inline-block bg-amber-500 hover:bg-amber-600 text-black font-bold px-8 py-3 rounded-lg transition-colors">
                        Jelajahi Manga
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layout>