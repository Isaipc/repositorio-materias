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
                @can('catalogos-menu')
                <li class="nav-item">
                    @if (request()->routeIs('materias.*'))
                    <a class="nav-link active" href="{{ route('materias.index') }}" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bi bi-collection-fill"></i>
                        {{ __('Materias') }} </a>
                    @else
                    <a class="nav-link" href="{{ route('materias.index') }}" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-collection"></i>
                        {{ __('Materias') }} </a>
                    @endif
                </li>

                <li class="nav-item">
                    @if (request()->routeIs('usuarios.*'))
                    <a class="nav-link active" href="{{ route('usuarios.index') }}" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-people-fill"></i> {{ __('Usuarios') }} </a>
                    @else
                    <a class="nav-link" href="{{ route('usuarios.index') }}" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-people"></i> {{ __('Usuarios') }} </a>
                    @endif
                </li>
                @endcan
                @endguest
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item me-3">
                    <a href="" class="btn btn-primary btn-md position-relative">
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
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <h6 class="dropdown-header">{{ Auth::user()->name }} <span class="caret"></span> </h6>

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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