/**
 * Skyrose Atelier – Wishlist module
 * Persists wishlist to localStorage for guests.
 * Uses the DB API (/wishlist/toggle, /wishlist/data) for logged-in users.
 * Exposes: window.toggleWishlist(event, btn) for product-card heart buttons
 *          window.wishlist  – helper object used by product detail page
 */
(function () {
    var STORAGE_KEY = 'skyrose_wishlist';

    // ── Auth helpers ──────────────────────────────────────────────────────────

    function isLoggedIn() {
        var nav = document.querySelector('.TopNav');
        return !!(nav && nav.getAttribute('data-auth') === '1');
    }

    function getCsrf() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    // ── localStorage helpers (guests) ─────────────────────────────────────────

    function getWishlist() {
        try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; }
        catch (e) { return []; }
    }

    function saveWishlist(items) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    }

    function isInWishlist(name) {
        return getWishlist().some(function (i) { return i.name === name; });
    }

    function addToWishlist(item) {
        var items = getWishlist();
        if (!items.some(function (i) { return i.name === item.name; })) {
            items.push(item);
            saveWishlist(items);
        }
    }

    function removeFromWishlist(name) {
        saveWishlist(getWishlist().filter(function (i) { return i.name !== name; }));
    }

    // ── API helpers (logged-in users) ─────────────────────────────────────────

    function apiToggle(productId, onSuccess) {
        fetch('/wishlist/toggle', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrf()
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success && onSuccess) { onSuccess(data.in_wishlist); }
        })
        .catch(function () { /* silently ignore network errors */ });
    }

    function apiGetItems(onSuccess) {
        fetch('/wishlist/data', { credentials: 'include' })
        .then(function (r) { return r.json(); })
        .then(function (data) { if (onSuccess) { onSuccess(data.items || []); } })
        .catch(function () { if (onSuccess) { onSuccess([]); } });
    }

    // ── Toast ─────────────────────────────────────────────────────────────────

    function showWishlistToast(message) {
        var toast = document.getElementById('wishlist-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'wishlist-toast';
            toast.style.cssText = [
                'position:fixed', 'bottom:24px', 'left:50%',
                'transform:translateX(-50%)', 'background:#111', 'color:#fff',
                'padding:12px 24px', 'border-radius:4px', 'font-size:14px',
                'z-index:9999', 'opacity:0', 'transition:opacity 0.3s',
                'pointer-events:none'
            ].join(';');
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.style.opacity = '1';
        clearTimeout(toast._wt);
        toast._wt = setTimeout(function () { toast.style.opacity = '0'; }, 2500);
    }

    // ── Toggle (called from product-card heart buttons) ───────────────────────

    window.toggleWishlist = function (event, btn) {
        event.preventDefault();
        event.stopPropagation();

        var card      = btn.closest('.ProductCard');
        var name      = (card && card.dataset.name) || (card && card.querySelector('.ProductTitle') && card.querySelector('.ProductTitle').textContent.trim()) || '';
        var productId = card && card.dataset.id ? parseInt(card.dataset.id, 10) : null;
        var image     = (card && card.querySelector('.ProductImage') && card.querySelector('.ProductImage').src) || '';
        var price     = (card && card.querySelector('.ProductPrice') && card.querySelector('.ProductPrice').textContent.trim()) || '';
        var link      = (card && card.href) || '';
        var category  = (card && card.dataset.category) || (card && card.querySelector('.ProductBadge') && card.querySelector('.ProductBadge').textContent.trim()) || '';

        if (isLoggedIn() && productId) {
            apiToggle(productId, function (inWishlist) {
                if (inWishlist) {
                    btn.classList.add('active');
                    btn.innerHTML = '&#9829;';
                    showWishlistToast(name + ' added to wishlist');
                } else {
                    btn.classList.remove('active');
                    btn.innerHTML = '&#9825;';
                    showWishlistToast(name + ' removed from wishlist');
                }
            });
        } else {
            if (isInWishlist(name)) {
                removeFromWishlist(name);
                btn.classList.remove('active');
                btn.innerHTML = '&#9825;';
                showWishlistToast(name + ' removed from wishlist');
            } else {
                addToWishlist({ name: name, price: price, image: image, link: link, category: category, product_id: productId });
                btn.classList.add('active');
                btn.innerHTML = '&#9829;';
                showWishlistToast(name + ' added to wishlist');
            }
        }
    };

    // ── Init: mark active buttons on page load ────────────────────────────────

    function initWishlistButtons() {
        if (isLoggedIn()) {
            apiGetItems(function (items) {
                var ids = items.map(function (i) { return i.product_id; });
                document.querySelectorAll('.WishlistBtn').forEach(function (btn) {
                    var card      = btn.closest('.ProductCard');
                    var productId = card && card.dataset.id ? parseInt(card.dataset.id, 10) : null;
                    if (productId && ids.indexOf(productId) !== -1) {
                        btn.classList.add('active');
                        btn.innerHTML = '&#9829;';
                    }
                });
            });
        } else {
            document.querySelectorAll('.WishlistBtn').forEach(function (btn) {
                var card = btn.closest('.ProductCard');
                if (!card) return;
                var name = card.dataset.name || (card.querySelector('.ProductTitle') && card.querySelector('.ProductTitle').textContent.trim()) || '';
                if (name && isInWishlist(name)) {
                    btn.classList.add('active');
                    btn.innerHTML = '&#9829;';
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWishlistButtons);
    } else {
        initWishlistButtons();
    }

    // ── Public API ────────────────────────────────────────────────────────────

    window.wishlist = {
        getWishlist:         getWishlist,
        isInWishlist:        isInWishlist,
        addToWishlist:       addToWishlist,
        removeFromWishlist:  removeFromWishlist,
        showToast:           showWishlistToast,
        isLoggedIn:          isLoggedIn,
        apiToggle:           apiToggle,
        apiGetItems:         apiGetItems,
    };
})();
