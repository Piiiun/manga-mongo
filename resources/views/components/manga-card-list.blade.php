@props(['manga'])

<article class="group relative bg-linear-to-b from-card-light to-card-2-light dark:from-gray-900/80 dark:to-gray-950/80 rounded-xl overflow-hidden border border-gray-800 hover:border-amber-500 transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/20 shadow-md shadow-black/50">
    
    {{-- Hot Badge --}}
    @if($manga->rating >= 8.0)
        <div class="absolute top-3 left-3 z-10">
            <span class="bg-linear-to-r from-red-600 to-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                Hot
            </span>
        </div>
    @elseif($manga->created_at->diffInDays(now()) <= 3)
        <div class="absolute top-3 left-3 z-10">
            <span class="bg-linear-to-r from-blue-600 to-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
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
        <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-linear-to-t from-white/60 via-white/20 dark:from-black/90 dark:via-black/50 to-transparent"></div>
    </div>

    {{-- CONTENT --}}
    <div class="p-3">
        {{-- Genres --}}
        <div class="flex flex-wrap gap-1.5 mb-2">
            @foreach($manga->genres->take(2) as $genre)
                <span class="bg-gray-800/70 text-gray-300 text-xs md:px-2 px-1 md:py-1 py-0.5 rounded-md border border-gray-700">
                    {{ $genre->name }}
                </span>
            @endforeach
        </div>

        {{-- Title --}}
        <h3 class="font-bold text-black dark:text-white text-[15px] line-clamp-2 leading-tight mb-2 group-hover:text-amber-300 transition-colors">
            {{ $manga->title }}
        </h3>

        {{-- Status & Rating --}}
        <div class="flex items-center justify-between">
            {{-- Status --}}
            <span class="text-xs font-medium px-2 py-1 rounded
                @if($manga->status == 'Ongoing')
                    bg-green-900/80 dark:bg-green-900/40 text-green-400 border-green-800/50
                @else
                    bg-blue-700/70 dark:bg-gray-800/40 text-blue-300 border-gray-700/50
                @endif
            ">
                {{ $manga->status ?? 'Ongoing' }}
            </span>

            {{-- Rating --}}
            <div class="flex items-center gap-1">
                <span class="text-amber-400 text-sm">★</span>
                <span class="text-black dark:text-white font-bold text-sm">{{ number_format($manga->rating ?? 7.5, 1) }}</span>
            </div>
        </div>
    </div>
</article>