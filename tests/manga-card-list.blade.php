@props(['manga'])

<article class="group overflow-hidden rounded-2xl bg-[#111827] shadow-xl hover:shadow-2xl hover:-translate-y-1 duration-200">
    
    {{-- COVER --}}
    <div class="relative">
        <img src="{{ asset('storage/manga/' . $manga->cover_image) }}"
             alt="{{ $manga->title }}"
             class="h-64 w-full object-cover">

        {{-- Badge Baru/Hot (opsional logika) --}}
        @if($manga->is_new ?? true)
            <span class="absolute left-2 top-2 bg-red-500 text-xs font-bold text-white px-2 py-1 rounded-md">
                BARU
            </span>
        @endif
    </div>

    {{-- INFO --}}
    <div class="p-4 space-y-3">

        {{-- Genres --}}
        <div class="flex flex-wrap gap-2 text-xs">
            @foreach($manga->genres->take(3) as $genre)
                <span class="bg-white/10 px-2 py-1 rounded-md">{{ $genre->name }}</span>
            @endforeach
        </div>

        {{-- Judul --}}
        <h3 class="font-semibold line-clamp-2 text-white text-[1.05rem]">
            {{ $manga->title }}
        </h3>

        {{-- Status + Rating --}}
        <div class="flex items-center justify-between text-[0.85rem] text-gray-300">
            <span>{{ $manga->status ?? 'Ongoing' }}</span>
            <span class="flex items-center gap-1">
                ⭐ <b>{{ $manga->rating ?? 7.5 }}</b>
            </span>
        </div>

    </div>
</article>
