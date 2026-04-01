<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile &ndash; Skyrose Atelier</title>
    @include('partials.head')
    <style>
        .ProfilePage { max-width: 680px; margin: 60px auto; padding: 0 20px 60px; }
        .ProfilePage h1 { font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 36px; }
        .ProfileCard {
            background: #fff;
            border: 1px solid #e8e0d0;
            border-radius: 8px;
            padding: 32px;
            margin-bottom: 24px;
        }
        .ProfileCard h2 { font-size: 18px; font-weight: 700; color: #1a1a1a; margin: 0 0 20px 0; padding-bottom: 12px; border-bottom: 1px solid #eee; }
        .ProfileForm { display: flex; flex-direction: column; gap: 16px; }
        .ProfileForm label { font-size: 13px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
        .ProfileForm input {
            width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px;
            font-size: 14px; color: #111; box-sizing: border-box; transition: border-color 0.2s;
        }
        .ProfileForm input:focus { outline: none; border-color: #d4af37; box-shadow: 0 0 0 3px rgba(212,175,55,0.12); }
        .ProfileForm input[readonly] { background: #f8f8f8; color: #888; cursor: not-allowed; }
        .ProfileBtn {
            padding: 11px 24px; background: #d4af37; color: #fff;
            border: none; border-radius: 6px; font-size: 14px; font-weight: 600;
            cursor: pointer; transition: background 0.2s; align-self: flex-start; margin-top: 4px;
        }
        .ProfileBtn:hover { background: #b8941f; }
        .ProfileBtnDanger {
            padding: 11px 24px; background: #dc3545; color: #fff;
            border: none; border-radius: 6px; font-size: 14px; font-weight: 600;
            cursor: pointer; transition: background 0.2s; align-self: flex-start; margin-top: 4px;
        }
        .ProfileBtnDanger:hover { background: #b02a37; }
        .ProfileAlert { padding: 12px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; }
        .ProfileAlert.success { background: #d1e7dd; color: #0a3622; }
        .ProfileAlert.error { background: #f8d7da; color: #842029; }
        .ProfileRow { display: flex; align-items: center; justify-content: space-between; }
        .ProfileName { font-size: 15px; color: #555; }
        .OrderLink { font-size: 14px; color: #d4af37; text-decoration: none; font-weight: 600; }
        .OrderLink:hover { text-decoration: underline; }

        /* Orders table */
        .ProfilePage { max-width: 900px; }
        .OrdersTable { width: 100%; border-collapse: collapse; font-size: 13px; }
        .OrdersTable th {
            text-align: left; padding: 10px 12px; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px; color: #888;
            border-bottom: 2px solid #eee; background: #fafafa;
        }
        .OrdersTable td { padding: 12px 12px; border-bottom: 1px solid #f0ece4; color: #1a1a1a; vertical-align: middle; }
        .OrdersTable tr:last-child td { border-bottom: none; }
        .OrdersTable tr:hover td { background: #fdf9f0; }
        .OBadge {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .OBadge.pending    { background:#fff8e1; color:#b8860b; }
        .OBadge.processing { background:#e3f2fd; color:#1565c0; }
        .OBadge.shipped    { background:#e0f2f1; color:#00695c; }
        .OBadge.completed  { background:#e8f5e9; color:#2e7d32; }
        .OBadge.cancelled  { background:#fde8e8; color:#c0392b; }
        .OBadge.refunded   { background:#f3e8fd; color:#6d28d9; }
        .OrdersEmpty { text-align: center; padding: 40px 0; color: #aaa; font-size: 14px; }
        .OrderDetailLink { color: #d4af37; text-decoration: none; font-weight: 600; font-size: 12px; }
        .OrderDetailLink:hover { text-decoration: underline; }

        /* Admin link */
        .AdminLink {
            display: flex !important; align-items: center; gap: 10px;
            padding: 13px 18px; background: #fffbf0; border: 1px solid #d4af37;
            border-radius: 8px; text-decoration: none !important; color: #8a6a00 !important;
            font-weight: 600; font-size: 14px; transition: background 0.2s, border-color 0.2s;
        }
        .AdminLink:hover { background: #fff3cc !important; border-color: #b8941f; color: #6b5000 !important; }
        .AdminLink svg { flex-shrink: 0; }

        /* Logout card */
        .ProfileCard.logout-card { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .logout-card .logout-info h2 { margin-bottom: 4px; }
        .logout-card .logout-info p { font-size: 13px; color: #888; margin: 0; }
        .ProfileBtnOutline {
            padding: 10px 22px; background: transparent; color: #555;
            border: 1.5px solid #ccc; border-radius: 6px; font-size: 14px; font-weight: 600;
            cursor: pointer; white-space: nowrap; transition: border-color 0.2s, color 0.2s; flex-shrink: 0;
        }
        .ProfileBtnOutline:hover { border-color: #888; color: #222; }

        /* Danger zone */
        .ProfileCard.danger-card { border-color: #f5c2c7; background: #fff8f8; }
        .danger-card h2 { color: #842029 !important; border-bottom-color: #f5c2c7 !important; }
        .danger-card p { font-size: 13px; color: #7a4a4a; margin: 0 0 16px 0; }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="PageContent">
            @include('partials.nav')

            <div class="ProfilePage">
                <h1>My Profile</h1>

                @if(session('status') === 'profile-updated')
                    <div class="ProfileAlert success">Profile updated successfully.</div>
                @endif

                {{-- Profile Info --}}
                <div class="ProfileCard">
                    <h2>Account Information</h2>
                    <form class="ProfileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name">Full Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name">
                            @error('name') <p style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email">Email Address</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email">
                            @error('email') <p style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="username">Username (optional)</label>
                            <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" autocomplete="username">
                            @error('username') <p style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="ProfileBtn">Save Changes</button>
                    </form>
                </div>

                {{-- Change Password --}}
                <div class="ProfileCard">
                    <h2>Change Password</h2>
                    @if(session('status') === 'password-updated')
                        <div class="ProfileAlert success">Password updated successfully.</div>
                    @endif
                    <form class="ProfileForm" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password">Current Password</label>
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password">
                            @error('current_password', 'updatePassword') <p style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password">New Password</label>
                            <input id="password" name="password" type="password" autocomplete="new-password">
                            @error('password', 'updatePassword') <p style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation">Confirm New Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                        </div>

                        <button type="submit" class="ProfileBtn">Update Password</button>
                    </form>
                </div>


                {{-- Admin Dashboard Link --}}
                @if(auth()->user() && (auth()->user()->is_admin ?? false))
                    <div class="ProfileCard" style="padding: 20px 32px;">
                        <a href="{{ route('admin.dashboard') }}" class="AdminLink">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Go to Admin Dashboard
                        </a>
                    </div>
                @endif

                {{-- Logout --}}
                <div class="ProfileCard logout-card">
                    <div class="logout-info">
                        <h2 style="border-bottom:none;padding-bottom:0;margin-bottom:4px;">Sign Out</h2>
                        <p>You will be logged out of your account on this device.</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ProfileBtnOutline">Log Out</button>
                    </form>
                </div>

                {{-- Delete Account --}}
                @unless(auth()->user()->is_admin)
                <div class="ProfileCard danger-card">
                    <h2>Delete Account</h2>
                    <p>Once your account is deleted, all data will be permanently removed. This cannot be undone.</p>
                    <form class="ProfileForm" method="POST" action="{{ route('profile.destroy') }}"
                          onsubmit="return confirm('Delete your account? This cannot be undone.');">
                        @csrf
                        @method('DELETE')

                        <div>
                            <label for="del_password">Confirm Your Password</label>
                            <input id="del_password" name="password" type="password" autocomplete="current-password">
                            @error('password', 'userDeletion') <p style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="ProfileBtnDanger">Delete My Account</button>
                    </form>
                </div>
                @endunless
            </div>
        </div>

        @include('partials.footer')
    </div>
</body>
</html>


