<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task Master</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/taskmaster.css') }}"> --}}

       @include('taskmaster::includes.taskHead')

    </head>
    <body>
        @include('taskmaster::includes.taskNav')
            <div class="mt-4">
            @include('taskmaster::includes.taskMain')
            </div>

            @include('taskmaster::includes.taskFooter')
        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/taskmaster.js') }}"></script> --}}
    </body>
</html>
