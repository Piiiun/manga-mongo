<x-layout title="Profile - MangaMongo">
    <div class="min-h-screen bg-linear-to-b from-gray-950 to-black py-8 px-4">
        <div class="max-w-6xl mx-auto">
            
            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-500/20 border border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Profile Card --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-8 mb-8">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start scale-90 sm:scale-100">
                    
                    {{-- Profile Picture --}}
                    <div class="relative">
                        <img src="{{ $user->profile_picture_url }}" 
                             alt="{{ $user->name }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-accent shadow-lg">
                        <div class="absolute -bottom-2 -right-2 bg-accent text-black rounded-full p-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Profile Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                        <p class="text-text-second mb-4">{{ $user->email }}</p>
                        
                        @if($user->bio)
                            <p class="text-gray-300 mb-6 max-w-2xl">{{ $user->bio }}</p>
                        @else
                            <p class="text-gray-500 italic mb-6">Belum ada bio</p>
                        @endif

                        {{-- Stats --}}
                        <div class="flex flex-wrap gap-6 justify-center md:justify-start mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-text">{{ $readingHistories->total() }}</div>
                                <div class="text-sm text-text-second">Manga Dibaca</div>
                            </div>
                            <div class="text-center">   
                                <div class="text-2xl font-bold text-text" id="bookmark-count">0</div>
                                <div class="text-sm text-text-second">Bookmark</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-text">{{ (int) $user->created_at->diffInDays(now()) }}</div>
                                <div class="text-sm text-text-second">Hari Bergabung</div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            {{-- Edit Profile Button --}}
                            <a href="{{ route('profile.edit') }}" 
                            class="group btn-shine relative inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-black font-bold px-6 py-2.5 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-amber-500/30 overflow-hidden">
                                <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-amber-400 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span class="relative z-10">Edit Profile</span>
                            </a>
                            
                            {{-- History Button --}}
                            <a href="{{ route('history.index') }}" 
                            class="group btn-shine relative inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-bold px-6 py-2.5 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-gray-700/50 overflow-hidden">
                                <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-gray-700 to-gray-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:rotate-[360deg]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="relative z-10">Lihat History</span>
                            </a>

                            {{-- Logout Button --}}
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="group btn-shine relative inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-2.5 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-red-500/40 overflow-hidden">
                                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                    <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="relative z-10">Logout</span>
                                </button>
                            </form>

                            {{-- Admin Panel Button --}}
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.manga.index') }}" 
                                class="group btn-shine relative inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold px-6 py-2.5 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-green-500/40 overflow-hidden">
                                <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-emerald-500 to-green-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"/>
                                </svg>
                                <span class="relative z-10 flex items-center gap-1.5">
                                    Admin Panel
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Reading History --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Terakhir Dibaca</h2>
                    @if($readingHistories->count() > 0)
                        <a href="{{ route('history.index') }}" 
                           class="text-accent hover:text-accent-hover flex gap-2 items-center justify-center text-sm font-semibold">
                            <span class="text-xs sm:text-base">See All</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 sm:h-4 sm:w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>

                @if($readingHistories->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($readingHistories as $history)
                            <div class="group relative">
                                <a href="{{ route('manga.read', [$history->manga->slug, $history->chapter_number]) }}" 
                                   class="block">
                                    <div class="relative aspect-2/3 rounded-lg overflow-hidden bg-gray-800 mb-2">
                                        <img src="{{ asset('storage/manga/' . $history->manga->cover_image) }}" 
                                             alt="{{ $history->manga->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        
                                        {{-- Progress Badge --}}
                                        <div class="absolute bottom-2 left-2 right-2 bg-black/80 backdrop-blur-sm px-2 py-1 rounded text-xs text-white font-semibold">
                                            Ch. {{ $history->chapter_number }}
                                        </div>
                                    </div>
                                    <h3 class="text-white text-sm font-semibold line-clamp-2 mb-1">
                                        {{ $history->manga->title }}
                                    </h3>
                                    <p class="text-text-second text-xs">
                                        {{ $history->last_read_at->diffForHumans() }}
                                    </p>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($readingHistories->hasPages())
                        <div class="mt-6">
                            {{ $readingHistories->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <p class="text-text-second mb-4">Belum ada history bacaan</p>
                        <a href="{{ route('manga.list') }}" 
                           class="inline-block bg-accent hover:bg-accent-hover text-black font-bold px-6 py-2.5 rounded-lg transition-colors">
                            Mulai Baca Manga
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        // Update bookmark count
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bookmarkManager !== 'undefined') {
                document.getElementById('bookmark-count').textContent = bookmarkManager.count();
            }
        });
    </script>
    <style>
        /* Smooth animations */
        button, a {
            position: relative;
            transform-style: preserve-3d;
        }

        /* Ripple effect on click */
        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Add shine effect */
        @keyframes shine {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }

        .btn-shine:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 0.6s;
        }

        /* Pulse animation for admin button */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(34, 197, 94, 0.5);
            }
        }

        .group:has(span:contains("Admin Panel")):hover {
            animation: pulse-glow 2s infinite;
        }
    </style>
</x-layout>