{{-- @php
$url = url()->current();
$exp = explode('/', $url);
$url = array_slice($exp, 3);
@endphp --}}

<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons align-items-center">
                @if (trim($__env->yieldContent('url_back')))
                    <li class="nav-item d-none d-lg-block">
                        <a href="@yield('url_back')" class="fw-bold bg-danger text-white d-flex avatar"
                            style="width:30px;height:30px">
                            <i class="m-auto" data-feather="chevron-left"></i></a>
                    </li>
                @else
                    <li class="nav-item d-none d-lg-block">
                        <a href="{{ url('') }}" class="fw-bold bg-danger text-white d-flex avatar"
                            style="width:30px;height:30px">
                            <i class="m-auto" data-feather="home"></i></a>
                    </li>
                @endif
                <li class="nav-item d-none d-lg-block">
                    <div class="ms-1 flex-column d-flex align-content-center justify-content-center">
                        <h4 class="h5 mb-0 fw-bolder">@yield('page_title')</h4>
                        <small class="mb-0">
                            @yield('breadcrumbs')
                            {{-- @foreach ($url as $key => $item)
                            {{ucwords($item)}} @if ($key != count($url) - 1)<span><i data-feather="chevron-right"></i></span>@endif
                            @endforeach --}}
                        </small>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            @if (Auth::user()->getPlaces() && count(Auth::user()->getPlaces()) > 0)
                <li class="nav-item dropdown dropdown-role"><a title="Lab Anda" class="nav-link dropdown-toggle"
                        id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="selected-role"><i data-feather="monitor" class="ficon"></i></span></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        @foreach (Auth::user()->getPlaces() as $place)
                            <a class="dropdown-item {{ Auth::user()->getCurrentPlace()->name == $place->name ? 'active-text' : '' }}"
                                href="{{ route('change-place', $place->id) }}">
                                <i data-feather="monitor" class="ficon me-1"></i>{{ $place->name }}
                            </a>
                            @if ($loop->iteration != count(Auth::user()->getPlaces()))
                                <div class="dropdown-divider"></div>
                            @endif
                        @endforeach
                    </div>
                </li>
            @endif
            <li class="nav-item dropdown dropdown-role me-50"><a title="Role Anda" class="nav-link dropdown-toggle"
                    id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="selected-role"><i data-feather="users" class="ficon"></i></span></a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                    @foreach (Auth::user()->getRoles() as $role)
                        <a class="dropdown-item {{ Auth::user()->getActiveRole()->name == $role->name ? 'active-text' : '' }}"
                            href="{{ route('change-role', $role->id) }}">
                            <i data-feather="user" class="ficon me-1"></i>{{ $role->name }}
                        </a>
                        @if ($loop->iteration != count(Auth::user()->getRoles()))
                            <div class="dropdown-divider"></div>
                        @endif
                    @endforeach
                </div>
            </li>
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span
                            class="user-name fw-bolder">{{ Auth::user()->name ?? 'Unknown' }}</span><span
                            class="user-status">{{ Auth::user()->getPlaces() && count(Auth::user()->getPlaces()) > 0 ? Auth::user()->getCurrentPlace()->name . ' - ' : '' }}{{ count(Auth::user()->getRoles()) > 0 ? Auth::user()->getActiveRole()->name : 'User' }}</span>
                    </div>

                    <span class="avatar">
                        @if (Auth::user()->photo)
                            <img class="round"
                                src="https://dev-cdn.unjani.co.id/hris/thumbs/{{ Auth::user()->photo }}" alt="avatar"
                                height="40" width="40" />
                        @else
                            <img class="round" src="{{ asset('themes/vuexy/images/portrait/small/avatar-s-0.jpg') }}"
                                alt="avatar" height="40" width="40">
                        @endif
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item"
                        href="{{ empty(Auth::user()->is_local) ? route('saml2_logout', 'unjani') : url('api/logout') }}"><i
                            class="me-50" data-feather="power"></i>Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<style>
    .active-text {
        font-weight: 800;
        color: #163485 !important;
    }

    .header-navbar .navbar-container ul.navbar-nav li .active-text svg.ficon,
    .header-navbar .navbar-container ul.navbar-nav li a:hover svg.ficon {
        color: #163485 !important;
    }
</style>
