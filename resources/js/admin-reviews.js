// resources/js/modules/admin-reviews.js

/**
 * Inisialisasi interaksi halaman admin > Kelola Ulasan:
 * - expand/collapse komentar panjang
 * - approve/reject via AJAX tanpa reload
 * - modal konfirmasi + catatan alasan tolak
 */
export function initAdminReviews() {
    const table = document.querySelector('[data-review-row]')?.closest('table');
    if (!table) return; // halaman ini tidak aktif

    initCommentToggle(table);
    initReviewActions(table);
}

function initCommentToggle(table) {
    table.querySelectorAll('[data-comment-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const full = btn.nextElementSibling;
            if (!full) return;
            full.classList.toggle('hidden');
            btn.classList.toggle('hidden');
        });
    });
}

let pendingRejectId = null;

function initReviewActions(table) {
    const modal = document.getElementById('reject-modal');
    const noteInput = document.getElementById('reject-note');
    const cancelBtn = document.getElementById('reject-cancel');
    const confirmBtn = document.getElementById('reject-confirm');

    table.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const reviewId = btn.dataset.reviewId;
        const action = btn.dataset.action;

        if (action === 'approve') {
            if (!confirm('Setujui ulasan ini? Ulasan akan langsung tampil di halaman produk.')) return;
            sendAction(reviewId, 'approve');
        }

        if (action === 'reject') {
            pendingRejectId = reviewId;
            noteInput.value = '';
            modal.classList.remove('hidden');
        }
    });

    cancelBtn.addEventListener('click', () => {
        pendingRejectId = null;
        modal.classList.add('hidden');
    });

    confirmBtn.addEventListener('click', () => {
        if (!pendingRejectId) return;
        sendAction(pendingRejectId, 'reject', { admin_note: noteInput.value });
        modal.classList.add('hidden');
    });

    // Klik di luar modal box = batal
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            pendingRejectId = null;
            modal.classList.add('hidden');
        }
    });
}

function sendAction(reviewId, action, body = {}) {
    const row = document.querySelector(`[data-review-row="${reviewId}"]`);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const url = `/admin/ulasan/${reviewId}/${action}`;

    row?.classList.add('opacity-50', 'pointer-events-none');

    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(body),
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.success) throw new Error(data.message || 'Gagal memproses ulasan.');
            updateRow(row, data.status);
            showToast(data.message);
        })
        .catch((err) => {
            showToast(err.message || 'Terjadi kesalahan.', true);
            row?.classList.remove('opacity-50', 'pointer-events-none');
        });
}

function updateRow(row, status) {
    if (!row) return;

    const badge = row.querySelector('[data-status-badge]');
    const actions = row.querySelector('[data-review-actions]');

    const styles = {
        approved: 'bg-sage/20 text-sage',
        rejected: 'bg-rust/20 text-rust',
    };

    badge.className = `rounded-full px-2 py-0.5 text-xs ${styles[status]}`;
    badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);

    actions.innerHTML = '<span class="text-walnut/30 text-xs">Selesai diproses</span>';

    row.classList.remove('opacity-50', 'pointer-events-none');
    row.classList.add('transition-colors', 'bg-sage/5');
    setTimeout(() => row.classList.remove('bg-sage/5'), 1500);
}

function showToast(message, isError = false) {
    const toast = document.getElementById('review-toast');
    if (!toast) return;

    toast.textContent = message;
    toast.className = `fixed top-4 right-4 z-50 rounded-md px-4 py-2 text-sm text-canvas shadow-lg ${
        isError ? 'bg-rust' : 'bg-sage'
    }`;
    toast.classList.remove('hidden');

    setTimeout(() => toast.classList.add('hidden'), 3000);
}