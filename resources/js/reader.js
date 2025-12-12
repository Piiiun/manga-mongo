/**
 * Reader Page Module
 * Handles all reader-specific functionality: timer, page tracking, webtoon mode, etc.
 */

// Reading Timer
let readingSeconds = 0;
let timerInterval = null;

function startReadingTimer() {
    if (timerInterval) return;
    
    timerInterval = setInterval(() => {
        readingSeconds++;
        const minutes = Math.floor(readingSeconds / 60);
        const seconds = readingSeconds % 60;
        const timeElement = document.getElementById('reading-time');
        if (timeElement) {
            timeElement.textContent = `${minutes}m ${seconds}s`;
        }
    }, 1000);
}

function stopReadingTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

// Current Page Tracker dengan Intersection Observer
let pageObserver = null;
let currentPageElement = null;
let allPages = [];
let scrollListenerAdded = false;
let resizeListenerAdded = false;

function updateCurrentPage() {
    if (!currentPageElement || allPages.length === 0) return;
    
    // Find the page that is most visible in the viewport
    let maxVisibleRatio = 0;
    let mostVisiblePage = null;
    
    allPages.forEach(page => {
        const rect = page.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        
        // Calculate visible height
        const visibleTop = Math.max(0, -rect.top);
        const visibleBottom = Math.min(rect.height, viewportHeight - rect.top);
        const visibleHeight = Math.max(0, visibleBottom - visibleTop);
        const visibleRatio = visibleHeight / rect.height;
        
        // Consider page as "current" if at least 30% is visible and it's in the upper portion of viewport
        if (visibleRatio > maxVisibleRatio && rect.top < viewportHeight * 0.7) {
            maxVisibleRatio = visibleRatio;
            mostVisiblePage = page;
        }
    });
    
    if (mostVisiblePage && maxVisibleRatio > 0.3) {
        const pageNumber = mostVisiblePage.getAttribute('data-page');
        if (currentPageElement && pageNumber) {
            currentPageElement.textContent = pageNumber;
        }
    }
}

function initPageTracker() {
    currentPageElement = document.getElementById('current-page');
    if (!currentPageElement) return;
    
    allPages = Array.from(document.querySelectorAll('.manga-page'));
    if (allPages.length === 0) return;
    
    // Calculate rootMargin based on viewport and bottom bar
    const isDesktop = window.innerWidth >= 640; // sm breakpoint
    const bottomBarHeight = isDesktop ? 80 : 0; // Approximate bottom bar height on desktop
    const topBarHeight = 100; // Top bar height
    
    // Use more lenient threshold and rootMargin for better detection
    const observerOptions = {
        threshold: [0, 0.1, 0.3, 0.5, 0.7, 1.0], // Multiple thresholds for better detection
        rootMargin: `-${topBarHeight}px 0px -${bottomBarHeight + 20}px 0px`
    };
    
    pageObserver = new IntersectionObserver((entries) => {
        // Find the entry with highest intersection ratio that's intersecting
        let bestEntry = null;
        let bestRatio = 0;
        
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.intersectionRatio > bestRatio) {
                bestRatio = entry.intersectionRatio;
                bestEntry = entry;
            }
        });
        
        if (bestEntry && bestRatio > 0.1) {
            const pageNumber = bestEntry.target.getAttribute('data-page');
            if (currentPageElement && pageNumber) {
                currentPageElement.textContent = pageNumber;
            }
        }
    }, observerOptions);
    
    // Observe all pages
    allPages.forEach(page => {
        pageObserver.observe(page);
    });
    
    // Fallback: Update on scroll for better reliability (only add once)
    if (!scrollListenerAdded) {
        let scrollTimeout = null;
        window.addEventListener('scroll', () => {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(() => {
                updateCurrentPage();
            }, 100);
        }, { passive: true });
        scrollListenerAdded = true;
    }
    
    // Initial update
    setTimeout(() => {
        updateCurrentPage();
    }, 500);
    
    // Update on resize (viewport changes) - just recalculate (only add once)
    if (!resizeListenerAdded) {
        let resizeTimeout = null;
        window.addEventListener('resize', () => {
            if (resizeTimeout) {
                clearTimeout(resizeTimeout);
            }
            resizeTimeout = setTimeout(() => {
                // Just update current page, observer will handle the rest
                updateCurrentPage();
            }, 300);
        });
        resizeListenerAdded = true;
    }
}

