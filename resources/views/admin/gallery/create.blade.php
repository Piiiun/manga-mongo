<x-layout title="Upload Gallery - {{ $manga->title }}">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">
            
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('manga.detail', $manga->slug) }}#gallery" 
                   class="inline-flex items-center text-gray-600 hover:text-black dark:text-gray-400 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Manga Detail
                </a>
            </div>

            <div class="bg-slate-100/50 dark:bg-gray-900/50 border border-gray-800 rounded-2xl p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-black dark:text-white mb-2">Upload Gallery</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $manga->title }}</p>
                </div>

                @if (session('success'))
                    <div class="bg-green-500/20 border border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.gallery.store', $manga) }}" enctype="multipart/form-data" id="gallery-form">
                    @csrf

                    {{-- Type Selection --}}
                    <div class="mb-6">
                        <label class="block text-gray-600 dark:text-gray-300 font-semibold mb-3">Tipe Gambar</label>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="cover" required class="peer sr-only">
                                <div class="p-4 bg-gray-300 dark:bg-gray-800 border-2 border-gray-700 rounded-lg text-center peer-checked:border-amber-500 peer-checked:bg-amber-500/10 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 dark:text-gray-400 peer-checked:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Cover</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="artwork" class="peer sr-only">
                                <div class="p-4 bg-gray-300 dark:bg-gray-800 border-2 border-gray-700 rounded-lg text-center peer-checked:border-amber-500 peer-checked:bg-amber-500/10 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Artwork</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="promotional" class="peer sr-only">
                                <div class="p-4 bg-gray-300 dark:bg-gray-800 border-2 border-gray-700 rounded-lg text-center peer-checked:border-amber-500 peer-checked:bg-amber-500/10 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Promo</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="fanart" class="peer sr-only">
                                <div class="p-4 bg-gray-300 dark:bg-gray-800 border-2 border-gray-700 rounded-lg text-center peer-checked:border-amber-500 peer-checked:bg-amber-500/10 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Fanart</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="other" class="peer sr-only">
                                <div class="p-4 bg-gray-300 dark:bg-gray-800 border-2 border-gray-700 rounded-lg text-center peer-checked:border-amber-500 peer-checked:bg-amber-500/10 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lainnya</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="mb-6">
                        <label class="block text-gray-600 dark:text-gray-300 font-semibold mb-3">
                            Pilih Gambar (Max 10 gambar)
                        </label>
                        <div class="border-2 border-dashed border-gray-700 rounded-lg p-8 text-center hover:border-amber-500 transition-colors">
                            <input type="file" 
                                   name="images[]" 
                                   id="images" 
                                   multiple 
                                   accept="image/*" 
                                   required
                                   class="hidden"
                                   onchange="handleFiles(this.files)">
                            <label for="images" class="cursor-pointer">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-gray-400 mb-2">Klik untuk upload atau drag & drop</p>
                                <p class="text-gray-500 text-sm">JPG, PNG, WEBP. Max 5MB per gambar</p>
                            </label>
                        </div>
                        <p class="text-gray-500 text-sm mt-2">Max 10 gambar per upload</p>
                    </div>

                    {{-- Preview Area --}}
                    <div id="preview-container" class="hidden mb-6">
                        <label class="block text-gray-300 font-semibold mb-3">Preview & Details</label>
                        <div id="preview-list" class="space-y-4"></div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex gap-3">
                        <button type="submit" 
                                id="submit-btn"
                                class="bg-amber-500 hover:bg-amber-400 text-black font-bold px-8 py-3 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            Upload Gallery
                        </button>
                        
                        <a href="{{ route('manga.detail', $manga->slug) }}" 
                           class="bg-gray-800 hover:bg-gray-700 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let selectedFiles = [];

        function handleFiles(files) {
            if (files.length > 10) {
                alert('Maksimal 10 gambar per upload');
                return;
            }

            selectedFiles = Array.from(files);
            displayPreviews();
        }

        function displayPreviews() {
            const container = document.getElementById('preview-container');
            const list = document.getElementById('preview-list');
            
            if (selectedFiles.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            list.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'bg-gray-800 border border-gray-700 rounded-lg p-4 flex gap-4';
                    div.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview ${index + 1}"
                             class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                        
                        <div class="flex-1 space-y-3">
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Judul (Opsional)</label>
                                <input type="text" 
                                       name="titles[]" 
                                       placeholder="Contoh: Cover Volume 1"
                                       class="w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:border-amber-500">
                            </div>
                            
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Deskripsi (Opsional)</label>
                                <textarea name="descriptions[]" 
                                          rows="2"
                                          placeholder="Deskripsi gambar..."
                                          class="w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:border-amber-500 resize-none"></textarea>
                            </div>
                        </div>

                        <button type="button" 
                                onclick="removeFile(${index})"
                                class="p-2 h-fit text-red-400 hover:text-red-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                    list.appendChild(div);
                };
                
                reader.readAsDataURL(file);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            
            // Update file input
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            document.getElementById('images').files = dt.files;
            
            displayPreviews();
        }

        // Drag and drop
        const dropArea = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add('border-amber-500');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove('border-amber-500');
            }, false);
        });

        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('images').files = files;
            handleFiles(files);
        }, false);

        // Form validation
        document.getElementById('gallery-form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Uploading...';
        });
    </script>
</x-layout>