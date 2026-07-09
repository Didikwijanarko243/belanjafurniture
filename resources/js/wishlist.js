/**
 * Tombol wishlist (ikon hati) dipakai di banyak tempat: grid produk, halaman detail.
 * Pakai event delegation di document supaya otomatis nyambung ke kartu produk
 * yang di-render ulang (misal setelah filter AJAX di masa depan).
 */
export function initWishlistButtons() {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.wishlist-toggle');
        if (!btn) return;

        e.preventDefault();
        toggleWishlist(btn);
    });
}

function toggleWishlist(btn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const productId = btn.dataset.productId;

    btn.disabled = true;

    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ product_id: productId }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.success) return;

            applyState(btn, data.inWishlist);
            updateWishlistBadge(data.wishlistCount);
        })
        .catch(() => {
            // Diamkan; ikon tetap di state sebelumnya kalau request gagal.
        })
        .finally(() => {
            btn.disabled = false;
        });
}

function applyState(btn, inWishlist) {
    const icon = btn.querySelector('.wishlist-icon');
    btn.setAttribute('aria-pressed', inWishlist ? 'true' : 'false');

    if (!icon) return;
    icon.setAttribute('fill', inWishlist ? 'var(--color-rust)' : 'none');
    icon.setAttribute('stroke', inWishlist ? 'var(--color-rust)' : 'currentColor');
}

function updateWishlistBadge(count) {
    const badge = document.getElementById('wishlist-count-badge');
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count;
        badge.classList.remove('hidden');
        badge.classList.add('flex');
    } else {
        badge.classList.add('hidden');
        badge.classList.remove('flex');
    }
}
