<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use Modules\Admin\Entities\UserDetail;
use Modules\Admin\Entities\UserType;
use Modules\Admin\Entities\TaskType;
use Modules\TaskMaster\Entities\Tasks;
use Modules\TaskMaster\Entities\Project;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Auth;
use Session;
use Redirect;
use PDF;

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
            $details = Tasks::with(['project','project.user.userDetail','taskType','user.userDetail'])->find($request->get('taskid'));

            $result = "
                        <div class='input-group mb-3'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text' id='basic-addon1'>Start Date and Time</span>
                          </div>
                          <input type='text' class='form-control' placeholder='Username' aria-label='Username' aria-describedby='basic-addon1'>
                        </div>
                        <div class='input-group mb-3'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text' id='basic-addon1'>Start Time</span>
                          </div>
                          <input type='text' class='form-control' placeholder='Username' aria-label='Username' aria-describedby='basic-addon1'>
                        </div>
                        <div class='input-group mb-3'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text' id='basic-addon1'>Start Time</span>
                          </div>
                          <input type='text' class='form-control' placeholder='Username' aria-label='Username' aria-describedby='basic-addon1'>
                        </div>
                        <div class='input-group mb-3'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text' id='basic-addon1'>Start Time</span>
                          </div>
                          <input type='text' class='form-control' placeholder='Username' aria-label='Username' aria-describedby='basic-addon1'>
                        </div>
                        <div class='input-group mb-3'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text' id='basic-addon1'>Start Time</span>
                          </div>
                          <input type='text' class='form-control' placeholder='Username' aria-label='Username' aria-describedby='basic-addon1'>
                        </div>
            ";

            
                        
            echo $result;
    }

    public function viewUsers()
    {
        $user_types = UserType::all();

        return view('admin::users', compact('user_types'));
    }

    public function viewTaskTypes()
    {
        $taskTypes = TaskType::all();

        return view('admin::taskTypes');
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
                    </button>
                    <button class="btn btn-outline-info col-md-5 view" userId="'.$user->id.'">
                        <i class="fas fa-eye"></i>
                    </button>

                    </a>
                            ';
                })
            ->rawColumns(['actions'])
            ->make(true);
    }
     public function usersShowReport(){
        $users = UserDetail::join('users', 'users.id', 'user_details.user_id')
                ->join('user_types', 'user_types.id', 'users.type_id')
                ->where('type_id', '!=', 1)
                ->select('*','user_details.id as ud_id')
                ->get();
                //  ->addColumn('first_name', function($user){
                // $details = UserDetail::where('user_id', $user->id)->first();
                // if($details){
                //     return $details->first_name;
                // }else{
                //     return 'to be filled';
                // }
              
         // $users = DB::table('user')->get();
         // dd($users);

         return DataTables::of($users)
            ->addColumn('actions', function($user) {
                    return '<button class="btn btn-outline-danger float-right col-md-5 mx-2 destroy" userId="'.$user->id.'" fname="'.$user->firstName.'">Delete</button>
                            <button class="btn btn-outline-info col-md-5 edit" userId="'.$user->id.'">Edit</button>
                            ';
                })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function taskShow()
    {
        $types = TaskType::all();

        return DataTables::of($types)
            ->addColumn('actions', function($type) {
                    return '
                    <button class="btn btn-outline-danger float-right col-md-5 mx-2 destroy" typeId="'.$type->id.'">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-outline-info col-md-5 edit" typeId="'.$type->id.'">
                        <i class="fas fa-edit"></i>
                    </button>';
                })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function editTaskType(Request $request)
    {
        $types = TaskType::where('id', $request->id)->first();
        echo
                ' 
                <div class="form-row col-md-12 justify-content-center">
                    <div class="form-group col-md-12">
                      <label>Type Name</label>
                      <input type="text" class="form-control" name="type_name" max="25" value="'.$types->type_name.'" required>
                      <input type="hidden" class="form-control" name="id" max="25" value="'.$types->id.'" required>
                    </div>
                    <div class="form-group col-md-12">
                      <label>Type Description</label>
                      <textarea class="form-control" name="type_desc" rows="3" cols="50">'.$types->type_desc.'</textarea>
                    </div>
                </div>
                ';

    }

    public function viewUserDetails(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $userDetail = UserDetail::where('user_id', $request->id)->first();
        echo
                ' 
                <div class="form-row col-md-12 justify-content-center">
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input type="text" class="form-control" name="type_name" max="25" value="'.$user->name.'" required>
                      <input type="hidden" class="form-control" name="id" max="25" value="'.$userDetails->id.'" required>
                    </div>
                    <div class="form-group col-md-12">
                      <label>Type Description</label>
                      <textarea class="form-control" name="type_desc" rows="3" cols="50">'.$userDetails->name.'</textarea>
                    </div>
                </div>
                ';

    }

    public function updateTaskType(Request $request){
        $types = TaskType::where('id', $request->id)->first();

        $types->type_name = $request->type_name;
        $types->type_desc = $request->type_desc;
        $types->save();

        return redirect()->route('viewTaskTypes')->with('message', "Task Type successfully updated!");
    }

    public function addUser(Request $request)
    {
        $username = User::where('username',$request->get('username'))->first();

        if(empty($username)){
            User::firstOrCreate([
                'password' => Hash::make($request->get('password')),
                'username' => $request->get('username'),
                'type_id' => $request->get('type_id'),
            ]);

            Session::flash('message', "New User Added!");
        }else{
            Session::flash('error', "Failed to add User, Username already Exists!");
        }

        return Redirect::back();
    }

    public function addTaskType(Request $request)
    {
        $type = TaskType::where('type_name',$request->get('type_name'))->first();

        if(empty($type)){
            TaskType::firstOrCreate([
                'type_name' => $request->get('type_name'),
                'type_desc' => $request->get('type_desc'),
            ]);

            Session::flash('message', "New Task Type Added!");
        }else{
            Session::flash('error', "Failed to add Task Type, Task Type already Exists!");
        }

        return Redirect::back();
    }

    public function destroyType(Request $request)
    {
        $type = TaskType::find($request->id);
        $type->delete();
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


    public function viewProfileAdmin(){

      $id =  Auth::id();
      $userDetails = UserDetail::where('user_id', $id)->first();

        return view('admin::viewProfile', compact('userDetails'));
    }

    
    public function editProfileAdmin(Request $request)
    {
        $userDetails = UserDetail::where('user_id', Auth::id())->first();

        echo '
        <div class="form-row">
        <div class="col-md-4">
        <label class="small" for="fname">First Name</label>
            <input name="fname" class="form-control" type="text" value="'.$userDetails->first_name.'">
        </div>

        <div class="col-md-4">
        <label class="small" for="mname">Middle Name</label>
            <input name="mname" class="form-control" type="text" value="'.$userDetails->mid_name.'">
        </div>

        <div class="col-md-4">
        <label class="small" for="lname">Last Name</label>
            <input required name="lname" class="form-control" type="text" value="'.$userDetails->last_name.'">
        </div>

        </div>
        ';


    }

    public function storeProfileAdmin(Request $request)
    {

        $userDetails = UserDetail::where('user_id', Auth::id())->first();

        $userDetails->first_name= $request->fname;
        $userDetails->mid_name = $request->mname;
        $userDetails->last_name =$request->lname;
        $userDetails->save();

        return redirect()->route('viewProfileAdmin')->with('success', 'Profile Updated');
    }

    public function viewReport(){
        return view('admin::viewUserReport');
    }

    public function userReport(Request $request){
        $gen = UserDetail::where('user_id', Auth::id())->first();
        $type = $request->select1;
        $min = $request->min;
        $max = $request->max;
        if($type){
            $query = UserDetail::join('users', 'users.id', 'user_details.user_id')
                ->join('user_types', 'user_types.id', 'users.type_id')
                ->where('type_name', $type)
                ->whereBetween('users.created_at', [$min, $max])
                ->select('*','user_details.id as ud_id')
                ->get();

             
        }else{
            $query = UserDetail::join('users', 'users.id', 'user_details.user_id')
                ->join('user_types', 'user_types.id', 'users.type_id')
                ->where('type_id', '!=', 1)
                ->whereBetween('users.created_at', [$min, $max])
                ->select('*','user_details.id as ud_id')
                ->get();

        }


     // dd($query);
        $pdf = PDF::loadView('admin::pdf.userReportPDF', compact('query', 'min', 'max' ,'type', 'gen'));

        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('users_.pdf');

        // return view('admin::pdf.userReportPDF', compact('query', 'min', 'max' ,'type', 'gen'));
    }

}
