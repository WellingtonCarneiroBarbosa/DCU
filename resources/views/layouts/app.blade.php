<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('icons/css/font-awesome.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/black_app.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(auth()->user())
                    <ul class="navbar-nav mr-auto">
                        {{-- Tickets --}}
                        <li class="nav-item dropdown">
                            <a id="ticketsDropdown" class="nav-link dropdown-toggle {{ request()->routeIs('home*') ? 'active' : '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Tickets <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ticketsDropdown">
                                <a class="dropdown-item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Tickets em aberto</a>
                                <a class="dropdown-item" href="#">Tickets resolvidos</a>
                                <a class="dropdown-item" href="#">Gerenciar tickets</a>
                            </div>
                        </li>
        
                        {{-- Demandas --}}
                        <li class="nav-item dropdown">
                            <a id="demandsDropdown" class="nav-link dropdown-toggle {{ request()->routeIs('demands*') ? 'active' : '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Demandas <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="demandsDropdown">
                                <a class="dropdown-item {{ request()->routeIs('demands.index') ? 'active' : '' }}" href="{{ route('demands.index') }}">Gerenciar demandas</a>
                                <a class="dropdown-item {{ request()->routeIs('demands.create') ? 'active' : '' }}" href="{{ route('demands.create') }}">Cadastrar demanda</a>
                            </div>
                        </li>

                         {{-- Usuários --}}
                         <li class="nav-item dropdown">
                            <a id="usersDropdown" class="nav-link dropdown-toggle {{ request()->routeIs('users*') ? 'active' : '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Usuários <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usersDropdown">
                                <a class="dropdown-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Gerenciar usuários</a>
                                <a class="dropdown-item {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">Cadastrar usuário</a>
                            </div>
                        </li>

                        {{-- Sistemas --}}
                        <li class="nav-item dropdown">
                            <a id="systemsDropdown" class="nav-link dropdown-toggle {{ request()->routeIs('systems*') ? 'active' : '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Sistemas <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="systemsDropdown">
                                <a class="dropdown-item {{ request()->routeIs('systems.index') ? 'active' : '' }}" href="{{ route('systems.index') }}">Gerenciar sistemas</a>
                                <a class="dropdown-item {{ request()->routeIs('systems.create') ? 'active' : '' }}" href="{{ route('systems.create') }}">Cadastrar sistema</a>
                            </div>
                        </li>
                        

                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
        </nav>

        <main class="py-4">
            @if(session('error'))
                Ops.. {{ session('error') }}
            @endif
            @if(session('success'))
                {{ session('success') }}
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
