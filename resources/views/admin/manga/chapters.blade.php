<x-layout>
    <div class="min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('admin.manga.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Manga List
                </a>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-0">
                    {{-- Header Info --}}
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-1 sm:mb-2">Chapters: {{ $manga->title }}</h1>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-amber-400">{{ $chapters->total() }}</span> chapters</p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        {{-- Sync All Chapters Button --}}
                        <form action="{{ route('admin.manga.chapters.sync-all', $manga) }}" method="POST" class="flex-1 sm:flex-initial">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Sync semua chapters? Ini akan scan folder dan update pages di database.')"
                                    class="group relative w-full sm:w-auto text-xs sm:text-sm bg-blue-600 hover:bg-blue-500 text-white font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/40 flex items-center justify-center gap-2 overflow-hidden">
                                <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 relative z-10 transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="relative z-10 hidden sm:inline">Sync All Chapters</span>
                                <span class="relative z-10 sm:hidden">Sync All</span>
                            </button>
                        </form>

                        {{-- Bulk Create Button --}}
                        <a href="{{ route('admin.manga.chapters.bulk-create', $manga) }}" 
                        class="group relative flex-1 sm:flex-initial text-xs sm:text-sm bg-green-600 hover:bg-green-500 text-white font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-green-500/40 flex items-center justify-center gap-2 overflow-hidden">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-green-500 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 relative z-10 transition-all duration-300 group-hover:scale-110 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="relative z-10">Bulk Create</span>
                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 relative z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>

                        {{-- Add Chapter Button --}}
                        <a href="{{ route('admin.manga.chapters.create', $manga) }}" 
                        class="group relative flex-1 sm:flex-initial text-xs sm:text-sm bg-amber-500 hover:bg-amber-400 text-black font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-amber-500/40 flex items-center justify-center gap-2 overflow-hidden">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-amber-400 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 relative z-10 transition-all duration-300 group-hover:scale-125 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="relative z-10 hidden sm:inline">Tambah Chapter</span>
                            <span class="relative z-10 sm:hidden">Tambah</span>
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
            <div class="bg-slate-100/70 dark:bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-200 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-700 dark:text-gray-400 uppercase">Chapter #</th>
                                <th class="px-12 py-4 text-left text-xs font-medium text-gray-700 dark:text-gray-400 uppercase">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-700 dark:text-gray-400 uppercase">Pages</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-700 dark:text-gray-400 uppercase">Published</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-700 dark:text-gray-400 uppercase">Views</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-700 dark:text-gray-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($chapters as $chapter)
                                <tr class="hover:bg-gray-300 hover:dark:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-black dark:text-white font-bold text-lg">{{ $chapter->number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-black dark:text-white">
                                            {{ $chapter->title ?? '-' }}
                                        </div>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">{{ $chapter->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 dark:text-gray-300">{{ $chapter->pages_count }} pages</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 dark:text-gray-300">{{ $chapter->published_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 dark:text-gray-300">{{ number_format($chapter->views ?? 0) }}</span>
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
                                                        class="p-2 text-gray-600 dark:text-gray-400 hover:text-green-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('manga.read', [$manga->slug, $chapter->number]) }}" 
                                               target="_blank"
                                               class="p-2 text-gray-600 dark:text-gray-400 hover:text-blue-400 transition-colors" 
                                               title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.manga.chapters.edit', [$manga, $chapter]) }}" 
                                               class="p-2 text-gray-600 dark:text-gray-400 hover:text-amber-400 transition-colors" 
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
                                                        class="p-2 text-gray-600 dark:text-gray-400 hover:text-red-400 transition-colors" 
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

    <style>
        /* Smooth animations */
        .max-w-6xl button, .max-w-6xl a {
            position: relative;
            transform-style: preserve-3d;
        }

        /* Shine effect on hover */
        @keyframes shine {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }

        .group:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shine 0.6s;
            z-index: 20;
        }

        /* Pulse animation for primary action */
        @keyframes pulse-border {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.4);
            }
            50% {
                box-shadow: 0 0 0 4px rgba(251, 191, 36, 0);
            }
        }

        /* Add subtle bounce on mobile tap */
        @media (max-width: 640px) {
            button:active, a:active {
                transform: scale(0.97);
            }
        }

        /* Loading state animation for sync button */
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        button[type="submit"]:active svg {
            animation: spin-slow 1s linear infinite;
        }
    </style>
</x-layout>