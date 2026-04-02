@php
    $homeUrl = '/index.php';
@endphp

<div class="TopNav">
    <a class="logo-link" href="{{ $homeUrl }}" aria-label="Skyrose Atelier home">
        <img class="header-logo" src="{{ asset('images/logo Skyrose.jpg') }}" alt="Skyrose Atelier logo" style="height:48px;width:auto;">
    </a>
    <a href="{{ $homeUrl }}">Home</a>
    <a href="/about">About</a>
    <a href="/products">Products</a>
    <a href="/contact">Contact</a>
    @auth
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        @endif
    @endauth
    <div class="IconNav" style="display: flex; justify-content: flex-end; align-items: center; gap: 16px; width: 600px;">

        {{-- Search (always visible) --}}
        <div class="NavSearchWrap">
            <input type="text" class="NavSearchInput" placeholder="Search products..." aria-label="Search products">
        </div>

        @auth
            @if(auth()->user()->is_admin)
                {{-- ADMIN: dashboard icon + wishlist --}}
                <a href="{{ route('admin.dashboard') }}" aria-label="Admin Dashboard" title="Admin Dashboard">
                    <img src="{{ asset('images/inventory.png') }}" alt="Admin Dashboard" style="width:32px;height:32px;border-radius:50%;background:#fff3cd;padding:2px;vertical-align:middle;">
                </a>
                <a href="/wishlist" aria-label="Wishlist" title="Wishlist" class="NavWishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </a>
            @else
                {{-- REGULAR USER: wishlist + my orders + profile --}}
                <a href="/wishlist" aria-label="Wishlist" title="Wishlist" class="NavWishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </a>
                <a href="{{ route('orders.my') }}" aria-label="My Orders" title="My Orders">
                    <img src="{{ asset('images/orderconfirmed.png') }}" alt="My Orders" style="width:24px;height:24px;vertical-align:middle;">
                </a>
                <a href="{{ route('profile.edit') }}" aria-label="My Profile" title="My Profile">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="My Profile">
                </a>
            @endif
        @else
            {{-- GUEST: login icon --}}
            <a href="/login" aria-label="Login" title="Login">
                <img src="{{ asset('images/ProfileIcon.png') }}" alt="Login">
            </a>
        @endauth

        {{-- Cart (always visible) --}}
        <a href="/cart" aria-label="Cart">
            <img src="{{ asset('images/CartIcon.png') }}" alt="Cart">
        </a>
    </div>
</div>


