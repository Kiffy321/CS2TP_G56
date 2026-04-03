@php
    $homeUrl = '/index.php';
@endphp

<div class="TopNav" data-auth="{{ auth()->check() ? '1' : '0' }}">
    <a class="logo-link" href="{{ $homeUrl }}" aria-label="Skyrose Atelier home">
        <img class="header-logo" src="{{ asset('images/logo Skyrose.jpg') }}" alt="Skyrose Atelier logo" style="height:48px;width:auto;">
    </a>

    {{-- Desktop nav links (hidden on mobile) --}}
    <div class="DesktopNavLinks">
        <a href="{{ $homeUrl }}">Home</a>
        <a href="/about">About</a>
        <a href="/products">Products</a>
        <a href="/contact">Contact</a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endif
        @endauth
    </div>

    {{-- Desktop icon nav (hidden on mobile) --}}
    <div class="IconNav DesktopIconNav" style="display: flex; justify-content: flex-end; align-items: center; gap: 16px;">
        <div class="NavSearchWrap">
            <input type="text" class="NavSearchInput" placeholder="Search products..." aria-label="Search products">
        </div>
        <a href="/wishlist" aria-label="Wishlist" title="Wishlist" class="NavWishlist">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" aria-label="Admin Dashboard" title="Admin Dashboard">
                    <img src="{{ asset('images/inventory.png') }}" alt="Admin Dashboard" style="width:32px;height:32px;border-radius:50%;background:#fff3cd;padding:2px;vertical-align:middle;">
                </a>
                <a href="{{ route('profile.edit') }}" aria-label="My Profile" title="My Profile">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="My Profile">
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;font-size:13px;color:#111;font-family:inherit;">Logout</button>
                </form>
            @else
                <a href="{{ route('orders.my') }}" aria-label="My Orders" title="My Orders">
                    <img src="{{ asset('images/orderconfirmed.png') }}" alt="My Orders" style="width:24px;height:24px;vertical-align:middle;">
                </a>
                <a href="{{ route('profile.edit') }}" aria-label="My Profile" title="My Profile">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="My Profile">
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;font-size:13px;color:#111;font-family:inherit;">Logout</button>
                </form>
            @endif
        @else
            <a href="/login" aria-label="Login" title="Login">
                <img src="{{ asset('images/ProfileIcon.png') }}" alt="Login">
            </a>
        @endauth
        <a href="/cart" aria-label="Cart">
            <img src="{{ asset('images/CartIcon.png') }}" alt="Cart">
        </a>
    </div>

    {{-- Mobile-only "Navigation" button (JS shows on mobile) --}}
    <button class="NavToggle" id="nav-toggle" aria-label="Open navigation" style="display:none;">Navigation</button>
</div>

<div class="NavOverlay" id="nav-overlay" style="display:none;"></div>
<div class="NavDrawer" id="nav-drawer" aria-hidden="true" style="display:none;">
    <div class="NavDrawerHeader">
        <span class="NavDrawerTitle">Navigation</span>
        <button class="NavDrawerClose" id="nav-close" aria-label="Close navigation">&times;</button>
    </div>

    {{-- Top section: text page links --}}
    <nav class="NavDrawerLinks">
        <a href="{{ $homeUrl }}">Home</a>
        <a href="/about">About</a>
        <a href="/products">Products</a>
        <a href="/contact">Contact</a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endif
        @endauth
    </nav>

    {{-- Bottom section: icon/action links --}}
    <div class="NavDrawerIcons">
        <div class="NavDrawerSearchWrap">
            <input type="text" class="NavSearchInput NavDrawerSearch" placeholder="Search products..." aria-label="Search products">
        </div>

        <a href="/wishlist" class="NavDrawerIconLink" aria-label="Wishlist">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
            Wishlist
        </a>

        <a href="/cart" class="NavDrawerIconLink" aria-label="Cart">
            <img src="{{ asset('images/CartIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
            Cart
        </a>

        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="NavDrawerIconLink" aria-label="Admin Panel">
                    <img src="{{ asset('images/inventory.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;border-radius:50%;">
                    Admin Panel
                </a>
                <a href="{{ route('profile.edit') }}" class="NavDrawerIconLink" aria-label="My Profile">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="NavDrawerIconLink NavDrawerLogout">Logout</button>
                </form>
            @else
                <a href="{{ route('orders.my') }}" class="NavDrawerIconLink" aria-label="My Orders">
                    <img src="{{ asset('images/orderconfirmed.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                    My Orders
                </a>
                <a href="{{ route('profile.edit') }}" class="NavDrawerIconLink" aria-label="My Profile">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="NavDrawerIconLink NavDrawerLogout">Logout</button>
                </form>
            @endif
        @else
            <a href="/login" class="NavDrawerIconLink" aria-label="Login">
                <img src="{{ asset('images/ProfileIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                Login
            </a>
        @endauth
    </div>
</div>
<script>
(function(){
    var toggle = document.getElementById('nav-toggle');
    var drawer = document.getElementById('nav-drawer');
    var overlay = document.getElementById('nav-overlay');
    var close = document.getElementById('nav-close');

    // Show the toggle button only on mobile
    function checkMobile(){
        if(toggle){
            toggle.style.display = window.innerWidth <= 768 ? 'block' : 'none';
        }
    }
    checkMobile();
    window.addEventListener('resize', checkMobile);

    function openDrawer(){
        drawer.style.display = 'flex';
        overlay.style.display = 'block';
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        setTimeout(function(){ drawer.classList.add('open'); }, 10);
    }
    function closeDrawer(){
        drawer.classList.remove('open');
        overlay.style.display = 'none';
        drawer.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        setTimeout(function(){ if(!drawer.classList.contains('open')) drawer.style.display = 'none'; }, 300);
    }
    if(toggle) toggle.addEventListener('click', openDrawer);
    if(close) close.addEventListener('click', closeDrawer);
    if(overlay) overlay.addEventListener('click', closeDrawer);
})();
</script>


