<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/user.css') }}"> --}}

       @include('user::includes.userHead')

    </head>
    <body>
        @include('user::includes.userNav')
        <br>

            @include('user::includes.userMain')


            @include('user::includes.userFooter')
        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/user.js') }}"></script> --}}
    </body>
</html>
