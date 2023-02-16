<div class="pb-2 px-0">
    <nav style="padding: 0rem 0.5rem 0rem 0rem;" class="navbar navbar-expand-lg navbar-light bg-white navbar-shadow">
        <div class="container-fluid" style="margin: 0.25rem">
            <img src="{{ Storage::disk('minio')->temporaryUrl('assets/logo-mini.png', Carbon\Carbon::now()->addMinutes(20)) }}"
                height="50" />
            </a>
            <ul class="navbar-nav mx-75 navbar-right">
                <li class="nav-item">
                    <a class="nav-link fw-bolder text-primary" style="font-size: 20px;" href=" {{ url('/') }} ">
                        <small>E-Commerce</small>
                        </span>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav text-center">
                    <li class="mx-25 nav-item {{ request()->is('/') ? 'active-text' : '' }}">
                        <a class="nav-link" href=" {{ route('home') }} ">Beranda</a>
                    </li>
                    <li
                        class="mx-25 nav-item {{ request()->is('item') || request()->is('item/*') ? 'active-text' : '' }}">
                        <a class="nav-link" href="{{ route('home.item') }}">Produk</a>
                    </li>
                    @if (Auth::check())
                        <li class="mx-25 nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name ?? 'Unknown' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.index') }}">
                                        Dashboard
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ empty(Auth::user()->is_local) ? route('saml2_logout', 'unjani') : url('api/logout') }}">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="mx-25 nav-item">
                            <a class="nav-link" href="{{ url('login') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>

<style>
    .active-text {
        font-weight: 800;
    }

    .active-text>a {
        color: #163485 !important;
    }

    @media screen and (max-width: 990px) {
        .dropdown-menu {
            text-align: center;
        }
    }
</style>
