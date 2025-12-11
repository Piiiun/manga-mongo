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
