/**
 * Reader Auto Scroll Module
 * Provides auto-scrolling functionality for manga reading with multiple speed options
 * Only available for logged-in users
 */

const SCROLL_SPEEDS = {
    slow: 2,      // pixels per frame (30fps = ~900px/s)
    normal: 3,    // pixels per frame (30fps = ~1500px/s)
    fast: 6,      // pixels per frame (30fps = ~2400px/s)
    veryFast: 12  // pixels per frame (30fps = ~3600px/s)
};

const FRAME_RATE = 30; // frames per second
const FRAME_INTERVAL = 1000 / FRAME_RATE;

let isScrolling = false;
let scrollInterval = null;
let currentSpeed = SCROLL_SPEEDS.normal;
let lastScrollPosition = 0;
let scrollTimeout = null;
let initialized = false;
let isAutoScrolling = false; // Flag to track if scroll is from auto-scroll

let readerArea = null;
let playButton = null;
let pauseButton = null;
let speedSelect = null;
let autoscrollContainer = null;

function getScrollSpeed() {
    return currentSpeed;
}

function setScrollSpeed(speed) {
    if (SCROLL_SPEEDS[speed]) {
        currentSpeed = SCROLL_SPEEDS[speed];
        if (isScrolling) {
            stopAutoScroll();
            startAutoScroll();
        }
    }
}

function startAutoScroll() {
    if (isScrolling) return;
    
    // Check if user is logged in
    if (!window.authUser) {
        showLoginModal();
        return;
    }
    
    isScrolling = true;
    lastScrollPosition = window.scrollY;
    
    // Update UI - handle both mobile and desktop
    const playButtons = [
        document.getElementById('autoscroll-play'),
        document.getElementById('autoscroll-play-desktop')
    ].filter(Boolean);
    
    const pauseButtons = [
        document.getElementById('autoscroll-pause'),
        document.getElementById('autoscroll-pause-desktop')
    ].filter(Boolean);
    
    playButtons.forEach(btn => btn?.classList.add('hidden'));
    pauseButtons.forEach(btn => btn?.classList.remove('hidden'));
    
    const speedSelects = [
        document.getElementById('autoscroll-speed'),
        document.getElementById('autoscroll-speed-mobile')
    ].filter(Boolean);
    
    speedSelects.forEach(select => {
        if (select) select.disabled = false;
    });
    
    scrollInterval = setInterval(() => {
        const currentPosition = window.scrollY;
        const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
        
        // Check if reached bottom
        if (currentPosition >= maxScroll - 10) {
            stopAutoScroll();
            return;
        }
        
        // Mark as auto-scrolling
        isAutoScrolling = true;
        
        // Smooth scroll
        window.scrollBy({
            top: currentSpeed,
            behavior: 'auto'
        });
        
        // Update last position after a short delay to account for smooth scrolling
        setTimeout(() => {
            lastScrollPosition = window.scrollY;
            isAutoScrolling = false;
        }, 50);
    }, FRAME_INTERVAL);
}

function stopAutoScroll() {
    if (!isScrolling) return;
    
    isScrolling = false;
    
    if (scrollInterval) {
        clearInterval(scrollInterval);
        scrollInterval = null;
    }
    
    // Update UI - handle both mobile and desktop
    const playButtons = [
        document.getElementById('autoscroll-play'),
        document.getElementById('autoscroll-play-desktop')
    ].filter(Boolean);
    
    const pauseButtons = [
        document.getElementById('autoscroll-pause'),
        document.getElementById('autoscroll-pause-desktop')
    ].filter(Boolean);
    
    playButtons.forEach(btn => btn?.classList.remove('hidden'));
    pauseButtons.forEach(btn => btn?.classList.add('hidden'));
    
    const speedSelects = [
        document.getElementById('autoscroll-speed'),
        document.getElementById('autoscroll-speed-mobile')
    ].filter(Boolean);
    
    speedSelects.forEach(select => {
        if (select) select.disabled = false;
    });
}

function toggleAutoScroll() {
    if (isScrolling) {
        stopAutoScroll();
    } else {
        startAutoScroll();
    }
}

function handleSpeedChange(event) {
    const speed = event.target.value;
    setScrollSpeed(speed);
}

