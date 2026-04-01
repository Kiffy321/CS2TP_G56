// Central site JS: auth UI + shared behaviors
(function(){
  // Get CSRF token from meta tag (required for Laravel POST requests)
  function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  // --- Session initialization (get cart count) ---
  function initSession(){
    fetch('/session/init', { credentials: 'include' })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          const cartCountEl = document.getElementById('cart-count');
          if (cartCountEl && data.cartCount !== undefined) {
            const count = parseInt(data.cartCount) || 0;
            if (count > 0) {
              cartCountEl.textContent = count;
              cartCountEl.style.display = 'inline-block';
            } else {
              cartCountEl.style.display = 'none';
            }
          }
        }
      })
      .catch(err => console.error('Session init error:', err));
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ initSession(); initNavSearch(); });
  else { initSession(); initNavSearch(); }

  // --- Expanding nav search ---
  function initNavSearch(){
    document.querySelectorAll('.NavSearchWrap').forEach(function(wrap){
      const btn = wrap.querySelector('.NavSearchBtn');
      const input = wrap.querySelector('.NavSearchInput');
      if (!btn || !input) return;
      btn.addEventListener('click', function(){
        wrap.classList.toggle('open');
        if (wrap.classList.contains('open')) input.focus();
      });
      input.addEventListener('keydown', function(e){
        if (e.key === 'Enter' && input.value.trim()) {
          window.location.href = '/products?q=' + encodeURIComponent(input.value.trim());
        }
        if (e.key === 'Escape') {
          wrap.classList.remove('open');
          btn.focus();
        }
      });
      document.addEventListener('click', function(e){
        if (!wrap.contains(e.target)) wrap.classList.remove('open');
      });
    });
  }

  // fallback global logout
  if (!window.logout){
    window.logout = function(){
      fetch('/logout', {
        method: 'POST',
        credentials: 'include',
        headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Content-Type': 'application/json' }
      }).then(() => location.href = '/');
    };
  }
})();

// Product price database
const productPrices = {
  'Diamond Solitaire Ring': 3000,
  'Pearl Necklace': 300,
  'Gold Hoop Earrings': 190,
  'Sapphire Pendant': 900,
  'Tennis Bracelet': 3500,
  'Emerald Stud Earrings': 750,
  'Ruby Cocktail Ring': 1900,
  'Silver Charm Bracelet': 150,
  'Rose Gold Watch': 1300,
  'Aquamarine Ring': 600,
  'Gold Chain Necklace': 450,
  'Diamond Stud Earrings': 1500,
  'Opal Drop Earrings': 600,
  'Platinum Band': 800,
  'Turquoise Bead Necklace': 250,
  'Leather Wrap Bracelet': 60,
  'Citrine Pendant': 350,
  'Pearl Stud Earrings': 100,
  'Garnet Statement Ring': 400,
  'Crystal Bangle': 80,
  'Onyx Cufflinks': 130,
  'Amethyst Tennis Bracelet': 500,
  'Topaz Drop Necklace': 300,
  'Sapphire Stud Earrings': 650,
  'Rose Quartz Pendant': 200
};

function getCsrfToken() {
  const meta = document.querySelector('meta[name="csrf-token"]');
  return meta ? meta.getAttribute('content') : '';
}

// Toast notification for cart actions
function showCartToast(msg) {
  var display = (msg && msg.length > 100) ? 'Unable to add to cart. Please try again.' : msg;
  var toast = document.getElementById('cart-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'cart-toast';
    toast.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#111;color:#fff;padding:12px 24px;border-radius:4px;font-size:14px;z-index:9999;opacity:0;transition:opacity 0.3s;pointer-events:none;';
    document.body.appendChild(toast);
  }
  toast.textContent = display;
  toast.style.opacity = '1';
  clearTimeout(toast._ct);
  toast._ct = setTimeout(function() { toast.style.opacity = '0'; }, 2500);
}

// Quick add to cart function

function addToCartQuick(event, productName, quantity, price, productId) {
  event.preventDefault();
  event.stopPropagation();

  // Use provided price if available, else fallback to productPrices
  const finalPrice = (typeof price !== 'undefined') ? price : (productPrices[productName] || 0);
  if (finalPrice === 0) {
    alert('Error: Product price not found for "' + productName + '".');
    return;
  }

  const payload = {
    productName: productName,
    quantity: quantity || 1,
    price: finalPrice,
    productId: productId
  };

  fetch('/cart/add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': getCsrfToken()
    },
    credentials: 'include',
    body: JSON.stringify(payload)
  })
  .then(r => {
    if (!r.ok) return r.text().then(text => { throw new Error('HTTP ' + r.status + ': ' + text); });
    return r.json();
  })
  .then(data => {
    if (data.success) {
      const btn = event.target;
      const originalText = btn.textContent;
      btn.textContent = '✓ Added!';
      btn.style.background = '#2e7d32';
      btn.style.color = 'white';
      setTimeout(() => {
        btn.textContent = originalText;
        btn.style.background = '';
        btn.style.color = '';
      }, 2000);
      const cartCount = document.getElementById('cart-count');
      if (cartCount && data.cartCount) cartCount.textContent = data.cartCount;
      showCartToast(productName + ' added to basket!');
    } else {
      showCartToast('Error: ' + (data.error || 'Failed to add to basket'));
    }
  })
  .catch(err => {
    console.error('Fetch error:', err);
    showCartToast('Error adding to basket: ' + err.message);
  });
}

window.addToCartWithQuantity = function(event, productName, quantitySelectId, price, productId) {
  event.preventDefault();
  event.stopPropagation();
  const quantitySelect = document.getElementById(quantitySelectId);
  if (!quantitySelect) { alert('Quantity selector not found'); return; }
  const quantity = parseInt(quantitySelect.value) || 1;
  addToCartQuick(event, productName, quantity, price, productId);
};
