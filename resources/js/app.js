import './bootstrap';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import { togglePassword } from './togglePassword';
window.togglePassword = togglePassword;

import { initShareFeature } from './share';
initShareFeature();

import { initBookmarkFeature } from './bookmark';
initBookmarkFeature();

import { initReaderToggle } from './reader-toggle';
initReaderToggle();

import { initAutoScroll } from './reader-autoscroll';
initAutoScroll();

import { initReader } from './reader';
initReader();

// Expose bookmark helpers for the bookmark page
import * as bookmarkLocal from './bookmark/local';
import { fetchUserBookmarks, toggleUserBookmark } from './bookmark/user';
window.bookmarkLocal = bookmarkLocal;
window.fetchUserBookmarks = fetchUserBookmarks;
window.toggleUserBookmark = toggleUserBookmark;



document.addEventListener('DOMContentLoaded', () => {
    const heroSwiperEl = document.querySelector('.hero-swiper');
    if (heroSwiperEl) {
        new Swiper(heroSwiperEl, {
            modules: [Navigation, Pagination, Autoplay],
            loop: true,
            speed: 600,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
});
