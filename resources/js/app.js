//
import { initProductDetailPage } from './product-detail'; 
import { initWishlistButtons } from './wishlist';
import { initMegaMenu } from './mega-menu';
import { initReviewForms } from './review.js';

import { initAdminReviews } from './admin-reviews.js';


initMegaMenu();
initProductDetailPage();
initWishlistButtons();
initReviewForms();
initAdminReviews();

const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const iconOpen = document.getElementById('icon-menu-open');
const iconClose = document.getElementById('icon-menu-close');

if (mobileMenuToggle && mobileMenu) {
    mobileMenuToggle.addEventListener('click', () => {
        const isOpen = !mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        mobileMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    });
}

const searchToggle = document.getElementById('search-toggle');
const searchBox = document.getElementById('search-box');

if (searchToggle && searchBox) {
    searchToggle.addEventListener('click', () => {
        searchBox.classList.toggle('hidden');
        if (!searchBox.classList.contains('hidden')) {
            searchBox.querySelector('input').focus();
        }
    });
}