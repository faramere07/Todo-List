@extends('taskmaster::layouts.master')

@section('content')

   <div class="alert alert-info alert-dismissible fade show" role="alert"></div>

  
            <div class="form-row"  style="margin-top: 70px;">
              <div class="col-md-12">
              

                  <div class="row">
                    <div class="col-md-8">
                  <h2 class="lead">Tasks for <b>{{ $project->project_name}}</b></h2>
                </div>
                  <div class="col-md-4">
                          <button type="button" class="btn btn-outline-dark col-md-8 float-right" id="addBtn" data-target="#addModal" data-toggle="modal" >Add a task</button>
                      </div>
                  </div>
                  <hr>

                        
                    
                    <table id="table_id" class="table table-bordered">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Title</th>
                              <th>Description</th>
                              <th>Date Time</th>
                              <th>Due Date</th>
                              <th>Status</th>
                              <th>Remarks</th>
                              
                              <th class="text-right">Actions</th>
                              
                          </tr>
                      </thead>
                    
                    </table>



                </div>
            </div>
            <br>


    <!-- Modal for Adding -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add a task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form  id="addForm" method="POST">
            @csrf
            <div class="modal-body">
              <p class="text-danger empty"><em>*Please fill all information below.</em></p>
    
              

              <div class="input-group input-group-lg mb-2">
                  <input type="text" name="taskTitle" class="form-control" placeholder="Task title" required>   
              </div>

              <div class="mb-2">
                  <select class="form-control" name="taskType">
                    <option>--select task type--</option>
                    @foreach ($types as $type)
                      <option value="{{$type->id}}">{{ $type->type_name }}</option>
                    @endforeach
                  </select>   
              </div>

              <div class="mb-2">

                  <select class="form-control" name="userId">
                    <option>--select user--</option>
                    @foreach ($users as $user)
                      <option value="{{$user->u_id}}">{{ $user->first_name }} {{ $user->lastname}}</option>
                    @endforeach
                  </select>   
              </div>
              <div class="row mb-2">
                <div class="col-md-6">
                  <label>Due Date:</label>
                  <input type="date" id="dueDate" name="dueDate" class="form-control" min="" required>
                </div>
                
                <div class="col-md-6">
                  <label>Due Time:</label>
                  <input type="time" name="dateTime" class="form-control" required>
                </div>
              </div>
              

              <textarea class="form-control" name="taskDesc" rows="3" placeholder="Task Description." required></textarea>

              <input type="hidden" name="projId" value="{{ $project->id }}">
              
              
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             
                  <input type="hidden" name="date" id="dateAdd">
                  <button type="submit" class="btn btn-primary add">Save task</button>
            </div>
          </form>
        </div>
      </div>
    </div>



    <!-- Modal for Editing -->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id ='editForm'>
          @csrf
              <div class="modal-body" id="editBody">

                  
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
          </form>
        </div>
      </div>
    </div>



    <script type="text/javascript">

    $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          var token = $("input[name='_token']").val();

    $(document).ready(function(){
        $('.alert').hide();
        $('.empty').hide();
        $('.emptyUpdate').hide();


        // const date = new Date();
        // const formattedDate = date.toLocaleDateString('en-GB', {
        //   day: 'numeric', month: 'short', year: 'numeric'
        // }).replace(/ /g, '-');

        var date = new Date();

          var newd      = date.toLocaleDateString();
          var month     = date.getMonth()+1;
          var date1     = date.getDate();
          var year      = date.getFullYear();
          
          if(month <10){
            month = '0'+month;

          }if(date1 <10){
            date1 = '0'+date1;
          }
  
        var newDate = year+'-'+month+'-'+date1;
 

        var dataTable= $('#table_id').DataTable( {
        "ajax": "{{route('task_dtb', $project->id)}}",
        "columns": [
            { "data": "task_title" },
            { "data": "task_description" },
            { "data": "date_time" },
            { "data": "due_date" },
            { "data": "status" },
            { "data": "remarks" },
            // { "data": "type_name" },
            { "data": "actions" },
        ],

        'rowCallback': function(row, data, index){
            
            if(data.due_date < newDate && data.status == 'Ongoing'){
                // $(row).css('background-color', '#cc1d1d');
                $(row).css('color', '#e8000c');
            }

            if(data.status == 'Ongoing' && data.due_date >= newDate){
                console.log(data.status); 
                $(row).find('td:eq(4)').css('color', '#02cc38');
            }if(data.status == 'Finished(On-Time)'){
                console.log(data.status); 
                $(row).find('td:eq(4)').css('color', 'blue');
            }if(data.status == 'Finished(Late)'){
                console.log(data.status); 
                $(row).find('td:eq(4)').css('color', 'red');
            }
            
          }
        } );




        //Adding
    $( "#addForm" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
          url:"{{route('addTask')}}",
          method:"POST",
          data: $("#addForm").serialize(),
          success:function(data){
            $('#addModal').modal('hide');
            dataTable.ajax.reload();
            
            $("#addForm")[0].reset();
            $('.empty').hide();
            $('.alert').append('<span id="alertMessage">Task Added!</span>');
            $('.alert').show();
            $(".alert").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
            
          }
              
        }); 
    });   


    //show edit form
  $(document).on('click','.edit',function(){
          var id = $(this).attr('taskId');

          $.ajax({
            url:"{{route('editTask')}}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#editModal').modal('show');
             
              $('#editBody').html(data);
             
            }   
          });  
        });

    //update
      $( "#editForm" ).submit(function( event ) {
         event.preventDefault();
         
        $.ajax({
          url:"{{route('saveEditTask')}}",
          method:"POST",
          data: $("#editForm").serialize(),
          
          success:function(data){
            $('#editModal').modal('hide');
            
            dataTable.ajax.reload();

            $('.empty').hide();
            $('.alert').append('<span id="alertMessage">Record Updated!</span>');
            $('.alert').show();
            $(".alert").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
            
          }
              
        }); 
      });

      //delete
       $(document).on('click','.destroy',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var id = $(this).attr('taskId');

      if(conf){
        $.ajax({
          url:"{{route('destroyTask')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            dataTable.ajax.reload();
            $('.alert').append('<span id="alertMessage">Record deleted!</span>');
            $('.alert').show();
            $(".alert").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
          },
          error: function(jqxhr, status, exception) {
             alert('record not deleted');
         }

        });  
      }
    }); 

        //for datepicker
        $(function () {
                 var today = new Date().toISOString().split('T')[0];
document.getElementsByName("dueDate")[0].setAttribute('min', today);
           });
        
        // end
    });
    </script>
@endsection
