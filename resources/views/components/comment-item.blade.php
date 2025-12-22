@props(['comment', 'level' => 0, 'manga' => null, 'chapter' => null])

<div class="comment-item {{ $level > 0 ? 'ml-1 sm:ml-2 pl-3 sm:pl-4 border-l-2 border-amber-500/30' : '' }}" data-comment-id="{{ $comment->id }}">
    <div class="flex gap-2 sm:gap-3 p-3 sm:p-4 bg-slate-200/50 dark:bg-gray-800/30 rounded-lg {{ $comment->is_spoiler ? 'border-2 border-red-500/30' : '' }}">
        {{-- Avatar --}}
        <div class="shrink-0">
            <img src="{{ $comment->user->profile_picture_url }}" 
                 alt="{{ $comment->user->name }}"
                 class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gray-700">
        </div>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            {{-- Header --}}
            <div class="flex flex-wrap items-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                <span class="font-semibold text-black dark:text-white text-sm sm:text-base">{{ $comment->user->name }}</span>
                <span class="text-gray-600 dark:text-gray-500 text-[10px] sm:text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                
                @if($comment->is_spoiler)
                    <span class="px-1.5 sm:px-2 py-0.5 bg-red-500/20 text-red-400 text-[10px] sm:text-xs font-bold rounded">
                        SPOILER
                    </span>
                @endif

                @if($comment->created_at != $comment->updated_at)
                    <span class="text-gray-600 dark:text-gray-500 text-[10px] sm:text-xs italic">(diedit)</span>
                @endif
            </div>

            {{-- Comment Text --}}
            <div class="comment-content {{ $comment->is_spoiler ? 'spoiler-hidden' : '' }}">
                <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base whitespace-pre-wrap wrap-break-word leading-relaxed">{{ $comment->content }}</p>
                
                @if($comment->is_spoiler)
                    <button onclick="toggleSpoiler(this)" 
                            class="mt-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 font-semibold">
                        Klik untuk lihat spoiler
                    </button>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2 sm:gap-4 mt-2 sm:mt-3">
                {{-- Like Button --}}
                @auth
                    <button onclick="likeComment({{ $comment->id }})" 
                            class="like-button flex items-center gap-1 text-xs sm:text-sm {{ $comment->isLikedBy(Auth::user()) ? 'text-red-400' : 'text-gray-400' }} hover:text-red-400 transition-colors active:scale-95"
                            data-liked="{{ $comment->isLikedBy(Auth::user()) ? 'true' : 'false' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $comment->isLikedBy(Auth::user()) ? 'fill-current' : '' }}" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="likes-count font-semibold">{{ $comment->likes }}</span>
                    </button>
                @else
                    <div class="flex items-center gap-1 text-xs sm:text-sm text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="font-semibold">{{ $comment->likes }}</span>
                    </div>
                @endauth

                {{-- Reply Button --}}
                @auth
                    @if($level < 3)
                        <button onclick="showReplyForm({{ $comment->id }})" 
                                class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 hover:text-amber-400 transition-colors active:scale-95">
                            Balas
                        </button>
                    @endif
                @endauth

                {{-- Edit/Delete (owner only) --}}
                @auth
                    @if($comment->user_id === Auth::id())
                        <button onclick="showEditForm({{ $comment->id }})" 
                                class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 hover:text-amber-400 transition-colors active:scale-95">
                            Edit
                        </button>
                        
                        <form method="POST" 
                              action="{{ route('comments.destroy', $comment) }}" 
                              class="inline"
                              onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 hover:text-red-400 transition-colors active:scale-95">
                                Hapus
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            {{-- Reply Form (hidden by default) --}}
            @auth
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 sm:mt-4">
                    <form method="POST" action="{{ $chapter ? route('comments.store.chapter', [$manga ?? $comment->manga, $chapter]) : route('comments.store.manga', $manga ?? $comment->manga) }}">
                        @csrfs
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        
                        <textarea name="content" 
                                  rows="2" 
                                  required
                                  placeholder="Tulis balasan..."
                                  class="w-full px-3 sm:px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white text-sm sm:text-base placeholder-gray-500 focus:outline-none focus:border-amber-500 resize-none"></textarea>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mt-2">
                            <label class="flex items-center gap-2 text-xs sm:text-sm text-gray-400">
                                <input type="checkbox" name="is_spoiler" value="1" class="rounded w-4 h-4">
                                <span>Spoiler</span>
                            </label>
                            
                            <div class="flex gap-2">
                                <button type="button" 
                                        onclick="hideReplyForm({{ $comment->id }})"
                                        class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-xs sm:text-sm transition-colors active:scale-95">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-lg text-xs sm:text-sm transition-colors active:scale-95">
                                    Kirim
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth

            {{-- Edit Form (hidden by default) --}}
            @auth
                @if($comment->user_id === Auth::id())
                    <div id="edit-form-{{ $comment->id }}" class="hidden mt-3 sm:mt-4">
                        <form method="POST" action="{{ route('comments.update', $comment) }}">
                            @csrf
                            @method('PUT')
                            
                            <textarea name="content" 
                                      rows="2" 
                                      required
                                      class="w-full px-3 sm:px-4 py-2 bg-slate-300 dark:bg-gray-900 border border-gray-700 rounded-lg text-black dark:text-white text-sm sm:text-base focus:outline-none focus:border-amber-500 resize-none">{{ $comment->content }}</textarea>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mt-2">
                                <label class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <input type="checkbox" name="is_spoiler" value="1" {{ $comment->is_spoiler ? 'checked' : '' }} class="rounded w-4 h-4 accent-amber-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tandai sebagai spoiler
                                    </span>
                                </label>
                                
                                <div class="flex gap-2">
                                    <button type="button" 
                                            onclick="hideEditForm({{ $comment->id }})"
                                            class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-xs sm:text-sm transition-colors active:scale-95">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-lg text-xs sm:text-sm transition-colors active:scale-95">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth

            {{-- Replies --}}
            @if($comment->replies->count() > 0 && $level < 3)
                <div class="mt-3 sm:mt-4 space-y-3 sm:space-y-4">
                    @foreach($comment->replies as $reply)
                        <x-comment-item :comment="$reply" :level="$level + 1" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@once
