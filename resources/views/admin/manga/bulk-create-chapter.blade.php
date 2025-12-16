<x-layout>
    <div class="min-h-screen bg-linear-to-b from-gray-950 to-black py-10">
        <div class="max-w-2xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.manga.chapters', $manga) }}" 
                   class="text-text-second hover:text-white transition-colors inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Chapters
                </a>
                <h1 class="text-3xl font-bold text-white">Tambah Banyak Chapter Sekaligus</h1>
                <p class="text-text-second mt-2">Manga: {{ $manga->title }}</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.manga.chapters.bulk-store', $manga) }}" method="POST"
                  class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 space-y-6">
                @csrf

                {{-- Chapter Numbers --}}
                <div>
                    <label class="block text-white font-medium mb-2">Chapter Numbers <span class="text-red-500">*</span></label>
                    <input type="text" name="chapters" value="{{ old('chapters') }}" required
                           placeholder="Contoh: 1-10 atau 1,2,3,5 atau 1-5,7,10-15"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent">
                    @error('chapters')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-text-second text-sm mt-2">
                        Format: 
                        <span class="text-accent-hover">1-10</span> (range), 
                        <span class="text-accent-hover">1,2,3,5</span> (list), atau 
                        <span class="text-accent-hover">1-5,7,10-15</span> (kombinasi)
                    </p>
                    <p class="text-text-second text-sm mt-1">Support decimal: 1, 1.5, 2, 2.5, etc</p>
                </div>

                {{-- Published Date --}}
                <div>
                    <label class="block text-white font-medium mb-2">Published Date</label>
                    <input type="date" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent">
                    @error('published_at')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-900/20 border border-blue-800 rounded-lg p-4">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-gray-300">
                            <p class="font-medium mb-1">Catatan:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Title chapter akan dikosongkan</li>
                                <li>Chapter yang sudah ada akan dilewati</li>
                                <li>Slug akan auto-generate dari chapter number</li>
                                <li>Pages diupload via Python script</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Examples Box --}}
                <div class="bg-amber-900/20 border border-amber-800 rounded-lg p-4">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-accent-hover shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div class="text-sm text-gray-300">
                            <p class="font-medium mb-2 text-accent-hover">Contoh Input:</p>
                            <ul class="space-y-1 text-text-second">
                                <li><code class="bg-gray-800 px-2 py-1 rounded">1-10</code> → Membuat chapter 1 sampai 10</li>
                                <li><code class="bg-gray-800 px-2 py-1 rounded">1,2,3,5,7</code> → Membuat chapter 1, 2, 3, 5, dan 7</li>
                                <li><code class="bg-gray-800 px-2 py-1 rounded">1-5,7,10-15</code> → Membuat chapter 1-5, 7, dan 10-15</li>
                                <li><code class="bg-gray-800 px-2 py-1 rounded">1,1.5,2,2.5</code> → Membuat chapter dengan decimal</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-accent hover:bg-accent-hover text-white font-bold px-6 py-3 rounded-lg transition-colors">
                        Simpan Chapters
                    </button>
                    <a href="{{ route('admin.manga.chapters', $manga) }}"
                       class="bg-gray-800 hover:bg-gray-700 text-white font-bold px-6 py-3 rounded-lg transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>

