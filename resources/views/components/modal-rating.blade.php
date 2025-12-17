@props(['manga'])
{{-- Rating Modal --}}
@auth
<div id="rating-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-8 max-w-2xl w-full">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white">Rate {{ $manga->title }}</h3>
                <button onclick="closeRatingModal()" class="text-text-second hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            @php
                $userRating = Auth::user()->getRatingFor($manga->id);
            @endphp

            <form method="POST" action="{{ route('rating.store', $manga) }}">
                @csrf
                
                {{-- Star Rating --}}
                <div class="mb-6">
                    <label class="block text-gray-300 font-semibold mb-3">Your Rating</label>
                    <div class="flex items-center gap-2">
                        <div class="flex gap-1" id="star-rating">
                            @for($i = 1; $i <= 10; $i++)
                                <button type="button" 
                                        data-rating="{{ $i }}"
                                        onclick="setRating({{ $i }})"
                                        class="star-btn transition-all hover:scale-110">
                                    <svg class="w-10 h-10 {{ $userRating && $userRating->rating >= $i ? 'text-rating fill-current' : 'text-gray-600' }}" 
                                         viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        <span id="rating-value" class="text-3xl font-bold text-white ml-2">
                            {{ $userRating ? $userRating->rating : 0 }}/10
                        </span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ $userRating ? $userRating->rating : 0 }}" required>
                    <p class="text-text-second text-sm mt-2">1 = Terrible, 10 = Masterpiece</p>
                </div>

                {{-- Review (Optional) --}}
                <div class="mb-6">
                    <label class="block text-gray-300 font-semibold mb-2">
                        Review (Optional)
                    </label>
                    <textarea name="review" 
                              rows="4"
                              placeholder="Bagikan pendapat kamu tentang manga ini..."
                              class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-accent resize-none">{{ $userRating ? $userRating->review : '' }}</textarea>
                    <p class="text-text-second text-sm mt-1">Max 1000 karakter</p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-accent hover:bg-accent-hover text-text font-bold px-6 py-3 rounded-lg transition-colors">
                        {{ $userRating ? 'Update Rating' : 'Submit Rating' }}
                    </button>
                    
                    @if($userRating)
                        <button type="button" 
                                onclick="if(confirm('Hapus rating kamu?')) document.getElementById('delete-rating-form').submit()"
                                class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-colors">
                            Delete
                        </button>
                    @endif
                    
                    <button type="button" 
                            onclick="closeRatingModal()"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
            </form>

            @if($userRating)
                <form id="delete-rating-form" method="POST" action="{{ route('rating.destroy', $manga) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    function openRatingModal() {
        document.getElementById('rating-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRatingModal() {
        document.getElementById('rating-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function setRating(rating) {
        document.getElementById('rating-input').value = rating;
        document.getElementById('rating-value').textContent = rating + '/10';
        
        // Update stars
        const stars = document.querySelectorAll('.star-btn svg');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('text-rating', 'fill-current');
                star.classList.remove('text-gray-600');
            } else {
                star.classList.remove('text-rating', 'fill-current');
                star.classList.add('text-gray-600');
            }
        });
    }

    // Star hover effect
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            const stars = document.querySelectorAll('.star-btn svg');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('text-rating', 'fill-current');
                    star.classList.remove('text-gray-600');
                }
            });
        });
    });

    document.getElementById('star-rating').addEventListener('mouseleave', function() {
        const currentRating = parseInt(document.getElementById('rating-input').value);
        const stars = document.querySelectorAll('.star-btn svg');
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.add('text-rating', 'fill-current');
                star.classList.remove('text-gray-600');
            } else {
                star.classList.remove('text-rating', 'fill-current');
                star.classList.add('text-gray-600');
            }
        });
    });

    // Close on click outside
    document.getElementById('rating-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeRatingModal();
    });
</script>
@endauth