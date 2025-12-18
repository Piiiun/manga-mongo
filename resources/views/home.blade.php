<x-layout>
    <div class="min-h-screen max-w-[1540px] mx-auto bg-linear-to-b from-card-2 to-transparent">
        <x-hero-slider :featuredMangas="$featuredMangas" />

        @auth
            @if(!empty($lastHistory) && $lastHistory && $lastHistory->manga)
                <div class="px-4 pt-6">
                    <div class="bg-gray-900/80 border border-gray-800 rounded-2xl p-4 md:p-5 flex gap-4 items-center">
                        {{-- Thumbnail --}}
                        <a href="{{ route('manga.read', [$lastHistory->manga->slug, $lastHistory->chapter_number]) }}" class="shrink-0">
                            <img src="{{ asset('storage/manga/' . $lastHistory->manga->cover_image) }}"
                                 alt="{{ $lastHistory->manga->title }}"
                                 class="w-16 h-24 md:w-20 md:h-28 object-cover rounded-lg">
                        </a>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-xs uppercase tracking-wide text-text-second mb-1">
                                Lanjutkan Membaca
                            </p>
                            <a href="{{ route('manga.detail', $lastHistory->manga->slug) }}" class="block">
                                <h2 class="text-white font-bold text-base md:text-lg transition-colors line-clamp-1">
                                    {{ $lastHistory->manga->title }}
                                </h2>
                            </a>

                            <div class="flex flex-wrap items-center gap-2 text-xs md:text-sm mt-2">
                                <a href="{{ route('manga.read', [$lastHistory->manga->slug, $lastHistory->chapter_number]) }}"
                                   class="inline-flex items-center gap-1.5 text-accent hover:text-accent-hover">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span class="font-semibold">
                                        Chapter {{ $lastHistory->chapter_number }}
                                    </span>
                                    @if($lastHistory->last_page > 1)
                                        <span class="text-text-second">
                                            (Halaman {{ $lastHistory->last_page }})
                                        </span>
                                    @endif
                                </a>

                                @if($lastHistory->last_read_at)
                                    <span class="text-text-second">
                                        Terakhir dibaca {{ $lastHistory->last_read_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Action --}}
                        <div class="hidden sm:flex">
                            <a href="{{ route('manga.read', [$lastHistory->manga->slug, $lastHistory->chapter_number]) }}"
                               class="px-4 py-2 bg-accent hover:bg-accent-hover text-text font-bold rounded-lg text-sm whitespace-nowrap transition-colors">
                                Lanjut Baca
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <x-section-home :latestMangas="$latestMangas"/>
        <x-popular-home :popularMangas="$popularMangas" />
    </div>
</x-layout>