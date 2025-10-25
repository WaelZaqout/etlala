@php
    $u = $u ?? auth()->user();
    $name = trim($u?->name ?? '');
    $initials = null;
    if ($name !== '') {
        $parts = preg_split('/\s+/', $name);
        $tmp = '';
        foreach ($parts as $p) {
            $tmp .= mb_substr($p, 0, 1);
        }
        $initials = mb_strtoupper($tmp);
    }
@endphp

<div class="sidebar">
    <div class="profile-header">
        <div class="profile-avatar" onclick="showAvatarModal()">
            @if ($u?->avatar)
                <img id="sidebarProfilePreview" src="{{ asset('storage/' . $u->avatar) }}" alt="Avatar">
            @elseif ($initials)
                <div class="avatar-initials">{{ $initials }}</div>
            @else
                <i class="fas fa-user-circle"></i>
            @endif
        </div>

        <h3 class="profile-name">{{ $u?->name ?? 'مستخدم' }}</h3>
        <p class="profile-email">{{ $u?->email ?? '' }}</p>
    </div>

    <ul class="nav-menu">
        <li><a href="{{ route('profile') }}"
                class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"><i>💳</i> حسابي</a></li>
        <li><a href="{{ route('my.orders') }}"
                class="nav-link {{ request()->routeIs('my.orders') ? 'active' : '' }}"><i>📦</i> طلباتي</a></li>
        <li><a href="{{ route('profile.wishlist') }}"
                class="nav-link {{ request()->routeIs('profile.wishlist') ? 'active' : '' }}"><i>⭐</i> المفضلة</a></li>
        <li><a href="{{ route('settings') }}"
                class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}"><i
                    class="fas fa-cog"></i> الإعدادات</a></li>
        <li>
            <a href="{{ route('logout') }}" class="nav-link logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </li>
    </ul>

</div>

<!-- نافذة الصورة -->
<div id="avatarModal" class="avatar-modal">
    <span class="close" onclick="closeAvatarModal()">&times;</span>
    <img id="avatarModalImg" src="" alt="Avatar">
</div>

<!-- 🎨 CSS -->
<style>
    .sidebar {
        background: #fff;
        width: 260px;
        padding: 25px 20px;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        font-family: 'Cairo', sans-serif;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
    }

    .profile-avatar {
        position: relative;
        margin: 0 auto 12px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #007bff;
        cursor: pointer;
        background: #f4f4f4;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-size: 28px;
        color: #007bff;
        font-weight: bold;
    }

    .profile-name {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
    }

    .profile-role {
        color: #007bff;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .profile-email {
        font-size: 14px;
        color: #888;
    }

    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-menu li {
        margin-bottom: 8px;
    }

    .nav-link,
    .nav-menu li a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #333;
        padding: 10px 14px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .nav-link i,
    .nav-menu li a i {
        font-size: 16px;
    }

    .nav-link:hover,
    .nav-menu li a:hover {
        background-color: #f3f6ff;
        color: #007bff;
    }

    .nav-link.active {
        background-color: #007bff;
        color: #fff !important;
    }

    .logout {
        color: #d9534f !important;
    }

    .logout:hover {
        background: #f8d7da;
    }

    /* نافذة الصورة */
    .avatar-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    .avatar-modal img {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 0 20px #000;
    }

    .avatar-modal .close {
        position: absolute;
        top: 30px;
        right: 40px;
        color: #fff;
        font-size: 40px;
        cursor: pointer;
    }
</style>

<script>
    function showAvatarModal() {
        const imgSrc = document.getElementById('sidebarProfilePreview').src;
        document.getElementById('avatarModalImg').src = imgSrc;
        document.getElementById('avatarModal').style.display = 'flex';
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').style.display = 'none';
    }

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('avatarModal');
        if (modal && e.target === modal) {
            closeAvatarModal();
        }
    });
</script>
