// resources/js/modules/review.js

/**
 * Inisialisasi semua widget "Beri Ulasan" di halaman (toggle form + star rating).
 * Dipanggil sekali dari app.js setelah DOMContentLoaded.
 */
export function initReviewForms() {
    const items = document.querySelectorAll('[data-review-item]');

    items.forEach((item) => {
        initToggle(item);
        initStarRating(item);
        initFormValidation(item);
    });
}

function initToggle(item) {
    const toggleBtn = item.querySelector('[data-review-toggle]');
    const form = item.querySelector('[data-review-form]');

    if (!toggleBtn || !form) return;

    toggleBtn.addEventListener('click', () => {
        form.classList.toggle('hidden');
        toggleBtn.textContent = form.classList.contains('hidden') ? 'Beri Ulasan' : 'Tutup';
    });
}

function initStarRating(item) {
    const stars = item.querySelectorAll('[data-star]');
    const ratingInput = item.querySelector('[data-rating-input]');

    if (!stars.length || !ratingInput) return;

    const paint = (value) => {
        stars.forEach((star) => {
            const starValue = Number(star.dataset.star);
            star.classList.toggle('text-brass', starValue <= value);
            star.classList.toggle('text-walnut/20', starValue > value);
        });
    };

    stars.forEach((star) => {
        const value = Number(star.dataset.star);

        star.addEventListener('click', () => {
            ratingInput.value = value;
            paint(value);
        });

        star.addEventListener('mouseenter', () => paint(value));
        star.addEventListener('mouseleave', () => paint(Number(ratingInput.value)));
    });
}

function initFormValidation(item) {
    const form = item.querySelector('[data-review-form]');
    const ratingInput = item.querySelector('[data-rating-input]');
    const errorEl = item.querySelector('[data-rating-error]');

    if (!form || !ratingInput) return;

    form.addEventListener('submit', (e) => {
        if (Number(ratingInput.value) < 1) {
            e.preventDefault();
            errorEl?.classList.remove('hidden');
            return;
        }
        errorEl?.classList.add('hidden');
    });
}