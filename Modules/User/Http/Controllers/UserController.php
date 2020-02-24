<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


use Modules\TaskMaster\Entities\Project;
use Modules\TaskMaster\Entities\Tasks;
use Modules\Admin\Entities\TaskType;
use App\User;
use Modules\Admin\Entities\UserDetail;
use Modules\Admin\Entities\UserType;
use Auth;

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

      $id =  Auth::id();
      $userDetails = UserDetail::where('user_id', $id)->first();
      $user = User::find($id);
      if (Hash::check('123123123', $user->password)) {
        return view('user::updateProfile', compact('userDetails'));
      } else{
        return view('user::index', compact('userDetails'));
      }

    
    }

    //Update User Details

    public function updateUserDetailsUsers (Request $request){
        $user = User::find(Auth::id());
        $userDetails = UserDetail::where('user_id', Auth::id())->first();

        if($request->image != null){
          $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);
        $userDetails->profile_picture = $imageName;
        }

        $userDetails->first_name= $request->firstName;
        $userDetails->mid_name = $request->midName;
        $userDetails->last_name =$request->lastName;
        $userDetails->save();


        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('userHome');

    }

    public function changePassword()
    {
        return view('user::changePassword');
        
    }

    public function savePassword(Request $request)
    {
        $message = array(
            'password.min' => 'Please input atleast 6 characters',
            'password.confirmed' => 'Password does not match',
           
        );
        $request->validate( [
            'password' => 'sometimes|string|min:6|confirmed',

        ], $message);

        $id =  Auth::id();

        $user = User::find($id);
        $user->password =Hash::make($request->password);
        $user->save();

        // return view('admin::index')->with('success', 'User Updated');
        return redirect()
            ->route('userHome')
            ->with('success', 
    'Password Changed');
        
    }

}
