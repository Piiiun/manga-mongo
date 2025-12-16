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
                <h1 class="text-3xl font-bold text-white">Tambah Chapter Baru</h1>
                <p class="text-text-second mt-2">Manga: {{ $manga->title }}</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.manga.chapters.store', $manga) }}" method="POST"
                  class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 space-y-6">
                @csrf

                {{-- Chapter Number --}}
                <div>
                    <label class="block text-white font-medium mb-2">Chapter Number <span class="text-red-500">*</span></label>
                    <input type="number" name="number" value="{{ old('number') }}" required
                           step="0.1" placeholder="1, 1.5, 2, etc"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent">
                    @error('number')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-text-second text-sm mt-2">Support decimal: 1, 1.5, 2, etc</p>
                </div>

                {{-- Chapter Title --}}
                <div>
                    <label class="block text-white font-medium mb-2">Chapter Title (Optional)</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="e.g., The Beginning"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent">
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                                <li>Chapter hanya metadata, pages diupload via Python script</li>
                                <li>Slug akan auto-generate dari chapter number</li>
                                <li>Pastikan convert images dulu sebelum reader bisa diakses</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-accent hover:bg-accent-hover text-white font-bold px-6 py-3 rounded-lg transition-colors">
                        Simpan Chapter
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