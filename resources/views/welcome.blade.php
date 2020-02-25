<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/font.googleapis.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.10.2-web/css/all.css') }}">

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link href="{{ asset('fullcalendar/packages/core/main.css') }}" rel='stylesheet' />
        <link href="{{ asset('fullcalendar/packages/daygrid/main.css') }}" rel='stylesheet' />
        <link href="{{ asset('fullcalendar/packages/timegrid/main.css') }}" rel='stylesheet' />
        <link href="{{ asset('fullcalendar/packages/list/main.css') }}" rel='stylesheet' />


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
    </head>
    
    <body style="background-color: #DCDCDC;">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="container" style="margin-top: 50px; margin-bottom: 150px;">
                <div class="form-row col-md-12 justify-content-center">
                    <div class="alert alert-success alert-block">
                        <strong>Your Account is Not Yet Activated, Please fill-up the form to Activate your Account!</strong>
                    </div>
                    <div class="form-row col-md-6" style="margin-top: 30px;">
                        <div class="form-row col-md-12 justify-content-center" style="background-color: #000; color: #fff; padding:5px 0px; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                            <h5>User Details</h5>
                        </div>
                        <form class="form-row col-md-12 justify-content-center" style="background-color: #fff; padding:50px 50px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                            <div class="form-row col-md-12">
                                <div class="col-md-12" style="border:1px solid; width: 100%; height: 200px;">
                                    <img src="{{ asset('images/default-profile.png') }}" id="profPic" style="width: 100%; height: 100%;">
                                </div>
                                <div class="col-md-12">
                                    <input type='file' name="files" accept='image/*' onchange='openFile(event)' id="files" hidden>
                                    <center>
                                        <button type="button" class="btn btn-primary" id="upBtn">Upload Picture</button>
                                    </center>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <br>
                                <input type="text" class="form-control" id="exampleInputPassword1" max="25" required="" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="exampleInputPassword1" max="25" required="" required="" placeholder="Middle Name">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="exampleInputPassword1" max="25" required="" required="" placeholder="Last Name">
                            </div>
                        </form>
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
