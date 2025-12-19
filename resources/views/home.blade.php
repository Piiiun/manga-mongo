<x-layout>
    <div class="min-h-screen max-w-[1540px] mx-auto bg-linear-to-b from-slate-950 to-transparent">
        <x-hero-slider :featuredMangas="$featuredMangas" />
        @auth
            <x-continue-reading-home :lastHistory="$lastHistory" />
        @endauth
        <x-section-home :latestMangas="$latestMangas"/>
        <x-popular-home :popularMangas="$popularMangas" />
    </div>
</x-layout>