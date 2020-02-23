
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Admin</title>
  
  <link href="{{ asset('css/font.googleapis.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.10.2-web/css/all.css') }}">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

     
  <script src="{{ asset('js/jquery-3.4.1.slim.min.js') }}" ></script>
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="{{ asset('js/popper.min.js') }}" ></script>
  <script src="{{ asset('js/bootstrap.min.js') }}" ></script>
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    
  

          

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/admin.css') }}"> --}}

       <style type="text/css">
           .alert {
              position: fixed;
              margin: auto;
              top: 0%;
              left: 0;
              right: 0;
              width: 50%;
              z-index: 9;
            }
       </style>
</head>
        