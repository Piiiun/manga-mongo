// public/js/bookmark-ui.js

/**
 * Initialize semua tombol bookmark di halaman
 * Panggil fungsi ini setelah DOM loaded atau setelah content di-load via AJAX
 */
function initializeBookmarkButtons() {
    updateAllBookmarkUI();
    
    // Remove existing listeners (prevent duplicate)
    document.querySelectorAll('.bookmark-toggle').forEach(btn => {
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
    });
    
    // Attach event listeners
    document.querySelectorAll('.bookmark-toggle').forEach(btn => {
        btn.addEventListener('click', handleBookmarkClick);
    });
}

/**
 * Handle bookmark button click
 */
function handleBookmarkClick(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const btn = e.currentTarget;
    const mangaId = parseInt(btn.dataset.mangaId);
    
    if (typeof bookmarkManager === 'undefined') {
        console.error('BookmarkManager not loaded');
        showAlert('Bookmark system tidak tersedia');
        return;
    }
    
    const isBookmarked = bookmarkManager.toggle(mangaId);
    updateBookmarkUI(btn, isBookmarked);
    updateNavbarCounter();
    showBookmarkNotification(isBookmarked);
}

/**
 * Update UI untuk semua bookmark buttons
 */
function updateAllBookmarkUI() {
    if (typeof bookmarkManager === 'undefined') return;
    
    document.querySelectorAll('.bookmark-toggle').forEach(btn => {
        const mangaId = parseInt(btn.dataset.mangaId);
        const isBookmarked = bookmarkManager.isBookmarked(mangaId);
        updateBookmarkUI(btn, isBookmarked);
    });
}

/**
 * Update UI untuk single bookmark button
 */
function updateBookmarkUI(btn, isBookmarked) {
    const outlineIcon = btn.querySelector('.bookmark-icon-outline');
    const filledIcon = btn.querySelector('.bookmark-icon-filled');
    const text = btn.querySelector('.bookmark-text');
    
    if (isBookmarked) {
        // State: Bookmarked
        outlineIcon?.classList.add('hidden');
        filledIcon?.classList.remove('hidden');
        
        // Update styling (sesuaikan dengan design Anda)
        btn.classList.add('bookmarked'); // Custom class untuk styling
        
        if (text) text.textContent = 'Bookmarked';
        btn.title = 'Hapus dari Bookmark';
    } else {
        // State: Not Bookmarked
        outlineIcon?.classList.remove('hidden');
        filledIcon?.classList.add('hidden');
        
        // Update styling
        btn.classList.remove('bookmarked');
        
        if (text) text.textContent = 'Bookmark';
        btn.title = 'Tambah ke Bookmark';
    }
}

/**
 * Update navbar bookmark counter
 */
function updateNavbarCounter() {
    if (typeof bookmarkManager === 'undefined') return;
    
    const count = bookmarkManager.count();
    const navCounter = document.getElementById('nav-bookmark-count');
    if (navCounter) navCounter.textContent = count;
}

/**
 * Show notification toast
 */
function showBookmarkNotification(isBookmarked) {
    const message = isBookmarked ? 'Ditambahkan ke bookmark ✓' : 'Dihapus dari bookmark';
    const bgColor = isBookmarked ? 'bg-green-500' : 'bg-red-500';
    
    const notification = document.createElement('div');
    notification.className = `fixed bottom-20 md:bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300`;
    notification.style.opacity = '0';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => notification.style.opacity = '1', 10);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 2000);
}

/**
 * Show alert (fallback)
 */
function showAlert(message) {
    alert(message);
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    initializeBookmarkButtons();
});

// Listen for storage changes (sync across tabs)
window.addEventListener('storage', function(e) {
    if (e.key === 'manga_bookmarks') {
        updateAllBookmarkUI();
        updateNavbarCounter();
    }
});

// Export untuk digunakan di luar
window.initializeBookmarkButtons = initializeBookmarkButtons;
window.updateAllBookmarkUI = updateAllBookmarkUI;