function handleManualScroll() {
    if (!isScrolling || isAutoScrolling) return;
    
    const currentPosition = window.scrollY;
    const expectedPosition = lastScrollPosition + currentSpeed;
    const diff = Math.abs(currentPosition - expectedPosition);
    
    // If user scrolled significantly different from expected auto scroll position, stop
    // Allow tolerance for smooth scrolling (check if diff is more than 2x speed)
    if (diff > currentSpeed * 2) {
        stopAutoScroll();
    }
}

function showLoginModal(modalId = 'autoscroll-login-modal') {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeLoginModal(modalId = 'autoscroll-login-modal') {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Expose functions globally for reuse
window.showLoginModal = showLoginModal;
window.closeLoginModal = closeLoginModal;
window.closeAutoscrollLoginModal = () => closeLoginModal('autoscroll-login-modal');

function setupAutoScroll() {
    readerArea = document.getElementById('reader-area');
    if (!readerArea) return;
    
    // Get both mobile and desktop elements
    playButton = document.getElementById('autoscroll-play') || document.getElementById('autoscroll-play-desktop');
    pauseButton = document.getElementById('autoscroll-pause') || document.getElementById('autoscroll-pause-desktop');
    speedSelect = document.getElementById('autoscroll-speed') || document.getElementById('autoscroll-speed-mobile');
    autoscrollContainer = document.getElementById('autoscroll-container') || document.getElementById('autoscroll-container-desktop');
    
    if (!autoscrollContainer) return;
    
    // Check if user is logged in
    const isLoggedIn = window.authUser !== null && window.authUser !== undefined;
    
    // Event listeners
    if (playButton) {
        playButton.addEventListener('click', () => {
            if (!isLoggedIn) {
                showLoginModal();
            } else {
                toggleAutoScroll();
            }
        });
    }
    
    if (pauseButton) {
        pauseButton.addEventListener('click', toggleAutoScroll);
    }
    
    if (speedSelect) {
        speedSelect.addEventListener('change', handleSpeedChange);
    }
    
    // Also handle desktop/mobile duplicate buttons
    const playButtonAlt = document.getElementById('autoscroll-play-desktop') || document.getElementById('autoscroll-play');
    const pauseButtonAlt = document.getElementById('autoscroll-pause-desktop') || document.getElementById('autoscroll-pause');
    const speedSelectAlt = document.getElementById('autoscroll-speed-mobile') || document.getElementById('autoscroll-speed');
    
    if (playButtonAlt && playButtonAlt !== playButton) {
        playButtonAlt.addEventListener('click', () => {
            if (!isLoggedIn) {
                showLoginModal();
            } else {
                toggleAutoScroll();
            }
        });
    }
    
    if (pauseButtonAlt && pauseButtonAlt !== pauseButton) {
        pauseButtonAlt.addEventListener('click', toggleAutoScroll);
    }
    
    if (speedSelectAlt && speedSelectAlt !== speedSelect) {
        speedSelectAlt.addEventListener('change', handleSpeedChange);
    }
    
    // Detect manual scrolling
    let scrollTimer = null;
    
    window.addEventListener('scroll', () => {
        if (!isScrolling) return;
        
        // Clear any existing timer
        if (scrollTimer) {
            clearTimeout(scrollTimer);
        }
        
        // Check after a short delay to allow auto-scroll to complete
        scrollTimer = setTimeout(() => {
            if (isScrolling && !isAutoScrolling) {
                handleManualScroll();
            }
        }, 150);
    }, { passive: true });
    
    // Stop auto scroll when page is hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && isScrolling) {
            stopAutoScroll();
        }
    });
    
    // Stop auto scroll on beforeunload
    window.addEventListener('beforeunload', () => {
        stopAutoScroll();
    });
    
    // Close modal when clicking outside
    const modal = document.getElementById('autoscroll-login-modal');
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeLoginModal();
            }
        });
    }
    
    initialized = true;
}

function initAutoScroll() {
    if (initialized) return;
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupAutoScroll, { once: true });
    } else {
        setupAutoScroll();
    }
}

// Export API
export {
    initAutoScroll,
    startAutoScroll,
    stopAutoScroll,
    toggleAutoScroll,
    setScrollSpeed,
    getScrollSpeed
};

