<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm ">
    <div class="container">
        <a class="navbar-brand text-uppercase font-weight-bold p-0" href="{{ url('/') }}">
            <img src="{{ asset('img/isc.svg') }}" height="56px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @guest
                @else
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('home')) active @endif" href="{{ route('home') }}"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bi @if (request()->routeIs('home')) bi-house-fill @else bi-house @endif"></i>
                            {{ __('Inicio') }} </a>
                    </li>
                    @can('catalogos-menu')
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('materias*')) active @endif"
                                href="{{ route('materias.index') }}" aria-haspopup="true" aria-expanded="false">
                                <i class="bi @if (request()->is('materias*')) bi-collection-fill @else bi-collection @endif"></i>
                                {{ __('Materias') }} </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('usuarios*')) active @endif"
                                href="{{ route('usuarios.index') }}" aria-haspopup="true" aria-expanded="false">
                                <i class="bi @if (request()->is('usuarios*')) bi-people-fill @else bi-people @endif"></i>
                                {{ __('Alumnos') }} </a>
                        </li>
                    @endcan
                @endguest
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item me-3">
                        <a href="" class="btn btn-primary btn-md position-relative" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Notificaciones">
                            <i class="bi bi-bell-fill"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                99+
                                <span class="visually-hidden"></span>
                            </span>
                        </a>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="btn btn-primary dropdown-toggle text-uppercase" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->nombre }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item">
                                    <i class="bi bi-envelope-fill"></i>
                                    {{ Auth::user()->email }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="bi bi-door-closed"></i>
                                    {{ __('Cerrar sesión') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav
