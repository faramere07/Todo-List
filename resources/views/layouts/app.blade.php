<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>TodoList</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ asset('css/font.googleapis.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.10.2-web/css/all.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('fullcalendar/packages/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/packages/daygrid/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/packages/timegrid/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/packages/list/main.css') }}" rel='stylesheet' />

    <link rel="icon" href="{{ asset('MDB/img/mdb-favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('MDB/css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ asset('MDB/css/style.css') }}">

    <script src="{{ asset('js/bootstrap.min.js') }}" ></script>
    <script src="{{ asset('js/jquery-3.4.1.slim.min.js') }}" ></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>
    <script src="{{ asset('js/popper.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/packages/core/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/packages/interaction/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/packages/daygrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/packages/timegrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/packages/list/main.js') }}"></script>
    <script src="{{ asset('js/filereader.js-master/filereader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('MDB/js/mdb.min.js') }}"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>

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
            @yield('content')
        </main>
    </div>
</body>
</html>
