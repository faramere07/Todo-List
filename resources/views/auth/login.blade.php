@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header white-text text-center py-4" style="background-color: #0b3a80;">
                    <strong>Login</strong>
                </h5>

                <div class="card-body col-md-12 pt-0">
                    <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="md-form">
                            <input type="text" id="materialLoginFormUserName" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            <label for="materialLoginFormEmail">Username</label>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="md-form">
                            <input type="password" id="materialLoginFormPassword" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="current-password">
                            <label for="materialLoginFormEmail">Password</label>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-outline-primary btn-block my-4 z-depth-0" type="submit">Login</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
