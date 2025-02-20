<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #3AA597, #16423C);">
    <div class="container">
        <!-- Bagian Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo-donasi-woy.png') }}" alt="Logo" width="100%" height="50">
        </a>

        <!-- Toggle Button untuk Responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navbar -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav me-4 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link {{ request()->is('campaigns') ? 'active' : '' }}"
                        href="{{ route('campaigns.index') }}">Campaign</a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link {{ request()->is('news') ? 'active' : '' }}"
                        href="{{ route('news.index') }}">Berita</a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link {{ request()->is('cara-donasi') ? 'active' : '' }}"
                        href="{{ route('cara-donasi') }}">Cara Donasi</a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link" href="#">Petisi</a>
                </li>

            </ul>
            @auth
                <div class="dropdown">
                    <a class="nav-link text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->fullname }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn"
                    style="background-color: #c5f5e7; color: #000; margin-right: 10px;">Login</a>
                <a href="{{ route('register') }}" class="btn"
                    style="border: 2px solid #c5f5e7; color: #c5f5e7;">Register</a>
            @endauth
        </div>

    </div>
</nav>
