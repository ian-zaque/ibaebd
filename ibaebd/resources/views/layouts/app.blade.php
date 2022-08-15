<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="imagens/logo_iba.png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Igreja Batista Alvorada' }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script> var laravel = @json(['baseURL' => url('/')])
    </script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="imagens/logo_iba.png" width="30px" height="17px" class="img-fluid float-left">
                    {{ 'Igreja Batista Alvorada' }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                            @if (Route::has('register'))
                                <p></p>
                            @endif
                            @else
                                {{-- <a class="nav-link" href="{{ url('/manha_divertida') }}">Manhã Divertida</a> --}}
                                {{-- <a class="nav-link" href="{{ url('/socasais') }}">Só Pra Casais</a>
                                <a class="nav-link" href="{{ url('/ebd') }}">EBD Discipuladora</a> --}}
                                {{-- <a class="nav-link" href="{{ url('/cafe_comunhao') }}">Café & Comunhão</a> --}}
                                <a class="nav-link" href="{{ url('/ebd_musicos') }}">EBD Músicos</a>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            @yield('content')
        </main>
        <br>
        <footer id="myFooter">
            <div class="container d-flex justify-content-center">
                <ul>
                    <li><a href="https://goo.gl/maps/jyoeMtAzZ6RCRbzNA">Localização da Igreja</a></li>
                    <li><a href="https://linktr.ee/ibaalvorada">Informações</a></li>
                </ul>
            </div>
            <div class="container d-flex justify-content-center">
                <p style="font-size:10px;">
                    E, assim, se alguém está em Cristo, é nova criatura; 
                    as coisas antigas já passaram; eis que se fizeram novas. 2 Coríntios 5:17
                </p>
            </div>
            <div class="footer-social">
                <a href="https://www.facebook.com/pages/Igreja-Batista-Alvorada/167492596640760" class="social-icons"><i class="soc fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/ibaalvorada/?hl=pt-br" class="social-icons"><i class="soc fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UC0xxjnoM2erw-d1X9rUWcFA" class="social-icons"><i class="soc fab fa-youtube"></i></a>
            </div>
        </footer>
    </div>
</body>
</html>
<style>
    .hide {
        display: none;
    }

    .myDIV:hover + .hide {
        display: block;
        color: red;
    }
</style>
