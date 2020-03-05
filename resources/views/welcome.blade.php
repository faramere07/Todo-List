    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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
    
    <body style="background-color: #030621;">

        <div class="flex-center position-ref full-height">
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
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
                                    {{ Auth::user()->username }} <span class="caret"></span>
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
            </nav>
            <div class="container" style="margin-top: 80px; margin-bottom: 150px;">
                <div class="form-row col-md-12 justify-content-center">
                    <div class="alert alert-success alert-block">
                        <strong>Your Account is Not Yet Activated, Please fill-up the form to Activate your Account!</strong>
                    </div>
                    <div class="form-row col-md-6">
                        <div class="card">
                            <h5 class="card-header white-text text-center py-4" style="background-color: #1b2d69;">
                                <strong>User Details</strong>
                            </h5>
                            <br>
                            <div class="card-body px-lg-5 pt-0">
                                <form class="text-center" style="color: #757575;" method="POST" action="{{ route('Activate') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row col-md-12">
                                        <center>
                                            <div class="col-md-10" style="border:1px solid; height: 250px;">
                                                <img src="{{ asset('images/default-profile.png') }}" id="profPic" style="width: 90%; height: 100%;"><br>
                                            </div>
                                            <div class="col-md-12">
                                                <input type='file' name="files" accept='image/*' onchange='openFile(event)' id="files" hidden>
                                                <center>
                                                    <br>
                                                    <button type="button" class="btn btn-outline-dark" id="upBtn">Upload Picture</button>
                                                </center>
                                            </div>
                                        </center>
                                    </div>
                                    <div class="md-form mt-1">
                                        <input type="text" id="materialRegisterFormFirstName" class="form-control" name="first_name" max="25" required="">
                                        <label for="materialRegisterFormEmail">First Name</label>
                                    </div>
                                    <div class="md-form mt-1">
                                        <input type="text" id="materialRegisterFormMiddleName" class="form-control" name="mid_name" max="25" required="">
                                        <label for="materialRegisterFormEmail">Middle Name</label>
                                    </div>
                                    <div class="md-form mt-1">
                                        <input type="text" id="materialRegisterFormLastName" class="form-control" name="last_name" max="25" required="">
                                        <label for="materialRegisterFormEmail">Last Name</label>
                                    </div>
                                    <div class="md-form mt-1">
                                        <input type="password" id="materialRegisterFormPassword" class="form-control @error('password') is-invalid @enderror" name="password" max="25" required="" autocomplete="new-password">
                                        <label for="materialRegisterFormEmail">Password</label>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="md-form mt-1">
                                        <input type="password" id="materialRegisterFormPassword" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" max="25" required="" autocomplete="new-password">
                                        <label for="materialRegisterFormEmail">Confirm Password</label>

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-row col-md-12">
                                        <div class="col-md-2"></div>
                                        <button type="submit" class="btn btn-outline-dark col-md-8">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    $(document).on('click','#upBtn',function(event){
        $('#files').click();
    });

    var openFile = function(event) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function(){
          var dataURL = reader.result;
          var output = document.getElementById('profPic');
          output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    };

</script>
