import { getBookmarkIds, addBookmark, removeBookmark } from './local';
import { syncLocalBookmarks } from './sync';
import { fetchUserBookmarks, toggleUserBookmark } from './user';

function updateBookmarkUI(button, isBookmarked) {
    const outlineIcon = button.querySelector('.bookmark-icon-outline');
    const filledIcon = button.querySelector('.bookmark-icon-filled');
    const text = button.querySelector('.bookmark-text');

    outlineIcon?.classList.toggle('hidden', isBookmarked);
    filledIcon?.classList.toggle('hidden', !isBookmarked);
    button.classList.toggle('bookmarked', isBookmarked);
    if (text) {
        text.textContent = isBookmarked ? 'Bookmarked' : 'Bookmark';
    }
}

function updateNavCounters(count) {
    const navCounter = document.getElementById('nav-bookmark-count');
    if (navCounter) navCounter.textContent = count;

    const mobileCounter = document.getElementById('mobile-bookmark-count');
    if (mobileCounter) {
        mobileCounter.textContent = count;
        mobileCounter.classList.toggle('hidden', count === 0);
    }
}

export function initBookmarkFeature() {
    document.addEventListener('DOMContentLoaded', async () => {
        const buttons = Array.from(document.querySelectorAll('.bookmark-toggle'));

        const isLoggedIn = Boolean(window.authUser);
        let bookmarkIds = [];

        try {
            if (isLoggedIn) {
                const synced = await syncLocalBookmarks();
                bookmarkIds = (synced.bookmarks && synced.bookmarks.length
                    ? synced.bookmarks
                    : await fetchUserBookmarks()
                ).map((id) => Number(id));
            } else {
                bookmarkIds = getBookmarkIds();
            }
        } catch (error) {
            console.error('Failed to prepare bookmarks', error);
        }

        updateNavCounters(bookmarkIds.length);

        if (!buttons.length) return;

        buttons.forEach((button) => {
            const mangaId = Number(button.dataset.mangaId);
            if (Number.isNaN(mangaId)) return;

            updateBookmarkUI(button, bookmarkIds.includes(mangaId));

            button.addEventListener('click', async (event) => {
                event.preventDefault();
                if (button.dataset.loading) return;

                button.dataset.loading = 'true';
                button.classList.add('opacity-75');

                try {
                    if (isLoggedIn) {
                        const result = await toggleUserBookmark(mangaId);
                        bookmarkIds = result.bookmarked
                            ? [...new Set([...bookmarkIds, mangaId])]
                            : bookmarkIds.filter((id) => id !== mangaId);
                    } else {
                        const exists = bookmarkIds.includes(mangaId);
                        bookmarkIds = exists ? removeBookmark(mangaId).map((b) => Number(b.manga_id)) : addBookmark(mangaId).map((b) => Number(b.manga_id));
                    }

                    updateBookmarkUI(button, bookmarkIds.includes(mangaId));
                    updateNavCounters(bookmarkIds.length);
                } catch (error) {
                    console.error('Bookmark toggle failed', error);
                    alert('Gagal mengubah bookmark, coba lagi.');
                } finally {
                    delete button.dataset.loading;
                    button.classList.remove('opacity-75');
                }
            });
        });
    });
}

