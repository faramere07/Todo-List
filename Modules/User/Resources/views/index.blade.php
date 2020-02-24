@extends('user::layouts.master')

@section('content')
  
@if(session('success'))
    <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
         <strong>{{ session('success') }}</strong>
    </div>
@endif

    <p class="Lead">Welcome {{ $userDetails->first_name }} {{ $userDetails->last_name }}! You have {{ $taskDetails }} task(s) assigned</p>
    

    <hr>
      <table id="table_id" class="table table-bordered">
        <thead class="thead thead-dark">
              <tr>
                  <th>Project Name</th>
                  <th>Task</th>
                  <th>Task Type</th>
                  <th>Due Date</th>
                  <th>Time</th>
                  <th>Status</th>
                  <th class="thwidth">Form Action</th>
              </tr>
        </thead>   
    </table>

    <br>

    <!-- Modal -->

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title lead" id="exampleModalLabel">Task Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          @csrf
              <div class="modal-body" id="detailBody">

                  
              </div>
              <div class="modal-footer">

              </div>

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

        var dataTable= $('#table_id').DataTable( {
        "ajax": "{{ route('user_dtb') }}",
        "columns": [
            { "data": "project_id" },
            { "data": "task_title" },
            { "data": "task_type_id" },
            { "data": "due_date" },
            { "data": "date_time" },
            { "data": "status" },
            { "data": "actions" },
           
        ]
        } );
        } );

     //show Modal
  $(document).on('click','.details',function(){
          var id = $(this).attr('taskId');

          $.ajax({
            url:"{{ route('taskDetails') }}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#detailModal').modal('show');
             
              $('#detailBody').html(data);
             
            }   
          });  
        });
</script>
@endsection
