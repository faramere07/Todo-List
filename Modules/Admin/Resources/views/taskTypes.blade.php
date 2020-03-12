@extends('admin::layouts.master')

@section('content')
  <style type="text/css">
    
  </style>

  <div class="container-fluid" style="margin-top: 70px; margin-bottom: 150px;">
      <div class="form-row col-md-12"> 
          @if (Session::has('message'))
              <div class="alert alert-success alert-dismissible fade show col-md-12" style="display: block; position: relative; margin-bottom: 1%; text-align: center;">
                <strong>{{ Session::get('message') }}!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

          @elseif (Session::has('error'))
              <div class="alert alert-danger alert-dismissible fade show col-md-12" style="display: block; position: relative; margin-bottom: 1%; text-align: center;">
                <strong>{{ Session::get('error') }}!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          @endif
          <div class="form-row col-md-12" style="padding:10px;"> 
              <button type="button" class="col-md-3 ml-auto btn btn-outline-info" data-toggle="modal" data-target="#addTaskType">
                  Add New Task Type
              </button>
          </div>
          <div class="form-row col-md-12" style="padding:10px; border:1px solid #FFF0F5;">
              <div class="col-md-12">
                  <table id="task_table" class="display table-bordered" style="width: 100%;">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Task Type Name</th>
                              <th>Task Description</th>
                              <th>Actions</th>
                          </tr>
                      </thead>       
                  </table>
              </div>
          </div>
      </div>
  </div>

  <!-- Add Task Type modal -->
  <div class="modal fade" id="addTaskType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="POST" action="{{ route('addTaskType') }}" id="addform">
        @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Task Type</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-row col-md-12 justify-content-center">
                    <div class="form-group col-md-12">
                      <label for="exampleInputPassword1">Type Name</label>
                      <input type="text" class="form-control" name="type_name" max="25" required>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="exampleInputPassword1">Type Description</label>
                      <textarea class="form-control" name="type_desc" rows="3" cols="50" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <div class="form-group col-md-12">
              <button type="submit" class="btn btn-outline-primary col-md-12 add">Create Task Type</button>
            </div>
            </div>
          </div>
      </form>
      
    </div>
  </div>

  <!-- Edit Task Type modal -->
  <div class="modal fade" id="editTaskType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Task Type</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{ route('updateTaskType') }}" id="editform">
              @csrf
            <div class="modal-body" id="editBody">

                <!-- tasktype echo edit task type -->

            </div>
            <div class="modal-footer">
              <div class="form-group col-md-12">
              <button type="submit" class="btn btn-outline-primary col-md-12 update">Update</button>
            </div>
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

      //DataTables Ajax
            $('#task_table').DataTable({
            processing: true,
            serverSide: true,
            language:{
              emptyTable: "No Tasks Added.",
            },
            "ajax": "{{route('taskShow')}}",
            "columns": [
                { "data": "type_name"},
                { "data": "type_desc" },
                { "data": "actions" },
            ],
        });

    });

    //delete
      $(document).on('click','.destroy',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var id = $(this).attr('typeId');

      if(conf){
        $.ajax({
          url:"{{ route('destroyType') }}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            $('#task_table').DataTable().ajax.reload()
            $('.alert').append('<span id="alertMessage">Record deleted!</span>');
            $('.alert').show();
            $(".alert").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
          },
          error: function(jqxhr, status, exception) {
             alert('This record is being used by some tasks, please delete Tasks First');
         }

        });  
      }
    }); 


      //show Modal edit Task
  $(document).on('click','.edit',function(){
          var id = $(this).attr('typeId');

          $.ajax({
            url:"{{ route('editTaskType') }}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#editTaskType').modal('show');
              $('#editBody').html(data);
             
            }   
          });  
        });
  // $(document).on('click','.update',function(){
  $( "#editform" ).submit(function( event ) {
    $('.update').prop('disabled', true);
  });


  $( "#addform" ).submit(function( event ) {
    $('.add').prop('disabled', true);
  });
      

</script>

@endsection
