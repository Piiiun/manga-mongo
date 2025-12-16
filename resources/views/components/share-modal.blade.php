@props(['manga'])

<div id="share-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="share-modal-title">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 id="share-modal-title" class="text-lg font-bold text-white">Share Manga</h3>
                <button onclick="closeShareModal()" class="text-text-second hover:text-white transition-colors" aria-label="Close share modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="space-y-3">
                <button onclick="shareViaCopyLink()" class="share-option w-full bg-gray-800 hover:bg-gray-700 text-white rounded-lg px-4 py-3 flex items-center gap-3 transition-colors" aria-label="Copy link to clipboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copy Link
                </button>

                <a href="https://twitter.com/intent/tweet?text={{ urlencode($manga->title) }}&url={{ urlencode(route('manga.detail', $manga->slug)) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-option block w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-3 flex items-center gap-3 transition-colors"
                   aria-label="Share on Twitter">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Share on Twitter
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('manga.detail', $manga->slug)) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-option block w-full bg-blue-800 hover:bg-blue-900 text-white rounded-lg px-4 py-3 flex items-center gap-3 transition-colors"
                   aria-label="Share on Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Share on Facebook
                </a>
            </div>

            <div id="share-status" class="mt-4 text-sm text-center hidden">
                <span id="share-status-text" class="text-green-400"></span>
            </div>
        </div>
    </div>