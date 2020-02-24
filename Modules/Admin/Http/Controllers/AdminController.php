<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use Modules\Admin\Entities\UserDetail;
use Modules\Admin\Entities\UserType;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Auth;


class AdminController extends Controller
{

    public function index()
    {

         $types = UserType::where('type_name','!=','Admin')->get();
         
        return view('admin::index', compact('types'));
    }

    public function usersShow(){
        //fixthis bruh
        $users = UserDetail::join('users', 'users.id', 'user_details.user_id')
                ->where('type_id', '!=', 1)
                ->select('*','user_details.id as ud_id')
                ->get();
              


        // $users = User::with('userDetail')->get();
              
         // $users = DB::table('user')->get();
    

         return DataTables::of($users)
            ->addColumn('actions', function($user) {
                    return '<button class="btn btn-outline-danger float-right col-md-5 mx-2 destroy" userId="'.$user->id.'" fname="'.$user->firstName.'">Delete</button>
                            <button class="btn btn-outline-info col-md-5 edit" userId="'.$user->id.'">Edit</button>
                            ';
                })
            ->rawColumns(['actions'])
            ->make(true);
    }

    

    public function editUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
// dd($user);
        $userDetail = UserDetail::where('user_id', $request->id)->first();


        echo
                ' 
             <p class="text-danger emptyUpdate"><em>*Please fill all information below.</em></p>
                <input type="hidden" name="id" id="peopleId" value="'.$user->id.'">

                 <input type="text" name="username" class="form-control mb-1 " placeholder="First Name" required id="firstNameAdd" value="'.$user->username.'">

                  <input type="text" name="firstName" class="form-control mb-1 " placeholder="First Name" required id="firstNameAdd" value="'.$userDetail->first_name.'">

                   <input type="text" name="midName" class="form-control mb-1 firstNameEdit" placeholder="Middle Name" required id="firstNameAdd" value="'.$userDetail->mid_name.'">
              
                  <input type="text" name="lastName" class="form-control lastNameEdit" placeholder="Last Name" required id="lastNameAdd" value="'.$userDetail->last_name.'">';

    }


    public function saveEditUser(Request $request)
    {
        $user = User::find($request->id);
        $user->username =  $request->username;
        
        $user->save();

        $userDetail = UserDetail::where('user_id', $request->id)->first();
        $userDetail->first_name =  $request->firstName;
        $userDetail->last_name =  $request->lastName;
        $userDetail->mid_name =  $request->midName;

        
        $userDetail->save();

       
    }


    public function destroyUser(Request $request)
    {
        $userDetail = UserDetail::where('user_id', $request->id)->first();
        $user = User::find($request->id);

        $userDetail->delete();
        $user->delete();

        
        // $this->pickDate($request);
    }

    public function changePassword()
    {
        return view('admin::changePassword');
        
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
            ->route('adminHome')
            ->with('success', 
    'Password Changed');
        
    }

}
