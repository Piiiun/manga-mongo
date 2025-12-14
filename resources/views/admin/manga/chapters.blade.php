<x-layout>
    <div class="min-h-screen bg-linear-to-b from-gray-950 to-black py-10">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.manga.index') }}" 
                   class="text-gray-400 hover:text-white transition-colors inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Manga List
                </a>
                <div class="sm:flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Chapters: {{ $manga->title }}</h1>
                        <p class="text-gray-400">Total: {{ $chapters->total() }} chapters</p>
                    </div>
                    <div class="flex gap-3 mt-5 sm:mt-0">
                        <form action="{{ route('admin.manga.chapters.sync-all', $manga) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Sync semua chapters? Ini akan scan folder dan update pages di database.')"
                                    class="text-sm bg-blue-600 hover:bg-blue-700 text-white font-bold px-3 sm:px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Sync All Chapters
                            </button>
                        </form>
                        <a href="{{ route('admin.manga.chapters.bulk-create', $manga) }}" 
                           class="text-sm bg-green-600 hover:bg-green-700 text-white font-bold px-3 sm:px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Bulk Create
                        </a>
                        <a href="{{ route('admin.manga.chapters.create', $manga) }}" 
                           class="text-sm bg-amber-500 hover:bg-amber-600 text-white font-bold px-3 sm:px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Chapter
                        </a>
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-900/50 border border-green-700 text-green-400 px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="bg-red-900/50 border border-red-700 text-red-400 px-6 py-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Chapters Table --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Chapter #</th>
                                <th class="px-12 py-4 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Pages</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Published</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Views</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($chapters as $chapter)
                                <tr class="hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-white font-bold text-lg">{{ $chapter->number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-white">
                                            {{ $chapter->title ?? '-' }}
                                        </div>
                                        <div class="text-gray-400 text-sm">{{ $chapter->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-300">{{ $chapter->pages_count }} pages</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-300">{{ $chapter->published_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-300">{{ number_format($chapter->views ?? 0) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Sync Button --}}
                                            <form action="{{ route('admin.manga.chapters.sync', [$manga, $chapter]) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  title="Sync images dari folder">
                                                @csrf
                                                <button type="submit" 
                                                        onclick="return confirm('Sync Chapter {{ $chapter->number }}? Folder: manga/pages/{{ $manga->slug }}/chapter-{{ $chapter->number }}')"
                                                        class="p-2 text-gray-400 hover:text-green-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('manga.read', [$manga->slug, $chapter->number]) }}" 
                                               target="_blank"
                                               class="p-2 text-gray-400 hover:text-blue-400 transition-colors" 
                                               title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.manga.chapters.edit', [$manga, $chapter]) }}" 
                                               class="p-2 text-gray-400 hover:text-amber-400 transition-colors" 
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.manga.chapters.destroy', [$manga, $chapter]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus Chapter {{ $chapter->number }}? Semua pages akan ikut terhapus!')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-red-400 transition-colors" 
                                                        title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        Belum ada chapter. <a href="{{ route('admin.manga.chapters.create', $manga) }}" class="text-amber-400 hover:text-amber-300">Tambah chapter baru</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($chapters->hasPages())
                    <div class="px-6 py-4 border-t border-gray-800">
                        {{ $chapters->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>