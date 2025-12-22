<x-layout title="Edit Profile - MangaMongo">
    <div class="min-h-screen py-6 px-4">
        <div class="max-w-3xl mx-auto">
            
            <div class="mb-3">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center text-amber-400 hover:text-amber-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Profile
                </a>
            </div>

            <div class="bg-slate-100/50 dark:bg-gray-900/50 border border-gray-800 rounded-2xl p-8">
                <h1 class="text-3xl font-bold text-black dark:text-white mb-8">Edit Profile</h1>

                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Profile Picture Section --}}
                    <div class="mb-8">
                        <label class="block text-gray-600 dark:text-gray-300 font-semibold mb-4">Foto Profile</label>
                        
                        <div class="flex items-center gap-6">
                            <img id="preview-image" 
                                 src="{{ $user->profile_picture_url }}" 
                                 alt="Profile Preview"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-amber-500">
                            
                            <div class="flex-1">
                                <input type="file" 
                                       name="profile_picture" 
                                       id="profile_picture" 
                                       accept="image/*"
                                       class="hidden">
                                
                                <div class="flex gap-3">
                                    <button type="button" 
                                            onclick="document.getElementById('profile_picture').click()"
                                            class="bg-amber-500 hover:bg-amber-400 text-black font-bold px-6 py-2.5 rounded-lg transition-colors">
                                        Upload Foto Baru
                                    </button>
                                    
                                    @if($user->profile_picture)
                                        <button type="button" 
                                                onclick="if(confirm('Hapus foto profile?')) document.getElementById('delete-photo-form').submit()"
                                                class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-2.5 rounded-lg transition-colors">
                                            Hapus Foto
                                        </button>
                                    @endif
                                </div>
                                
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                    JPG, PNG. Max 2MB
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="mb-6">
                        <label class="block text-gray-600 dark:text-gray-300 font-semibold mb-2">Nama</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required
                               class="w-full px-4 py-3 rounded-lg bg-slate-300 dark:bg-gray-800 text-black dark:text-white border border-gray-700 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    </div>

                    {{-- Email --}}
                    <div class="mb-6">
                        <label class="block text-gray-600 dark:text-gray-300 font-semibold mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               class="w-full px-4 py-3 rounded-lg bg-slate-300 dark:bg-gray-800 text-black dark:text-white border border-gray-700 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    </div>

                    {{-- Bio --}}
                    <div class="mb-8">
                        <label class="block text-gray-600 dark:text-gray-300 font-semibold mb-2">Bio</label>
                        <textarea name="bio" 
                                  rows="4"
                                  maxlength="500"
                                  placeholder="Ceritakan tentang dirimu..."
                                  class="w-full px-4 py-3 rounded-lg bg-slate-300 dark:bg-gray-800 text-black dark:text-white border border-gray-700 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">{{ old('bio', $user->bio) }}</textarea>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Max 500 karakter</p>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="bg-amber-500 hover:bg-amber-400 text-black font-bold px-8 py-3 rounded-lg transition-colors cursor-pointer">
                            Simpan Perubahan
                        </button>
                        
                        <a href="{{ route('profile.show') }}" 
                           class="bg-gray-800 hover:bg-gray-700 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                            Batal
                        </a>
                    </div>
                </form>

                {{-- Hidden form for deleting photo --}}
                @if($user->profile_picture)
                    <form id="delete-photo-form" 
                          method="POST" 
                          action="{{ route('profile.delete-photo') }}" 
                          class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Preview image before upload
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layout>