

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Task Master</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav lead">
      <a class="nav-item nav-link active" href="{{ route('taskmasterHome') }}">Home <span class="sr-only">(current)</span></a>
   

        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="fas fa-file-pdf"></i> Reports

            </a>

            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('projectReport') }}">
                    {{ __('Projects') }}
                </a>

                <a class="dropdown-item" href="{{ route('changePasswordTaskMaster') }}">
                     {{ __('Tasks') }}
                </a>

            </div>
        </li>
                           
    </div>

    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> Welcome, 
                                {{ Auth::user()->userDetail->first_name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('viewProfile') }}">
                                    <i class="fas fa-user-circle"></i> {{ __('View Profile') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('changePasswordTaskMaster') }}">
                                    <i class="fas fa-lock"></i> {{ __('Change Password') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
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