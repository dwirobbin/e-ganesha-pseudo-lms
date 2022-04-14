<div class="container">
    <header>
        <nav>
            <ul class="nav__links">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pt-0" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome Back {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                @if (Auth::user()->hasRole('Admin'))
                                    <a class="dropdown-item" href="{{ url('dashboard/admin') }}">
                                        My Dashboard
                                    </a>
                                @elseif (Auth::user()->hasRole('Teacher'))
                                    <a class="dropdown-item" href="{{ url('dashboard/courses') }}">
                                        My Dashboard
                                    </a>
                                @elseif (Auth::user()->hasRole('Student'))
                                    <a class="dropdown-item" href="{{ url('dashboard/courses') }}">
                                        My Dashboard
                                    </a>
                                @endif
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                @if (!Auth::user()->hasRole('Student'))
                                    <form action="{{ url('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            Logout
                                        </button>
                                    </form>
                                @endif
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="{{ Request::is('login*') ? 'active' : '' }}" href="{{ url('login') }}">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
    </header>
</div>

<div class="header-info">
    <div class="profil">
        <div class="round" id="logo">
            <a class="navbar-brand {{ Request::is('home') ? 'active' : '' }}" href="{{ url('/') }}">
                <img src="{{ asset('frontend/img/ganesha.jpg') }}" alt="" />
            </a>
        </div>
        <h2>{{ config('app.name') }}</h2>
    </div>

    <div class="dropdown">
        <nav class="ddwn">
            <ul>
                @if (auth()->user())
                    @if (!Auth::user()->hasRole('Admin'))
                        <li>
                            <a href="{{ url('dashboard/courses') }}">Beranda</a>
                        </li>
                    @elseif (auth()->user()->hasRole('Admin'))
                        <li>
                            <a href="{{ url('dashboard/admin') }}">Beranda</a>
                        </li>
                    @endif
                @endif
                <li>
                    <a href="#">Information</a>
                    <ul>
                        <li><a href="#">Perkuliahan</a></li>
                        <li><a href="#">Sistem Pembelajaran</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">About</a>
                    <ul>
                        <li><a href="#">Sejarah E-Ganesha</a></li>
                        <li><a href="#">Tentang E-Ganesha</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
