const INTERACTIVE_SELECTOR = 'button, a, input, select, textarea';
const NON_TOGGLE_SELECTOR = '#comments-section';
const DEBOUNCE_MS = 150;

let readerArea = null;
let readerTopbar = null;
let readerBottombar = null;
let isHidden = false;
let debounceLock = false;
let initialized = false;

function setUiVisibility(hidden) {
    if (!readerArea) return;
    if (hidden) {
        readerArea.classList.add('reader-ui-hidden');
    } else {
        readerArea.classList.remove('reader-ui-hidden');
    }
    isHidden = hidden;
}

function hideUi() {
    setUiVisibility(true);
}

function showUi() {
    setUiVisibility(false);
}

function toggleUi() {
    setUiVisibility(!isHidden);
}

function requestToggle() {
    if (debounceLock) return;
    debounceLock = true;
    toggleUi();
    setTimeout(() => {
        debounceLock = false;
    }, DEBOUNCE_MS);
}

function handleAreaClick(event) {
    const target = event.target;
    if (target.closest(INTERACTIVE_SELECTOR)) return;
    if (NON_TOGGLE_SELECTOR && target.closest(NON_TOGGLE_SELECTOR)) return;
    requestToggle();
}

function handleKeydown(event) {
    if (!readerArea) return;
    const target = event.target;
    const isTypingContext = target && (target.closest(INTERACTIVE_SELECTOR) || target.isContentEditable);
    if (isTypingContext) return;
    if (event.key === 'k' || event.key === 'K') {
        event.preventDefault();
        requestToggle();
    } else if (event.key === 'Escape') {
        showUi();
    }
}

function stopPropagation(event) {
    event.stopPropagation();
}

function setupToggle() {
    readerArea = document.getElementById('reader-area');
    if (!readerArea) return;
    readerTopbar = document.getElementById('reader-topbar');
    readerBottombar = document.getElementById('reader-bottombar');

    readerArea.addEventListener('click', handleAreaClick);
    readerTopbar?.addEventListener('click', stopPropagation);
    readerBottombar?.addEventListener('click', stopPropagation);
    document.addEventListener('keydown', handleKeydown);

    initialized = true;
}

function initReaderToggle() {
    if (initialized) return;
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupToggle, { once: true });
    } else {
        setupToggle();
    }
}

export { initReaderToggle, showUi, hideUi, toggleUi };

