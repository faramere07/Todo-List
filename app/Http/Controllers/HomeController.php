<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\UserDetail;
use App\User;
use Redirect;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }
    public function unauthorized()
    {
        return view('unauthorize');
    }

    public function userDetails(Request $request){


        $this->validate($request, [
        'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:8'
        ]);
        
        $user = User::find(Auth::id());
        $picture = 'default-profile.png';

        if($request->file('files') != ""){
            $file = $request->file('files');
            $picture = $file->getClientOriginalName();
            $file->move(base_path('\public\images'), $picture);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        UserDetail::create([
            'user_id' => Auth::id(),
            'first_name' => $request->get('first_name'),
            'mid_name' => $request->get('mid_name'),
            'last_name' => $request->get('last_name'),
            'profile_picture' => $picture,
        ]);

        if($user->type_id == '1'){
            return redirect()->route('Admin');     
        }
        elseif($user->type_id == '2') 
        {
            return redirect()->route('TaskMaster');
        }
        elseif($user->type_id == '3')
        {
            return redirect()->route('User');
        }
    }
}
