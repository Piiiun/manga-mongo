<x-layout title="Daftar Manga">

    <h1 class="text-3xl font-bold text-white mb-6">Daftar Manga</h1>

    {{-- Search Bar --}}
    <div class="flex gap-2 mb-6">
        <input type="text" placeholder="Cari manga..."
               class="w-full rounded-md bg-white/10 px-4 py-2 text-white placeholder-gray-400">
        <button class="bg-amber-500 hover:bg-amber-600 p-3 rounded-md text-white">
            🔍
        </button>
    </div>

    {{-- Toolbar Filter --}}
    <div class="flex flex-wrap items-center gap-3 justify-between mb-7">
        <div class="flex items-center gap-2 text-gray-300">
            <span>Tampilan:</span>
            <button class="bg-amber-500 text-black px-2 py-2 rounded-md">🔲</button>
            <button class="bg-white/10 px-2 py-2 rounded-md text-white">📄</button>
        </div>

        <select class="bg-white/10 text-white rounded-md px-3 py-2">
            <option>Terbaru</option>
            <option>Populer</option>
            <option>A-Z</option>
        </select>

        <button class="bg-white/10 px-3 py-2 rounded-md text-white">Filter ⚙</button>
    </div>

    {{-- GRID LIST --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($mangas as $manga)
            <x-manga-card-list :manga="$manga" />
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $mangas->links() }}
    </div>

</x-layout>
