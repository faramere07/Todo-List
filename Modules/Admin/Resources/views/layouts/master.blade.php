<!DOCTYPE html>
<html lang="en">
       @include('admin::includes.adminHead')
    <body>
        @include('admin::includes.adminNav')

        @include('admin::includes.adminMain')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/admin.js') }}"></script> --}}
    </body>
</html>
