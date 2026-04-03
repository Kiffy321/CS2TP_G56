@php
    $homeUrl = '/index.php';
@endphp

<div class="TopNav" data-auth="{{ auth()->check() ? '1' : '0' }}">
    <a class="logo-link" href="{{ $homeUrl }}" aria-label="Skyrose Atelier home">
        <img class="header-logo" src="{{ asset('images/logo Skyrose.jpg') }}" alt="Skyrose Atelier logo" style="height:48px;width:auto;">
    </a>

    {{-- Desktop nav links (hidden on mobile) --}}
    <div class="DesktopNavLinks" id="desktop-nav-links" style="display:none;">
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
    <div class="IconNav DesktopIconNav" id="desktop-icon-nav" style="display:none; justify-content: flex-end; align-items: center; gap: 16px;">
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
    <div id="mobile-actions" style="display:none;align-items:center;gap:8px;margin-left:auto;">
        @auth
            <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;padding:6px;">
                <img src="{{ asset('images/ProfileIcon.png') }}" alt="Profile" style="width:26px;height:26px;object-fit:contain;">
            </a>
        @else
            <a href="/login" style="display:inline-flex;align-items:center;padding:7px 14px;background:#111;color:#fff;border-radius:4px;font-size:14px;font-weight:600;text-decoration:none;">Login</a>
        @endauth
        <a href="/cart" style="display:flex;align-items:center;padding:6px;">
            <img src="{{ asset('images/CartIcon.png') }}" alt="Cart" style="width:26px;height:26px;object-fit:contain;">
        </a>
        <button class="NavToggle" id="nav-toggle" aria-label="Open navigation" style="background:transparent;border:1px solid #111;border-radius:4px;padding:7px 14px;font-size:14px;font-weight:600;cursor:pointer;color:#111;font-family:inherit;">Navigation</button>
    </div>
</div>

<div id="nav-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:1050;"></div>
<div id="nav-drawer" aria-hidden="true" style="display:none;position:fixed;top:0;left:0;width:280px;height:100vh;background:#fff;z-index:1100;flex-direction:column;box-shadow:4px 0 24px rgba(0,0,0,0.15);transform:translateX(-100%);transition:transform 0.3s ease;overflow-y:auto;">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:rgba(200,195,137,0.9);border-bottom:1px solid rgba(0,0,0,0.08);flex-shrink:0;">
        <span style="font-size:16px;font-weight:700;color:#111;">Navigation</span>
        <button id="nav-close" aria-label="Close navigation" style="background:none;border:none;font-size:26px;cursor:pointer;color:#111;line-height:1;padding:0 4px;">&times;</button>
    </div>

    {{-- Top section: text page links --}}
    <nav style="flex:1;display:flex;flex-direction:column;padding:8px 0;overflow-y:auto;border-bottom:2px solid rgba(200,195,137,0.6);">
        <a href="{{ $homeUrl }}" style="padding:14px 24px;font-size:16px;color:#111;text-decoration:none;border-bottom:1px solid #f0f0f0;">Home</a>
        <a href="/about" style="padding:14px 24px;font-size:16px;color:#111;text-decoration:none;border-bottom:1px solid #f0f0f0;">About</a>
        <a href="/products" style="padding:14px 24px;font-size:16px;color:#111;text-decoration:none;border-bottom:1px solid #f0f0f0;">Products</a>
        <a href="/contact" style="padding:14px 24px;font-size:16px;color:#111;text-decoration:none;border-bottom:1px solid #f0f0f0;">Contact</a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" style="padding:14px 24px;font-size:16px;color:#111;text-decoration:none;border-bottom:1px solid #f0f0f0;">Dashboard</a>
            @endif
        @endauth
    </nav>

    {{-- Bottom section: icon/action links --}}
    <div style="padding:12px 0;display:flex;flex-direction:column;gap:2px;">
        <div style="padding:8px 16px 12px;">
            <input type="text" class="NavSearchInput" placeholder="Search products..." aria-label="Search products" style="width:100%;box-sizing:border-box;">
        </div>

        <a href="/wishlist" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Wishlist
        </a>
        <a href="/cart" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
            <img src="{{ asset('images/CartIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
            Cart
        </a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
                    <img src="{{ asset('images/inventory.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;border-radius:50%;">
                    Admin Panel
                </a>
                <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#b91c1c;background:none;border:none;cursor:pointer;font-family:inherit;width:100%;text-align:left;">Logout</button>
                </form>
            @else
                <a href="{{ route('orders.my') }}" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
                    <img src="{{ asset('images/orderconfirmed.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                    My Orders
                </a>
                <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
                    <img src="{{ asset('images/ProfileIcon.png') }}" alt="" style="width:20px;height:20px;object-fit:contain;">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#b91c1c;background:none;border:none;cursor:pointer;font-family:inherit;width:100%;text-align:left;">Logout</button>
                </form>
            @endif
        @else
            <a href="/login" style="display:flex;align-items:center;gap:12px;padding:10px 24px;font-size:14px;color:#111;text-decoration:none;">
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

    var desktopLinks = document.getElementById('desktop-nav-links');
    var desktopIcons = document.getElementById('desktop-icon-nav');
    var mobileActions = document.getElementById('mobile-actions');

    function checkMobile(){
        var isMobile = window.innerWidth <= 768;
        if(desktopLinks) desktopLinks.style.display = isMobile ? 'none' : 'flex';
        if(desktopIcons) desktopIcons.style.display = isMobile ? 'none' : 'flex';
        if(mobileActions) mobileActions.style.display = isMobile ? 'flex' : 'none';
    }
    checkMobile();
    window.addEventListener('resize', checkMobile);

    function openDrawer(){
        drawer.style.display = 'flex';
        overlay.style.display = 'block';
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        setTimeout(function(){ drawer.style.transform = 'translateX(0)'; }, 10);
    }
    function closeDrawer(){
        drawer.style.transform = 'translateX(-100%)';
        overlay.style.display = 'none';
        drawer.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        setTimeout(function(){ drawer.style.display = 'none'; }, 300);
    }
    if(toggle) toggle.addEventListener('click', openDrawer);
    if(close) close.addEventListener('click', closeDrawer);
    if(overlay) overlay.addEventListener('click', closeDrawer);
})();
</script>


