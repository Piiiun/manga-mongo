<x-layout>
    <div class="min-h-screen bg-gradient-to-b from-gray-950 to-black py-10">
        <div class="max-w-4xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.manga.chapters', $manga) }}" 
                   class="text-text-second hover:text-white transition-colors inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Chapter List
                </a>
                <h1 class="text-3xl font-bold text-white mb-2">Edit Chapter</h1>
                <p class="text-text-second">{{ $manga->title }} - Chapter {{ $chapter->number }}</p>
            </div>

            {{-- Form --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8">
                <form action="{{ route('admin.manga.chapters.update', [$manga, $chapter]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Chapter Number --}}
                    <div class="mb-6">
                        <label for="number" class="block text-sm font-medium text-gray-300 mb-2">
                            Chapter Number <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               step="0.1"
                               name="number" 
                               id="number" 
                               value="{{ old('number', $chapter->number) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                               placeholder="e.g., 1 or 1.5"
                               required>
                        @error('number')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-text-second">Support decimal untuk special chapters (e.g., 1.5, 2.5)</p>
                    </div>

                    {{-- Chapter Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                            Chapter Title <span class="text-gray-500">(Optional)</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $chapter->title) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                               placeholder="e.g., The Beginning">
                        @error('title')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Published Date --}}
                    <div class="mb-8">
                        <label for="published_at" class="block text-sm font-medium text-gray-300 mb-2">
                            Published Date
                        </label>
                        <input type="date" 
                               name="published_at" 
                               id="published_at" 
                               value="{{ old('published_at', $chapter->published_at?->format('Y-m-d')) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        @error('published_at')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-900/30 border border-blue-700/50 rounded-lg p-4 mb-8">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-200">
                                <p class="font-medium mb-1">Info:</p>
                                <ul class="list-disc list-inside space-y-1 text-blue-300">
                                    <li>Slug akan otomatis di-generate dari chapter number</li>
                                    <li>Chapter number harus unik untuk manga ini</li>
                                    <li>Current pages: {{ $chapter->pages_count ?? 0 }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.manga.chapters', $manga) }}" 
                           class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-accent hover:bg-accent-hover text-white font-bold rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Chapter
                        </button>
                    </div>
                </form>
            </div>

            {{-- Chapter Info Stats --}}
            <div class="mt-6 bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <h2 class="text-lg font-bold text-white mb-4">Chapter Statistics</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-text-second text-sm mb-1">Pages</p>
                        <p class="text-2xl font-bold text-white">{{ $chapter->pages_count ?? 0 }}</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-text-second text-sm mb-1">Views</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($chapter->views ?? 0) }}</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-text-second text-sm mb-1">Created</p>
                        <p class="text-sm font-medium text-white">{{ $chapter->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-text-second text-sm mb-1">Updated</p>
                        <p class="text-sm font-medium text-white">{{ $chapter->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>