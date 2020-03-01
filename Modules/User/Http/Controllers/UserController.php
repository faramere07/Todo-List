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
use Carbon\Carbon;
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
      $taskDetails = Tasks::where('user_id', $id)->where('status', 'ongoing')->count();
      $user = User::find($id);

        return view('user::index', compact('userDetails', 'taskDetails', 'user'));
      
    
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

    public function user_dtb(){

        $tasks = Tasks::with(['project','taskType'])->where('user_id', Auth::id())
        ->get();
                   
         return DataTables::of($tasks)
            ->addColumn('task_name', function($task) { 
                return $task->taskType->type_name;
            })
            ->addColumn('actions', function($task) {    
                if($task->status == "Ongoing"){
                    return '<button class="btn btn-outline-info details" taskId="'.$task->id.'">Details</button>
                            <button class="btn btn-outline-primary finish" taskId="'.$task->id.'">Finish</button>';
                }else{
                    return '<button class="btn btn-outline-info details" taskId="'.$task->id.'">Details</button>';
                }
                })
            ->rawColumns(['actions','task_name'])
            ->make(true);
    }

    public function taskDetails(Request $request)
    {

        $taskDetail = Tasks::with(['project','taskType'])->where('id', $request->id)->first();


        echo
                ' 
                <div class="form-row">
                    <div class="col-md-8">
                <label class="small">Project Name:</label>
                <input type="text" disabled class="form-control mb-1" value="'.$taskDetail->project->project_name.'">
                    </div>
                    <div class="col-md-4">
                <label class="small">Status:</label>
                <input type="text" disabled class="form-control mb-1" value="'.$taskDetail->status.'">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                <label class="small">Task Name:</label>
                <input type="text" disabled class="form-control mb-1" value="'.$taskDetail->task_title.'">
                    </div>

                    <div class="col-md-6">
                <label class="small">Task Type:</label>
                <input type="text" disabled class="form-control mb-1" value="'.$taskDetail->taskType->type_name.'">
                    </div>

                </div>

                  <label class="small">Task Description:</label>
                <textarea type="text" rows="4" disabled class="form-control mb-1">'.$taskDetail->task_description.'</textarea>

                <hr>
              
                 <div class="form-row">
                    <div class="col-md-6">
                <label class="small">Due Date:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.date('d-M-y', strtotime($taskDetail->due_date)).'">
                    </div>

                    <div class="col-md-6">
                <label class="small">Time:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.date('h:i A', strtotime($taskDetail->date_time)).'">
                    </div>

                </div>
                <label class="small">Remarks:</label>
                <input type="text" disabled class="form-control mb-1" value="'.$taskDetail->remarks.'">

                <hr>
                ';

    }

    public function finishTask(Request $request)
    {

        $taskDetail = Tasks::where('id', $request->id)->first();


        echo
                ' 
                <div class="form-row">
                    <div class="col-md-8">
                <label class="small">Project Name:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.$taskDetail->project_id.'">
                    </div>
                    <div class="col-md-4">
                <label class="small">Status:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.$taskDetail->status.'">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                <label class="small">Task Name:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.$taskDetail->task_title.'">
                    </div>

                    <div class="col-md-6">
                <label class="small">Task Type:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.$taskDetail->task_type_id.'">
                    </div>

                </div>


                <div class="form-row">
                    <div class="col-md-6">
                <label class="small">Due Date:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.date('d-M-y', strtotime($taskDetail->due_date)).'">
                    </div>

                    <div class="col-md-6">
                <label class="small">Time:</label>
                <input type="text" disabled class="form-control mb-1 " value="'.date('h:i A', strtotime($taskDetail->date_time)).'">
                    </div>

                </div>

                  <label class="small">Task Description:</label>
                <textarea type="text" rows="4" disabled class="form-control mb-1 firstNameEdit">'.$taskDetail->task_description.'</textarea>

                <hr>
                  <input type="hidden" value="'.$taskDetail->id.'" name="taskId">
                ';

    }


    public function updateTask (Request $request){
        $taskDetails = Tasks::where('id', $request->taskId)->first();

        $date = Carbon::now();
        $combinedDT = date('Y-m-d H:i:s', strtotime("$taskDetails->due_date $taskDetails->date_time"));

        if($date > $combinedDT)
        {
            $taskDetails->status = 'Finished(Late)';
        } else {
            $taskDetails->status = 'Finished(On-Time)';
        }
        $taskDetails->remarks = $request->remarks;
        $taskDetails->save();

        return redirect()->route('userHome');


    }

    public function viewProfileUser(){

      $id =  Auth::id();
      $userDetails = UserDetail::where('user_id', $id)->first();

        return view('user::viewProfile', compact('userDetails'));
    }

    public function editProfile(Request $request)
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

    public function storeProfile(Request $request)
    {

        $userDetails = UserDetail::where('user_id', Auth::id())->first();

        $userDetails->first_name= $request->fname;
        $userDetails->mid_name = $request->mname;
        $userDetails->last_name =$request->lname;
        $userDetails->save();

        return redirect()->route('viewProfileUser')->with('success', 'Profile Updated');
    }
}
