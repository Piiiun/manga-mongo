const STORAGE_KEY = 'mangaBookmarks';
const LEGACY_KEY = 'manga_bookmarks';

function readStorage() {
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            return JSON.parse(stored);
        }

        // Migrate from legacy key if exists
        const legacy = localStorage.getItem(LEGACY_KEY);
        if (legacy) {
            const legacyIds = JSON.parse(legacy);
            const migrated = legacyIds.map((id) => ({ manga_id: id }));
            localStorage.setItem(STORAGE_KEY, JSON.stringify(migrated));
            localStorage.removeItem(LEGACY_KEY);
            return migrated;
        }
    } catch (error) {
        console.error('Failed to read bookmarks from storage', error);
    }

    return [];
}

function writeStorage(bookmarks) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(bookmarks));
    return bookmarks;
}

export function getBookmarks() {
    return readStorage();
}

export function getBookmarkIds() {
    return getBookmarks().map((item) => item.manga_id);
}

export function addBookmark(mangaId, meta = {}) {
    let bookmarks = readStorage();

    if (!bookmarks.some((item) => item.manga_id === mangaId)) {
        bookmarks.push({ manga_id: mangaId, ...meta });
        writeStorage(bookmarks);
    }

    return bookmarks;
}

export function removeBookmark(mangaId) {
    const bookmarks = readStorage().filter((item) => item.manga_id !== mangaId);
    writeStorage(bookmarks);
    return bookmarks;
}

export function toggleBookmark(mangaId) {
    const exists = getBookmarkIds().includes(mangaId);
    return exists ? removeBookmark(mangaId) : addBookmark(mangaId);
}

export function clearBookmarks() {
    localStorage.removeItem(STORAGE_KEY);
}

