<x-layout>
    <div class="min-h-screen bg-linear-to-b from-gray-950 to-black py-10">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Header --}}
            <div class="sm:flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Manga Management</h1>
                    <p class="text-gray-400">Kelola semua manga di website</p>
                </div>
                <a href="{{ route('admin.manga.create') }}" 
                   class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-6 py-3 rounded-lg transition-colors flex items-center gap-2 mt-5 w-70">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Manga Baru
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-900/50 border border-green-700 text-green-400 px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Manga Table --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Cover</th>
                                <th class="px-15 py-4 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                                <th class="px-10 py-4 text-left text-xs font-medium text-gray-400 uppercase">Chapters</th>
                                <th class="px-7 py-4 text-left text-xs font-medium text-gray-400 uppercase">Rating</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase">Views</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($mangas as $manga)
                                <tr class="hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        @if($manga->cover_image)
                                            <img src="{{ asset('storage/manga/' . $manga->cover_image) }}" 
                                                 alt="{{ $manga->title }}"
                                                 class="w-12 h-16 object-cover rounded">
                                        @else
                                            <div class="w-12 h-16 bg-gray-800 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-white font-medium">{{ $manga->title }}</div>
                                        <div class="text-gray-400 text-sm mt-1">{{ $manga->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-300">{{ $manga->type }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $manga->status === 'Ongoing' ? 'bg-green-900/50 text-green-400' : 'bg-blue-900/50 text-blue-400' }}">
                                            {{ $manga->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.manga.chapters', $manga) }}" 
                                           class="text-amber-400 hover:text-amber-300 font-medium">
                                            {{ $manga->chapters_count }} chapters
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-amber-400">{{ number_format($manga->rating, 1) }} ★</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-300">{{ number_format($manga->views) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('manga.detail', $manga->slug) }}" 
                                               target="_blank"
                                               class="p-2 text-gray-400 hover:text-blue-400 transition-colors" 
                                               title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.gallery.create', $manga) }}" 
                                               class="p-2 text-gray-400 hover:text-amber-400 transition-colors" 
                                               title="Gallery">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.manga.edit', $manga) }}" 
                                               class="p-2 text-gray-400 hover:text-amber-400 transition-colors" 
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.manga.destroy', $manga) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus manga ini? Semua chapter dan pages akan ikut terhapus!')"
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
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                        Belum ada manga. <a href="{{ route('admin.manga.create') }}" class="text-amber-400 hover:text-amber-300 ">Tambah manga baru</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($mangas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-800">
                        {{ $mangas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>