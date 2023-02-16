<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow @yield('sidebar-size')" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('dashboard.index') }}">
                    <span class="brand-logo">
                        <img
                            src="{{ Storage::disk('minio')->temporaryUrl('assets/logo-mini.png', Carbon\Carbon::now()->addMinutes(20)) }}" />
                    </span>
                    <span class="brand-text d-flex flex-column" style="width: 120px;">
                        <small style="font-size: 15px;">E-comerce</small>
                    </span>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header">
            </li>
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dashboard.index') }}">
                    <i data-feather="home"></i><span class="menu-title text-truncate">Dashboard</span>
                </a>
            </li>
            @roles(['USER' , 'ADMIN'])
            <li class="navigation-header">
                <span>Management Account</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ request()->is('master/user') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('user.index') }}">
                    <i data-feather="user"></i><span class="menu-title text-truncate">Profile</span>
                </a>
            </li>
            @endroles

            @roles(['ADMIN'])
            <li class="navigation-header">
                <span>User Management</span><i data-feather="more-horizontal"></i>
            </li>

            <li class="nav-item {{ request()->is('master/admin') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('admin.index') }}">
                    <i data-feather="user"></i><span class="menu-title text-truncate">Admin</span>
                </a>
            </li>
            @endroles

            @roles(['ADMIN'])

            <li class="navigation-header">
                <span>Product Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ request()->is('master/item') || request()->is('master/item/*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('item.index') }}">
                    <i data-feather="{{ request()->is('master/item') ? 'stop-circle' : 'circle' }}"></i><span
                        class="menu-title text-truncate">Produk</span>
                </a>
            </li>
            @endroles

            @roles(['USER'])
            <li class="navigation-header">
                <span>Activity</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ request()->is('buy/items') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('items.index') }}">
                    <i data-feather="{{ request()->is('buy/items') ? 'stop-circle' : 'circle' }}"></i><span
                        class="menu-title text-truncate">Produk</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('buy/items/history') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('items.history') }}">
                    <i data-feather="{{ request()->is('buy/items/history') ? 'stop-circle' : 'circle' }}"></i><span
                        class="menu-title text-truncate">Riwayat Pesanan</span>
                </a>
            </li>
            @endroles
        </ul>
    </div>
</div>

{{-- <li class="nav-item {{ request()->is('master/tool') ? 'active' : '' }}">
<a class="d-flex align-items-center" href="{{ route('tool.index') }}">
    <i data-feather='stop-circle'></i></i><span class="menu-title text-truncate">Alat & Bahan</span>
</a>
</li> --}}
