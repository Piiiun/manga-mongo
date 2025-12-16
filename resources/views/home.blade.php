<x-layout>
    <div class="min-h-screen bg-linear-to-b from-card-2 to-transparent">
        <x-hero-slider :featuredMangas="$featuredMangas" />
        <x-section-home :latestMangas="$latestMangas"/>
        <x-popular-home :popularMangas="$popularMangas" />
    </div>
</x-layout>