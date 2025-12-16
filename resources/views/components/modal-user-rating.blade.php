@props(['manga'])
{{-- Ratings Modal --}}
<div id="ratings-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">User Ratings</h3>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-4xl font-bold text-accent-hover">{{ $manga->average_rating ?? 0 }}</span>
                                <div>
                                    <div class="flex">
                                        @for($i = 1; $i <= 10; $i++)
                                            <svg class="w-4 h-4 {{ $i <= ($manga->average_rating ?? 0) ? 'text-accent-hover fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-text-second text-xs">{{ $manga->total_ratings }} ratings</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="closeRatings()" class="text-text-second hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4 max-h-[500px] overflow-y-auto">
                    @forelse($manga->ratings()->with('user')->latest()->take(20)->get() as $rating)
                        <div class="p-4 bg-gray-800/50 rounded-lg">
                            <div class="flex items-start gap-3 mb-3">
                                <img src="{{ $rating->user->profile_picture_url }}" 
                                     alt="{{ $rating->user->name }}"
                                     class="w-10 h-10 rounded-full border-2 border-gray-700">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-white font-semibold">{{ $rating->user->name }}</p>
                                        <div class="flex items-center gap-1">
                                            <span class="text-accent-hover font-bold">{{ $rating->rating }}</span>
                                            <svg class="w-5 h-5 text-accent-hover fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-text-second text-xs">{{ $rating->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if($rating->review)
                                <p class="text-gray-300 text-sm">{{ $rating->review }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-text-second text-center py-8">Belum ada rating</p>
                    @endforelse
                </div>
                
                @if($manga->total_ratings > 20)
                    <p class="text-text-second text-center mt-4 text-sm">
                        Menampilkan 20 dari {{ $manga->total_ratings }} ratings
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function showRatings() {
        document.getElementById('ratings-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRatings() {
        document.getElementById('ratings-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>