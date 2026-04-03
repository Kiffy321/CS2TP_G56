<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Watches &ndash; Skyrose Atelier</title>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link rel="icon" type="image/jpeg" href="{{ asset('images/logo%20Skyrose.jpg') }}">
</head>
<body>
  <div class="page-wrapper">
    <div class="PageContent">
      @include('partials.nav')

      <!-- category navigation for browsing products -->
      @include('partials.category-dropdown', ['active' => 'watches'])

      <!-- page heading + short info -->
      <section class="TitleSection">
        <h1 class="MainTitle">Watches</h1>
        <p class="TitleDescription">Curated mechanical and quartz watches.</p>
      </section>

      <!-- main product grid -->
      <main class="ProductsGrid" aria-label="Watches">
        @foreach($products as $product)
        <a class="ProductCard" href="/products/{{ $product->id }}" data-name="{{ $product->name }}" data-category="{{ $product->category }}" data-id="{{ $product->id }}">
          <div class="ProductImageWrap">
            <img class="ProductImage" src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
            <span class="ProductBadge">Watch</span>
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

    </div>
    @include('partials.footer')
  </div>

  <script src="{{ asset('js/wishlist.js') }}?v=2" defer></script>
</body>
</html>

