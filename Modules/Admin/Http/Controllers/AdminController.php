<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use Modules\Admin\Entities\UserDetail;
use Modules\Admin\Entities\UserType;
use Modules\TaskMaster\Entities\Tasks;
use Modules\TaskMaster\Entities\Project;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Auth;
use Session;
use Redirect;

class AdminController extends Controller
{

    public function index()
    {

        $types = UserType::where('type_name','!=','Admin')->get();
        // $tasks = Tasks::with(['project','project.user.userDetail','taskType'])->get();
        // foreach ($tasks as $key) {
        //     # code...
        // }
        // dd($key->project->user->userDetail->first_name);
        return view('admin::index');
    }

    public function viewTask()
    {
        $tasks = Tasks::with(['project','project.user.userDetail','taskType','user.userDetail'])->get();

        return Datatables::of($tasks)
                ->addColumn('created', function($tasks){
                    $startTime = date('g:i A',strtotime($tasks->created_at));
                    $startDate = date('M j, Y',strtotime($tasks->created_at));
                    return $startDate."</br><small>".$startTime."</small>";
                })
                ->addColumn('due', function($tasks){
                    $endTime = date('g:i A',strtotime($tasks->date_time));
                    $endDate = date('M j, Y',strtotime($tasks->due_date));
                    return $endDate."</br><small>".$endTime."</small>";
                })
                ->addColumn('project', function($tasks){
                    $proj_name = "<b>".$tasks->project->project_name."</b>";
                    $creator_name = "<small>by: ".$tasks->project->user->userDetail->first_name." ".$tasks->project->user->userDetail->last_name."</small>";
                    return $proj_name."</br>".$creator_name;
                })
                ->addColumn('task', function($tasks){
                    $task_title = "<b>".$tasks->task_title."</b>";
                    if(empty($tasks->user->userDetail->first_name)){
                        $user_name = "<small>Task of: <i>(To be fill-up user details)</i></small>";
                    }else{
                        $user_name = "<small>Task of: ".$tasks->user->userDetail->first_name." ".$tasks->user->userDetail->first_name."</small>";
                    }
                    
                    return $task_title."</br>".$user_name;
                })
                ->addColumn('description', function($tasks){
                    return $tasks->status;
                })
                ->addColumn('actions', function($tasks) {
                    return '
                    <button class="btn btn-outline-info col-md-5 view taskview" taskid="'.$tasks->id.'">
                        <i class="fas fa-eye"></i>
                        <div class="buttonText2">
                            View
                        </div>
                    </button>';
                })
                ->rawColumns(['created','due','project','task','description','actions'])
                ->make(true);
    }

    public function taskDetails(Request $request){
            echo "lol";
    }

    public function viewUsers()
    {
        $user_types = UserType::all();

        return view('admin::users', compact('user_types'));
    }

    public function usersShow()
    {
        $users = User::with(['userDetail','userType'])->where('users.id','!=',Auth::id());

        return DataTables::of($users)
            ->addColumn('type_name', function($user){
                    return $user->userType->type_name;
                })
            ->addColumn('actions', function($user) {
                    return '
                    <button class="btn btn-outline-danger float-right col-md-5 mx-2 destroy" userId="'.$user->id.'">
                        <i class="fas fa-user-minus"></i>
                        <div class="buttonText">
                            Deactivate
                        </div>
                    </button>
                    <a class="btn btn-outline-info col-md-5 view" href="'.route('viewUser',$user->username).'">
                        <i class="fas fa-eye"></i>
                        <div class="buttonText2">
                            View
                        </div>
                    </a>
                            ';
                })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function addUser(Request $request)
    {
        $username = User::where('username',$request->get('username'))->first();

        if(empty($username)){
            User::create([
                'password' => Hash::make($request->get('password')),
                'username' => $request->get('username'),
                'type_id' => $request->get('type_id'),
            ]);

            Session::flash('message', "New User Added!");
        }else{
            Session::flash('message', "Failed to add User, Username already Exists!");
        }

        return Redirect::back();
    }

    public function viewUser($id){
        $users = User::with('userType')->where('users.username',$id)->first();
       
        return view('admin::userProfile',compact('users'));
    }

    public function editUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
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
        return redirect()->route('adminHome')->with('success','Password Changed');
        
    }

}
