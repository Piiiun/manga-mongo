@props(['comments', 'manga', 'chapter', 'chapterCommentsCount'])

<div id="comments-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" onclick="window.closeCommentsModal()"></div>

    {{-- Modal Panel --}}
    <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="relative bg-slate-100 dark:bg-gray-900 border border-gray-700 rounded-t-2xl sm:rounded-2xl shadow-2xl w-full sm:max-w-2xl max-h-[90vh] sm:max-h-[85vh] flex flex-col">
            {{-- Header --}}
            <div class="flex items-center justify-between gap-3 p-4 sm:p-5 border-b border-gray-700 shrink-0">
                <div class="flex items-center gap-2 min-w-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <div class="min-w-0">
                        <h2 class="text-base sm:text-lg font-bold text-black dark:text-white truncate">Diskusi Chapter {{ $chapter->number }}</h2>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $chapterCommentsCount }} komentar</span>
                    </div>
                </div>
                <button onclick="window.closeCommentsModal()" class="shrink-0 p-2 hover:bg-gray-300 dark:hover:bg-gray-800 rounded-lg text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Scrollable Body --}}
            <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-4">

                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Comment Form --}}
                @auth
                    <form method="POST" action="{{ route('comments.store.chapter', [$manga->slug, $chapter->number]) }}" class="bg-slate-200 dark:bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                        @csrf
                        <input type="hidden" name="chapter_number" value="{{ $chapter->number }}">
                        <textarea name="content"
                                rows="3"
                                required
                                maxlength="1000"
                                placeholder="Bagaimana pendapat kamu tentang chapter ini?"
                                class="w-full px-4 py-3 bg-gray-300 dark:bg-gray-800 border border-gray-700 rounded-lg text-black dark:text-white placeholder-gray-600 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"></textarea>
                        <div class="flex items-center justify-between mt-3">
                            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                                <input type="checkbox" name="is_spoiler" value="1" class="rounded border-gray-600 text-amber-500 focus:ring-amber-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Spoiler
                                </span>
                            </label>
                            <button type="submit"
                                    class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-black font-bold rounded-lg transition-colors text-sm">
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-slate-200 dark:bg-gray-800/50 border border-gray-700 rounded-lg p-6 text-center">
                        <svg class="w-10 h-10 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 mb-3 text-sm">Login untuk berkomentar</p>
                        <a href="{{ route('login') }}"
                           class="inline-block bg-amber-500 hover:bg-amber-600 text-black font-bold px-5 py-2 rounded-lg transition-colors text-sm">
                            Login Sekarang
                        </a>
                    </div>
                @endauth

                {{-- Sort Options --}}
                @if($comments->count() > 0)
                    <div class="flex items-center justify-between pb-3 border-b border-gray-700">
                        <h3 class="text-sm font-semibold text-black dark:text-white">
                            Semua Komentar ({{ $comments->count() }})
                        </h3>
                        <select class="bg-slate-200 dark:bg-gray-800 border border-gray-700 text-black dark:text-white rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                                onchange="window.sortComments && window.sortComments(this.value)">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="most-liked">Paling Disukai</option>
                        </select>
                    </div>

                    <div id="comments-container" class="space-y-3">
                        @foreach($comments as $comment)
                            <x-comment-item :comment="$comment" :manga="$manga" />
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <svg class="w-14 h-14 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Belum ada komentar</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm">Jadilah yang pertama berkomentar!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    window.openCommentsModal = function() {
        const modal = document.getElementById('comments-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeCommentsModal = function() {
        const modal = document.getElementById('comments-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeCommentsModal();
        }
    });
</script>
