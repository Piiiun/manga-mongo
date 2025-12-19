<x-layout>
    <div class="min-h-screen bg-linear-to-b from-slate-950 to-transparent py-10">
        <div class="max-w-4xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.manga.index') }}" 
                   class="text-gray-400 hover:text-white transition-colors inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke List
                </a>
                <h1 class="text-3xl font-bold text-white">Tambah Manga Baru</h1>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.manga.store') }}" method="POST" enctype="multipart/form-data" 
                  class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 space-y-6">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="block text-white font-medium mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alternative Title --}}
                <div>
                    <label class="block text-white font-medium mb-2">Alternative Title</label>
                    <input type="text" name="alternative_title" value="{{ old('alternative_title') }}"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('alternative_title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-white font-medium mb-2">Description</label>
                    <textarea name="description" rows="6"
                              class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cover Image --}}
                <div>
                    <label class="block text-white font-medium mb-2">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-500 file:text-white file:cursor-pointer hover:file:bg-amber-600">
                    <p class="text-gray-400 text-sm mt-2">Max 5MB. Format: JPG, PNG, WEBP</p>
                    @error('cover_image')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row: Author & Artist --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white font-medium mb-2">Author</label>
                        <input type="text" name="author" value="{{ old('author') }}"
                               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('author')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-white font-medium mb-2">Artist</label>
                        <input type="text" name="artist" value="{{ old('artist') }}"
                               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('artist')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row: Status & Type --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white font-medium mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required
                                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="Ongoing" {{ old('status') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-white font-medium mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="type" required
                                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="Manga" {{ old('type') === 'Manga' ? 'selected' : '' }}>Manga</option>
                            <option value="Manhwa" {{ old('type') === 'Manhwa' ? 'selected' : '' }}>Manhwa</option>
                            <option value="Manhua" {{ old('type') === 'Manhua' ? 'selected' : '' }}>Manhua</option>
                        </select>
                        @error('type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row: Rating & Released Year --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white font-medium mb-2">Rating (0-10)</label>
                        <input type="number" name="rating" value="{{ old('rating', 0) }}" 
                               min="0" max="10" step="0.1"
                               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('rating')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-white font-medium mb-2">Released Year</label>
                        <input type="number" name="released_at" value="{{ old('released_at') }}" 
                               min="1900" max="{{ date('Y') }}" placeholder="2023"
                               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('released_at')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Serialization --}}
                <div>
                    <label class="block text-white font-medium mb-2">Serialization</label>
                    <input type="text" name="serialization" value="{{ old('serialization') }}"
                           placeholder="e.g., Weekly Shonen Jump, Comptiq"
                           class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('serialization')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Genres --}}
                <div>
                    <label class="block text-white font-medium mb-2">Genres</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($genres as $genre)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-amber-500 bg-gray-800 border-gray-700 rounded focus:ring-amber-500">
                                <span class="text-gray-300">{{ $genre->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('genres')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-6 py-3 rounded-lg transition-colors">
                        Simpan Manga
                    </button>
                    <a href="{{ route('admin.manga.index') }}"
                       class="bg-gray-800 hover:bg-gray-700 text-white font-bold px-6 py-3 rounded-lg transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>