// Webtoon Mode Toggle
function initWebtoonMode() {
    const webtoonCheckbox = document.getElementById('webtoon-mode');
    const mangaPages = document.getElementById('manga-pages');
    
    if (!webtoonCheckbox || !mangaPages) return;
    
    webtoonCheckbox.addEventListener('change', function() {
        if (this.checked) {
            mangaPages.classList.remove('space-y-4');
            mangaPages.classList.add('space-y-0');
        } else {
            mangaPages.classList.remove('space-y-0');
            mangaPages.classList.add('space-y-4');
        }
    });
}


// Scroll to Top Button
function initScrollToTop() {
    const scrollButton = document.getElementById('scroll-to-top');
    if (!scrollButton) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            scrollButton.classList.remove('hidden');
        } else {
            scrollButton.classList.add('hidden');
        }
    });
    
    scrollButton.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Fullscreen Toggle
function initFullscreen() {
    const fullscreenButton = document.querySelector('[title="Fullscreen"]');
    if (!fullscreenButton) return;
    
    fullscreenButton.addEventListener('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    });
}

// Keyboard Navigation
function initKeyboardNavigation() {
    document.addEventListener('keydown', function(e) {
        // Skip if user is typing in input/textarea
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.isContentEditable) {
            return;
        }
        
        // Left Arrow - Previous Chapter
        if (e.key === 'ArrowLeft') {
            const prevLinks = document.querySelectorAll('.reader-bar a');
            const prevLink = Array.from(prevLinks).find(link => 
                link.textContent.includes('Chapter') && 
                !link.classList.contains('cursor-not-allowed') &&
                !link.textContent.includes('Info')
            );
            if (prevLink) {
                e.preventDefault();
                prevLink.click();
            }
        }
        // Right Arrow - Next Chapter
        if (e.key === 'ArrowRight') {
            const nextLinks = document.querySelectorAll('.reader-bar a');
            const nextLink = Array.from(nextLinks).reverse().find(link => 
                link.textContent.includes('Chapter') && 
                !link.classList.contains('cursor-not-allowed') &&
                !link.textContent.includes('Info')
            );
            if (nextLink) {
                e.preventDefault();
                nextLink.click();
            }
        }
    });
}

// Comment Sorting
function initCommentSorting() {
    window.sortComments = function(sortType) {
        const container = document.getElementById('comments-container');
        if (!container) return;
        
        const comments = Array.from(container.children);
        
        comments.sort((a, b) => {
            if (sortType === 'newest') {
                return 0; // Already sorted by default
            } else if (sortType === 'oldest') {
                return Array.from(container.children).indexOf(b) - Array.from(container.children).indexOf(a);
            } else if (sortType === 'most-liked') {
                const likesA = parseInt(a.querySelector('.likes-count')?.textContent || 0);
                const likesB = parseInt(b.querySelector('.likes-count')?.textContent || 0);
                return likesB - likesA;
            }
            return 0;
        });
        
        container.innerHTML = '';
        comments.forEach(comment => container.appendChild(comment));
    };
    
    window.scrollToComments = function() {
        const commentsSection = document.querySelector('#comments-section');
        if (commentsSection) {
            commentsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        }
    };
}

// Chapter List Toggle - Make it global
function initChapterList() {
    const modal = document.getElementById('chapter-list-modal');
    if (!modal) return;
    
    window.toggleChapterList = function() {
        modal.classList.toggle('hidden');
    };
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            window.toggleChapterList();
        }
    });
}

// Save reading progress
function initReadingProgress() {
    window.addEventListener('beforeunload', function() {
        // Kirim data reading progress ke server (optional)
        console.log('Reading time:', readingSeconds, 'seconds');
    });
}

// Initialize all reader features
function initReader() {
    // Check if we're on reader page
    const readerArea = document.getElementById('reader-area');
    if (!readerArea) return;
    
    startReadingTimer();
    initPageTracker();
    initWebtoonMode();
    initChapterList();
    initScrollToTop();
    initFullscreen();
    initKeyboardNavigation();
    initCommentSorting();
    initReadingProgress();
}

// Auto-init when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReader);
} else {
    initReader();
}

export {
    startReadingTimer,
    stopReadingTimer,
    initReader
};

