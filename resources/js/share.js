export function initShareFeature() {
    document.addEventListener('DOMContentLoaded', () => {

        const shareButton = document.getElementById('share-button');
        const shareModal = document.getElementById('share-modal');
        const shareStatus = document.getElementById('share-status');
        const shareStatusText = document.getElementById('share-status-text');

        // Jika halaman tidak memiliki tombol share, hentikan
        if (!shareButton || !shareModal) return;

        /** ==========================
         *  HANDLE SHARE BUTTON CLICK
         *  ========================== */
        shareButton.addEventListener('click', async () => {
            const title = shareButton.dataset.mangaTitle;
            const url   = shareButton.dataset.mangaUrl;

            disableButton(shareButton);

            try {
                // Web Share API (mobile)
                if (navigator.share) {
                    await navigator.share({
                        title,
                        text: `Check out this manga: ${title}`,
                        url
                    });

                    showShareStatus('Shared successfully!', 'success');
                } else {
                    openShareModal();
                }
            } catch (error) {
                console.error('Share failed:', error);

                if (error.name === 'AbortError') {
                    showShareStatus('Share cancelled', 'info');
                } else {
                    showShareStatus('Share failed, opening options…', 'error');
                    openShareModal();
                }
            } finally {
                enableButton(shareButton);
            }
        });

        /** ==========================
         *  COPY LINK (GLOBAL)
         *  ========================== */
        window.shareViaCopyLink = async () => {
            const url = shareButton.dataset.mangaUrl;

            try {
                await navigator.clipboard.writeText(url);
                showShareStatus('Link copied to clipboard!', 'success');
                closeShareModal();
            } catch (error) {
                fallbackCopy(url);
                showShareStatus('Link copied!', 'success');
                closeShareModal();
            }
        };

        /** ==========================
         *  MODAL FUNCTIONS
         *  ========================== */
        function openShareModal() {
            shareModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeShareModal() {
            shareModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close on outside click
        shareModal.addEventListener('click', (e) => {
            if (e.target === shareModal) closeShareModal();
        });

        // Close with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !shareModal.classList.contains('hidden')) {
                closeShareModal();
            }
        });

        /** ==========================
         *  STATUS MESSAGE
         *  ========================== */
        function showShareStatus(message, type) {
            const colors = {
                success: 'text-green-400',
                error:   'text-red-400',
                info:    'text-blue-400'
            };

            shareStatusText.textContent = message;
            shareStatusText.className = colors[type] || colors.info;

            shareStatus.classList.remove('hidden');
            setTimeout(() => shareStatus.classList.add('hidden'), 3000);
        }

        /** ==========================
         *  UTILITIES
         *  ========================== */
        function disableButton(btn) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }

        function enableButton(btn) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        // Fallback copy (older browsers)
        function fallbackCopy(text) {
            const temp = document.createElement('textarea');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            temp.remove();
        }
    });
}
