/**
 * Halaman detail produk: galeri gambar, pilih varian, jumlah, dan tombol WhatsApp.
 * Hanya jalan kalau elemen #product-detail ada di halaman.
 */
export function initProductDetailPage() {
    const root = document.getElementById('product-detail');
    if (!root) return;

    initGallery();
    const getSelection = initVariantSelector();
    const getQty = initQuantitySelector();
    initWhatsAppOrder(root, getSelection, getQty);
    initAddToCart(root, getSelection, getQty);
}

function initGallery() {
    const mainImage = document.getElementById('gallery-main-image');
    const thumbs = document.querySelectorAll('.gallery-thumb');
    if (!mainImage || thumbs.length === 0) return;

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            mainImage.src = thumb.dataset.fullSrc;
            thumbs.forEach((t) => t.classList.remove('border-walnut'));
            thumbs.forEach((t) => t.classList.add('border-transparent'));
            thumb.classList.remove('border-transparent');
            thumb.classList.add('border-walnut');
        });
    });
}

/**
 * Mengelola pilihan warna/ukuran, lalu mencocokkannya ke data varian
 * (stok & harga tambahan) yang dicetak server-side di #variant-data.
 * Mengembalikan getter supaya modul lain (WA, keranjang) bisa baca pilihan saat ini.
 */
function initVariantSelector() {
    const dataEl = document.getElementById('variant-data');
    const variants = dataEl ? JSON.parse(dataEl.textContent) : [];

    const colorButtons = document.querySelectorAll('#variant-color-group .variant-option');
    const sizeButtons = document.querySelectorAll('#variant-size-group .variant-option');
    const priceEl = document.getElementById('display-price');
    const stockInfoEl = document.getElementById('variant-stock-info');
    const addToCartBtn = document.getElementById('btn-add-to-cart');
    const basePrice = parseFloat(root().dataset.basePrice || 0);

    let selectedColor = colorButtons[0]?.dataset.variantColor ?? null;
    let selectedSize = sizeButtons[0]?.dataset.variantSize ?? null;

    function root() {
        return document.getElementById('product-detail');
    }

    function findMatch() {
        return variants.find((v) =>
            (selectedColor === null || v.color === selectedColor) &&
            (selectedSize === null || v.size === selectedSize)
        );
    }

    function render() {
        highlight(colorButtons, selectedColor, 'variantColor');
        highlight(sizeButtons, selectedSize, 'variantSize');

        const match = findMatch();
        if (!match) {
            if (stockInfoEl) stockInfoEl.textContent = 'Kombinasi ini tidak tersedia';
            if (addToCartBtn) addToCartBtn.disabled = true;
            return;
        }

        const finalPrice = basePrice + parseFloat(match.additional_price || 0);
        if (priceEl) {
            priceEl.textContent = 'Rp' + finalPrice.toLocaleString('id-ID');
        }
        if (stockInfoEl) {
            stockInfoEl.textContent = match.stock > 0
                ? `Stok tersedia: ${match.stock}`
                : 'Stok habis';
        }
        if (addToCartBtn) {
            addToCartBtn.disabled = match.stock <= 0;
        }
    }

    function highlight(buttons, selectedValue, dataKey) {
        buttons.forEach((btn) => {
            const isActive = btn.dataset[dataKey] === selectedValue;
            btn.classList.toggle('border-walnut', isActive);
            btn.classList.toggle('text-walnut', isActive);
            btn.classList.toggle('border-walnut/20', !isActive);
            btn.classList.toggle('text-ink/70', !isActive);
        });
    }

    colorButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            selectedColor = btn.dataset.variantColor;
            render();
        });
    });

    sizeButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            selectedSize = btn.dataset.variantSize;
            render();
        });
    });

    if (variants.length > 0) render();

    return () => ({ color: selectedColor, size: selectedSize, variant: findMatch() });
}

function initQuantitySelector() {
    const input = document.getElementById('qty-input');
    const decreaseBtn = document.getElementById('qty-decrease');
    const increaseBtn = document.getElementById('qty-increase');
    if (!input) return () => 1;

    decreaseBtn?.addEventListener('click', () => {
        const current = parseInt(input.value, 10) || 1;
        input.value = Math.max(1, current - 1);
    });

    increaseBtn?.addEventListener('click', () => {
        const current = parseInt(input.value, 10) || 1;
        input.value = current + 1;
    });

    return () => parseInt(input.value, 10) || 1;
}

function initWhatsAppOrder(root, getSelection, getQty) {
    const link = document.getElementById('btn-whatsapp-order');
    if (!link) return;

    link.addEventListener('click', (e) => {
        e.preventDefault();

        const productName = root.dataset.productName;
        const whatsappNumber = root.dataset.whatsappNumber;
        const qty = getQty();
        const { color, size } = getSelection();

        let message = `Halo, saya mau tanya/pesan produk berikut:\n\n`;
        message += `*${productName}*\n`;
        if (color) message += `Warna: ${color}\n`;
        if (size) message += `Ukuran: ${size}\n`;
        message += `Jumlah: ${qty}\n`;
        message += `\nLink: ${window.location.href}`;

        const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank', 'noopener');
    });
}

function initAddToCart(root, getSelection, getQty) {
    const btn = document.getElementById('btn-add-to-cart');
    if (!btn) return;

    btn.addEventListener('click', () => {
        const { variant } = getSelection ? getSelection() : { variant: null };
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        const originalLabel = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Menambahkan...';

        fetch('/keranjang/tambah', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                product_id: root.dataset.productId,
                product_variant_id: variant?.id ?? null,
                quantity: getQty(),
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (!data.success) {
                    btn.textContent = 'Gagal, coba lagi';
                    return;
                }
                updateCartBadge(data.cartCount);
                btn.textContent = 'Ditambahkan \u2713';
            })
            .catch(() => {
                btn.textContent = 'Gagal, coba lagi';
            })
            .finally(() => {
                setTimeout(() => {
                    btn.textContent = originalLabel;
                    btn.disabled = false;
                }, 1500);
            });
    });
}

function updateCartBadge(count) {
    const badge = document.getElementById('cart-count-badge');
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