<style>
    .spoiler-hidden p {
        filter: blur(8px);
        user-select: none;
        cursor: pointer;
    }
    
    .spoiler-revealed p {
        filter: none !important;
    }
</style>

<script>
    function toggleSpoiler(button) {
        const content = button.closest('.comment-content');
        content.classList.remove('spoiler-hidden');
        content.classList.add('spoiler-revealed');
        button.remove();
    }

    function showReplyForm(commentId) {
        document.getElementById('reply-form-' + commentId).classList.remove('hidden');
    }

    function hideReplyForm(commentId) {
        document.getElementById('reply-form-' + commentId).classList.add('hidden');
    }

    function showEditForm(commentId) {
        document.getElementById('edit-form-' + commentId).classList.remove('hidden');
    }

    function hideEditForm(commentId) {
        document.getElementById('edit-form-' + commentId).classList.add('hidden');
    }

    async function likeComment(commentId) {
        try {
            const response = await fetch(`/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            
            const commentEl = document.querySelector(`[data-comment-id="${commentId}"]`);
            const likeButton = commentEl.querySelector('.like-button');
            const likesCount = commentEl.querySelector('.likes-count');
            const heartSvg = likeButton.querySelector('svg');

            if (data.liked) {
                likeButton.classList.remove('text-gray-400');
                likeButton.classList.add('text-red-400');
                heartSvg.classList.add('fill-current');
            } else {
                likeButton.classList.remove('text-red-400');
                likeButton.classList.add('text-gray-400');
                heartSvg.classList.remove('fill-current');
            }

            likesCount.textContent = data.likes;
        } catch (error) {
            console.error('Error liking comment:', error);
        }
    }
</script>
@endonce
