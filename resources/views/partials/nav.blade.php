<div class="TopNav">
    <a class="logo-link" href="/" aria-label="Skyrose Atelier home">
        <img class="header-logo" src="{{ asset('images/logo Skyrose.jpg') }}" alt="Skyrose Atelier logo">
    </a>
    <a href="/">Home</a>
    <a href="/about">About</a>
    <a href="/products">Products</a>
    <a href="/contact">Contact</a>
    <div class="IconNav">
        <a class="NavSearch" href="/products#searchInput" aria-label="Search">
            <img src="{{ asset('images/SearchIcon.png') }}" alt="Search">
        </a>
        <a href="/wishlist" aria-label="Wishlist" style="display:flex;align-items:center;padding:10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </a>
        <div id="auth-buttons">
            @auth
                <a href="{{ route('profile.edit') }}" aria-label="My Profile"><img src="{{ asset('images/ProfileIcon.png') }}" alt="Profile"></a>
            @else
                <a href="/login" aria-label="Login"><img src="{{ asset('images/ProfileIcon.png') }}" alt="Login"></a>
            @endauth
            <a href="/cart" aria-label="Cart">
                <img src="{{ asset('images/CartIcon.png') }}" alt="Cart">
            </a>
        </div>
    </div>
</div>


