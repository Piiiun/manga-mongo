@props(['manga'])

<article class="group relative bg-linear-to-b from-card to-card-2/80 rounded-xl overflow-hidden border border-gray-800 hover:border-accent transition-all duration-300 hover:shadow-lg hover:shadow-accent/10">
    
    {{-- Hot Badge --}}
    @if($manga->rating >= 8.0)
        <div class="absolute top-3 left-3 z-10">
            <span class="bg-linear-to-r from-badge-1 to-badge-2 text-text text-xs font-bold px-2.5 py-1 rounded-full">
                Hot
            </span>
        </div>
    @elseif($manga->created_at->diffInDays(now()) <= 3)
        <div class="absolute top-3 left-3 z-10">
            <span class="bg-linear-to-r from-accent-strong to-accent text-text text-xs font-bold px-2.5 py-1 rounded-full">
                New
            </span>
        </div>
    @endif

    {{-- COVER IMAGE --}}
    <div class="relative aspect-3/4 overflow-hidden">
        <img 
            src="{{ asset('storage/manga/' . $manga->cover_image) }}" 
            alt="{{ $manga->title }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        >
        
        {{-- Dark Overlay Bottom --}}
        <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-linear-to-t from-overlay/90 via-overlay/50 to-transparent"></div>
    </div>

    {{-- CONTENT --}}
    <div class="p-3">
        {{-- Genres --}}
        <div class="flex flex-wrap gap-1.5 mb-2">
            @foreach($manga->genres->take(2) as $genre)
                <span class="bg-card/70 text-genre-text text-xs md:px-2 px-1 md:py-1 py-0.5 rounded-md border border-border">
                    {{ $genre->name }}
                </span>
            @endforeach
        </div>

        {{-- Title --}}
        <h3 class="font-bold text-text text-[15px] line-clamp-2 leading-tight mb-2 group-hover:text-accent-hover transition-colors">
            {{ $manga->title }}
        </h3>

        {{-- Status & Rating --}}
        <div class="flex items-center justify-between">
            {{-- Status --}}
            <span class="text-xs font-medium px-2 py-1 rounded
                @if($manga->status == 'Ongoing')
                    bg-green-900/40 text-green-400 border-green-800/50
                @else
                    bg-gray-800/40 text-info border-gray-700/50
                @endif
            ">
                {{ $manga->status ?? 'Ongoing' }}
            </span>

            {{-- Rating --}}
            <div class="flex items-center gap-1">
                <span class="text-rating text-sm">★</span>
                <span class="text-text font-bold text-sm">{{ number_format($manga->rating ?? 7.5, 1) }}</span>
            </div>
        </div>
    </div>
</article>