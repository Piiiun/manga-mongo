<div class="relative">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">

            @foreach ($featuredMangas as $manga)
                <div class="swiper-slide">
                    <div class="relative overflow-hidden rounded-3xl bg-[#111827]/90 p-5 sm:p-8 lg:p-10 flex flex-col lg:flex-row gap-6 lg:gap-10 mx-2 md:mx-8">

                        {{-- background blur besar (opsional) --}}
                        <div class="pointer-events-none absolute inset-0 opacity-60">
                            <img src="{{ asset('storage/manga/' . $manga->cover_image) }}" alt="" class="grayscale-50 w-full h-full object-cover blur-xl scale-110">
                        </div>

                        {{-- KONTEN KIRI --}}
                        <div class="relative flex-1 space-y-4 text-white">
                            {{-- badge NEW --}}
                            <div class="inline-flex items-center rounded-full bg-amber-500 px-3 py-1 text-lg font-semibold">
                                NEW
                            </div>

                            {{-- judul --}}
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight">
                                {{ $manga->title }}
                            </h2>

                            {{-- info chapter --}}
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 font-semibold">
                                    Chapter {{ $manga->chapters->count() ?? 0 }}
                                </span>
                                <span>Baru dirilis</span>
                            </div>

                            {{-- sinopsis singkat --}}
                            <p class="text-sm sm:text-base text-gray-200 line-clamp-3 max-w-2xl">
                                {{ $manga->description }}
                            </p>

                            {{-- genre pill --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach ($manga->genres->take(4) as $genre)
                                    <span class="rounded-md bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">
                                        {{ $genre->name }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- tombol --}}
                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="{{ route('manga.detail', $manga->slug) }}"
                                   class="inline-flex items-center justify-center rounded-full bg-amber-500 px-6 py-2 text-sm font-semibold text-black hover:bg-amber-400 transition">
                                    📖 Baca
                                </a>

                                <form method="post" action="">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-full bg-white/10 px-6 py-2 text-sm font-semibold text-gray-200 hover:bg-white/20 transition">
                                        🤍 Simpan
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- KONTEN KANAN: COVER --}}
                        <div class="relative w-full max-w-[220px] self-center lg:self-stretch">
                            <div class="overflow-hidden rounded-3xl shadow-xl shadow-black/40">
                                <img src="{{ asset('storage/manga/' . $manga->cover_image) }}" alt="{{ $manga->title }}"
                                     class="h-full w-full object-cover">
                            </div>

                            {{-- badge rating / favorit --}}
                            <div class="absolute top-3 right-3 inline-flex items-center gap-1 rounded-full bg-black/70 px-2 py-1 text-xs font-semibold text-amber-400">
                                ⭐ {{ $manga->rating ?? '7.0' }}
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- pagination dot di bawah tengah card --}}
        <div class="swiper-pagination static! mt-3 flex justify-center"></div>
    </div>

    {{-- tombol panah kiri/kanan --}}
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 sm:pl-7">
        <div class="swiper-button-prev static! pointer-events-auto flex h-10 w-10 items-center justify-center hover:scale-110 transition">
        </div>
    </div>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 sm:pr-7">
        <div class="swiper-button-next static! pointer-events-auto flex h-10 w-10 items-center justify-center hover:scale-110 transition">
        </div>
    </div>
</div>
