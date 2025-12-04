@props(['popularMangas'])

<section class="relative mt-12 mx-2 sm:mx-8">
    {{-- Header dengan Tabs --}}
    <div class="mb-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            {{-- Title --}}
            <h2 class="text-2xl font-extrabold text-white">POPULER</h2>
            
            {{-- Lihat Semua - Desktop --}}
            <a href="#" class="hidden items-center gap-2 text-sm font-semibold text-amber-500 transition-colors hover:text-amber-400 sm:flex">
                <span>Lihat Semua</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        {{-- Tabs Filter --}}
        <div class="mt-4 flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            <button class="flex-shrink-0 rounded-lg bg-amber-500 px-4 py-2 text-sm font-bold text-white transition-all hover:bg-amber-600 sm:px-6">
                Hari Ini
            </button>
            <button class="flex-shrink-0 rounded-lg bg-gray-700/50 px-4 py-2 text-sm font-semibold text-gray-300 transition-all hover:bg-gray-700 hover:text-white sm:px-6">
                Minggu Ini
            </button>
            <button class="flex-shrink-0 rounded-lg bg-gray-700/50 px-4 py-2 text-sm font-semibold text-gray-300 transition-all hover:bg-gray-700 hover:text-white sm:px-6">
                Bulan Ini
            </button>
        </div>

        {{-- Lihat Semua - Mobile --}}
        <a href="#" class="mt-3 flex items-center justify-center gap-2 rounded-lg bg-gray-800/50 py-2.5 text-sm font-semibold text-amber-500 transition-colors hover:bg-gray-800 sm:hidden">
            <span>Lihat Semua</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>

    {{-- List Populer Manga --}}
    <div class="space-y-4">
        @foreach ($popularMangas as $index => $manga)
            <article class="group relative flex items-center gap-4 overflow-hidden rounded-xl bg-gradient-to-r from-gray-800/80 to-gray-900/80 backdrop-blur-sm transition-all duration-300 hover:from-gray-800 hover:to-gray-900 hover:shadow-xl hover:shadow-amber-500/10">
                
                {{-- Background Image Overlay --}}
                <div class="absolute inset-0 opacity-20 transition-opacity group-hover:opacity-30">
                    <img src="{{ asset('storage/' . $manga->cover_image) }}" 
                         alt="{{ $manga->title }}"
                         class="h-full w-full object-cover blur-xs">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/90 to-gray-900/20"></div>
                </div>

                {{-- Nomor Ranking --}}
                <div class="relative z-10 flex h-full items-center">
                    <div class="flex h-20 w-16 items-center justify-center">
                        <span class="text-3xl font-black {{ $index === 0 ? 'text-amber-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'text-gray-500')) }}">
                            {{ $index + 1 }}
                        </span>
                    </div>
                </div>

                {{-- Cover Image --}}
                <div class="relative z-10 h-32 w-24 flex-shrink-0 overflow-hidden rounded-lg shadow-lg">
                    <img src="{{ asset('storage/' . $manga->cover_image) }}" 
                         alt="{{ $manga->title }}"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>

                {{-- Content --}}
                <div class="relative z-10 flex flex-1 flex-col gap-2 py-4 pr-6">
                    {{-- Title dan Badge --}}
                    <div class="flex items-start gap-3">
                        <a href="#" class="group/title flex-1">
                            <h3 class="line-clamp-2 text-base font-bold text-white transition-colors group-hover/title:text-amber-400">
                                {{ $manga->title }}
                            </h3>
                        </a>
                        
                        @if ($manga->is_hot)
                            <span class="rounded bg-gradient-to-r from-red-600 to-red-500 px-2 py-1 text-xs font-bold text-white shadow-lg">
                                HOT
                            </span>
                        @endif
                    </div>

                    {{-- Genres --}}
                    <div class="flex flex-wrap gap-2">
                        @foreach ($manga->genres->take(3) as $genre)
                            <span class="rounded bg-amber-500/20 px-2.5 py-0.5 text-xs font-semibold text-amber-400 ring-1 ring-amber-500/30">
                                {{ $genre->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Stats --}}
                <div class="relative z-10 flex flex-col items-end gap-2 pr-6">
                    {{-- Rating --}}
                    <div class="flex items-center gap-1.5 rounded-full bg-amber-500/20 px-3 py-1.5 ring-1 ring-amber-500/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-bold text-amber-400">{{ number_format($manga->rating ?? 8.5, 1) }}</span>
                    </div>

                    {{-- Views --}}
                    <div class="flex items-center gap-1.5 text-sm text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">{{ number_format($manga->views) }}</span>
                    </div>

                    {{-- Chapters Count --}}
                    <div class="flex items-center gap-1.5 text-sm text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">{{ $manga->chapters_count ?? 0 }}</span>
                    </div>
                </div>

                {{-- Hover Indicator --}}
                <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-amber-500 to-red-500 opacity-0 transition-opacity group-hover:opacity-100"></div>
            </article>
        @endforeach
    </div>
</section>