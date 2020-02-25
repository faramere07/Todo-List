<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Modules\Admin\Entities\UserDetail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        $activate = UserDetail::where('user_id',Auth::id())->first();

        if(empty($activate)){
            return route('Activation');
        }else{
            if(auth()->user()->type_id == '1'){
                return route('Admin');     
            }
            elseif (auth()->user()->type_id == '2') 
            {
                return route('TaskMaster');
            }
            elseif (auth()->user()->type_id == '3')
            {
                return route('User');
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }
}
