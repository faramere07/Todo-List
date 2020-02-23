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

        <hr><br><br><br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Update Account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateUserDetails') }}"  enctype="multipart/form-data">
                        @csrf


                        <input type="text" name="firstName" class="form-control mb-2 " placeholder="First Name" required >

                        <input type="text" name="midName" class="form-control mb-2 firstNameEdit" placeholder="Middle Name" required >
                      
                        <input type="text" name="lastName" class="form-control mb-2 lastNameEdit" placeholder="Last Name" required>

                        <input id="password" type="password"  placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        <label class="small">Image:</label>
                        <input type="file" name="image" class="form-control">

                        <hr>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 mt-4">
                                <button type="submit" class="btn btn-outline-primary col-md-12">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br>


            @include('taskmaster::includes.taskFooter')
        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/taskmaster.js') }}"></script> --}}
    </body>
</html>
