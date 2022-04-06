<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm ">
    <div class="container">
        <a class="navbar-brand text-uppercase font-weight-bold" href="{{ url('/') }}">
            REP
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
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
                    <a class="nav-link @if (request()->routeIs('materias.index'))active @endif"
                        href="{{ route('materias.index') }}" aria-haspopup="true"
                        aria-expanded="false">{{ __('Materias') }} </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('usuarios.index'))active @endif"
                        href="{{ route('usuarios.index') }}" aria-haspopup="true"
                        aria-expanded="false">{{ __('Usuarios') }} </a>
                </li>
                @endcan
                @endguest
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @auth
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge badge-light">+99</span>
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
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-uppercase" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="bi bi-person-circle"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <h6 class="dropdown-header">{{ Auth::user()->name }} <span class="caret"></span> </h6>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-in-right"></i>
                            {{ __('Cerrar sesión') }}
                        </a>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav