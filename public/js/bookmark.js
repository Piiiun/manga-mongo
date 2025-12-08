class BookmarkManager {
    constructor() {
        this.storageKey = 'manga_bookmarks';
    }
    
    // Ambil semua bookmark IDs
    getAll() {
        const bookmarks = localStorage.getItem(this.storageKey);
        return bookmarks ? JSON.parse(bookmarks) : [];
    }
    
    // Cek apakah manga sudah di-bookmark
    isBookmarked(mangaId) {
        const bookmarks = this.getAll();
        return bookmarks.includes(mangaId);
    }
    
    // Toggle bookmark (add/remove)
    toggle(mangaId) {
        let bookmarks = this.getAll();
        
        if (this.isBookmarked(mangaId)) {
            // Remove
            bookmarks = bookmarks.filter(id => id !== mangaId);
            localStorage.setItem(this.storageKey, JSON.stringify(bookmarks));
            return false; // tidak di-bookmark
        } else {
            // Add
            bookmarks.push(mangaId);
            localStorage.setItem(this.storageKey, JSON.stringify(bookmarks));
            return true; // di-bookmark
        }
    }
    
    // Hapus bookmark
    remove(mangaId) {
        let bookmarks = this.getAll();
        bookmarks = bookmarks.filter(id => id !== mangaId);
        localStorage.setItem(this.storageKey, JSON.stringify(bookmarks));
    }
    
    // Hitung jumlah bookmark
    count() {
        return this.getAll().length;
    }
    
    // Clear semua bookmark
    clear() {
        localStorage.removeItem(this.storageKey);
    }
}

// Initialize global instance
const bookmarkManager = new BookmarkManager();