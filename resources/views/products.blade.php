<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Our Products</title>
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <script src="{{ asset('js/index.js') }}" defer></script>
        <style>
            /* Product Detail View Responsive Styles */
            #productDetailView .detail-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 60px;
                align-items: start;
            }
            
            @media (max-width: 900px) {
                #productDetailView .detail-grid {
                    grid-template-columns: 1fr;
                    gap: 30px;
                }
                
                #productDetailView .detail-image-container {
                    position: relative !important;
                    top: auto !important;
                }
            }
        .ProductCardActions { display: flex; gap: 8px; margin-top: 10px; }
        .AddToCartButton { flex: 1; }
        .WishlistBtn {
            background: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 10px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.2s;
            color: #aaa;
            line-height: 1;
        }
        .WishlistBtn:hover, .WishlistBtn.active { color: #e74c3c; border-color: #e74c3c; }
        </style>
</head>
<body>

<div class="page-wrapper">
    <div class="PageContent">

    <!-- Top Navigation -->
        @include('partials.nav')

<section class="TitleSection">
        <h1 class="MainTitle">Our Jewellery Collection</h1>
        <p class="TitleDescription">Browse our handmade, luxury jewellery pieces.</p>
</section>

<!-- Search Bar -->
<section class="SearchSection" style="padding: 20px; text-align: center; background: #f9f9f9; margin: 20px 0;">
    <input type="text" id="searchInput" placeholder="Search products by name or category..." style="width: 100%; max-width: 500px; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
</section>

<!-- Category links -->
<section class="CategoryLinks" aria-label="Shop by category">
    <h2 class="SectionTitle">Shop By Category</h2>
    <div class="CategoryGrid">
        <a class="CategoryCard" href="/category/rings">Rings</a>
        <a class="CategoryCard" href="/category/earrings">Earrings</a>
        <a class="CategoryCard" href="/category/bracelets">Bracelets</a>
        <a class="CategoryCard" href="/category/necklaces">Necklaces</a>
        <a class="CategoryCard" href="/category/watches">Watches</a>
    </div>
</section>

<!-- Products Grid (uses CSS in css/index.css) -->
<main class="ProductsGrid" id="productsGrid" aria-label="Product list">
    @foreach($products as $product)
        <a class="ProductCard" href="/products/{{ $product->id }}" data-name="{{ $product->name }}" data-category="{{ $product->category }}">
            <div class="ProductImageWrap">
                <img class="ProductImage" src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                <span class="ProductBadge">{{ $product->category }}</span>
            </div>
            <div class="ProductInfo">
                <h3 class="ProductTitle">{{ $product->name }}</h3>
                <p class="ProductDescription">{{ $product->description }}</p>
                <div class="ProductMeta">
                    <span class="StockText {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                    <span class="ProductPrice">&pound;{{ number_format($product->price, 2) }}</span>
                </div>
                <div class="QuantitySelector">
                    <label>Qty:</label>
                    <select id="qty-{{ Str::slug($product->name) }}">
                        @for($i = 1; $i <= min(10, $product->stock_quantity); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="ProductCardActions">
                    <button class="AddToCartButton" onclick="addToCartWithQuantity(event, '{{ $product->name }}', 'qty-{{ Str::slug($product->name) }}', {{ $product->price }}, {{ $product->id }})">Add to Cart</button>
                    <button type="button" class="WishlistBtn" onclick="toggleWishlist(event, this)" title="Add to wishlist">&#9825;</button>
                </div>
            </div>
        </a>
    @endforeach
</main>

<!-- Product Detail View (initially hidden) -->
<section id="productDetailView" style="display: none; padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <a href="/products" style="display: inline-block; margin-bottom: 20px; color: #111; text-decoration: none; font-weight: 500;">&larr; Back to Products</a>
    
    <div class="detail-grid">
        <!-- Product Image -->
        <div class="detail-image-container" style="position: sticky; top: 20px;">
            <img id="detailImage" src="" alt="" style="width: 100%; max-width: 600px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <span id="detailBadge" class="ProductBadge" style="position: absolute; top: 20px; right: 20px;"></span>
        </div>
        
        <!-- Product Info -->
        <div>
            <h1 id="detailTitle" style="font-size: 2.5em; margin-bottom: 10px; color: #111;"></h1>
            <p id="detailDescription" style="font-size: 1.1em; line-height: 1.8; color: #555; margin-bottom: 30px;"></p>
            
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 30px; flex-wrap: wrap;">
                <span id="detailStock" class="StockText in-stock"></span>
                <span id="detailPrice" style="font-size: 2em; font-weight: 600; color: #111;"></span>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 500; margin-right: 10px;">Quantity:</label>
                <select id="detailQuantity" style="padding: 10px 20px; font-size: 1em; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            
            <button id="detailAddToCart" class="AddToCartButton" style="padding: 15px 40px; font-size: 1.1em; width: auto; min-width: 200px;">Add to Cart</button>
            
            <div style="margin-top: 40px; padding-top: 40px; border-top: 1px solid #ddd;">
                <h3 style="margin-bottom: 15px;">Product Details</h3>
                <ul style="line-height: 2; color: #555;">
                    <li>Handcrafted with care and precision</li>
                    <li>Ethically sourced materials</li>
                    <li>Comes with certificate of authenticity</li>
                    <li>30-day return policy</li>
                    <li>Free shipping on orders over &pound;200</li>
                </ul>
            </div>
        </div>
    </div>
</section>

    </div>

    @include('partials.footer')
<script src="{{ asset('js/index.js') }}" defer></script>

<script>
// Check if we're viewing a specific product
function showProductDetail() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product');
    
    if (productId) {
        // Find the product card with matching href
        const productCard = document.querySelector(`.ProductCard[href="/products?product=${productId}"]`);
        
        if (productCard) {
            // Hide the grid view elements
            document.querySelector('.TitleSection').style.display = 'none';
            document.querySelector('.SearchSection').style.display = 'none';
            document.querySelector('.CategoryLinks').style.display = 'none';
            document.getElementById('productsGrid').style.display = 'none';
            
            // Show detail view
            document.getElementById('productDetailView').style.display = 'block';
            
            // Extract product info from the card
            const img = productCard.querySelector('.ProductImage');
            const title = productCard.querySelector('.ProductTitle').textContent;
            const description = productCard.querySelector('.ProductDescription').textContent;
            const price = productCard.querySelector('.ProductPrice').textContent;
            const badge = productCard.querySelector('.ProductBadge').textContent;
            const stockElement = productCard.querySelector('.StockText');
            const stock = stockElement ? stockElement.textContent : 'In Stock';
            const stockClass = stockElement ? stockElement.className : 'StockText in-stock';
            
            // Populate detail view
            document.getElementById('detailImage').src = img.src;
            document.getElementById('detailImage').alt = title;
            document.getElementById('detailTitle').textContent = title;
            document.getElementById('detailDescription').textContent = description;
            document.getElementById('detailPrice').textContent = price;
            document.getElementById('detailBadge').textContent = badge;
            document.getElementById('detailStock').textContent = stock;
            document.getElementById('detailStock').className = stockClass;
            
            // Get the product name for cart (from the onclick attribute or data)
            let productName = title;
            const addToCartBtn = productCard.querySelector('.AddToCartButton');
            if (addToCartBtn && addToCartBtn.getAttribute('onclick')) {
                const onclickStr = addToCartBtn.getAttribute('onclick');
                const match = onclickStr.match(/'([^']+)'/);
                if (match) {
                    productName = match[1];
                }
            }
            
            // Setup add to cart button
            document.getElementById('detailAddToCart').onclick = function(event) {
                const qty = parseInt(document.getElementById('detailQuantity').value);
                
                // Use the existing addToCartQuick function
                if (typeof addToCartQuick === 'function') {
                    addToCartQuick(event, productName, qty);
                } else {
                    // Fallback if function not available
                    alert('Added ' + qty + ' Ã— ' + productName + ' to cart!');
                }
            };
            
            // Scroll to top
            window.scrollTo(0, 0);
        } else {
            // Product not found, redirect to product-notfound.html or show grid
            console.error('Product not found:', productId);
        }
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', showProductDetail);

// Search functionality (only run if we're not viewing a specific product)
if (document.getElementById('searchInput')) {
    const searchInput = document.getElementById('searchInput');

    // Pre-populate from ?q= URL param and trigger filter
    const _qParam = new URLSearchParams(window.location.search).get('q');
    if (_qParam) {
        searchInput.value = _qParam;
        searchInput.dispatchEvent(new Event('keyup'));
    }

    searchInput.addEventListener('keyup', function(e) {
        const query = e.target.value.toLowerCase();
        const products = document.querySelectorAll('.ProductCard');
        
        // filter products by name or category
        products.forEach(product => {
            const name = product.getAttribute('data-name').toLowerCase();
            const category = product.getAttribute('data-category').toLowerCase();
            
            if (name.includes(query) || category.includes(query) || query === '') {
                product.style.display = 'block'; // show product
            } else {
                product.style.display = 'none'; // hide product
            }
        });
    });
}
</script>

    <script>
    // Prevent card navigation when interacting with quantity selectors or add-to-cart buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure add-to-cart buttons don't trigger navigation
        document.querySelectorAll('.AddToCartButton').forEach(btn => {
            btn.setAttribute('type', 'button');
            btn.addEventListener('click', evt => {
                evt.stopPropagation();
            });
        });

        // Stop select clicks/changes from bubbling to the anchor link
        document.querySelectorAll('.ProductCard select').forEach(sel => {
            sel.addEventListener('click', evt => {
                evt.preventDefault();
                evt.stopPropagation();
            });
            sel.addEventListener('change', evt => {
                evt.stopPropagation();
            });
        });

        // As a fallback, prevent navigation if the click originated from controls
        document.querySelectorAll('.ProductCard').forEach(card => {
            card.addEventListener('click', evt => {
                const t = evt.target;
                if (t.closest('select') || t.closest('.AddToCartButton') || t.closest('.WishlistBtn')) {
                    evt.preventDefault();
                }
            });
        });
    });
    </script>

    <script>
    function toggleWishlist(event, btn) {
        event.preventDefault();
        event.stopPropagation();
        btn.classList.toggle('active');
        btn.innerHTML = btn.classList.contains('active') ? '&#9829;' : '&#9825;';
        const productName = btn.closest('.ProductInfo').querySelector('.ProductTitle').textContent;
        const msg = btn.classList.contains('active') ? `${productName} added to wishlist` : `${productName} removed from wishlist`;
        showToast(msg);
    }

    function showToast(message) {
        let toast = document.getElementById('wishlist-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'wishlist-toast';
            toast.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#111;color:#fff;padding:12px 24px;border-radius:4px;font-size:14px;z-index:9999;transition:opacity 0.3s;';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.style.opacity = '1';
        clearTimeout(toast._timeout);
        toast._timeout = setTimeout(() => { toast.style.opacity = '0'; }, 2500);
    }
    </script>

</body>
</html>



