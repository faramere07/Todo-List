@extends('user::layouts.master')

@section('content')
  
@if(session('success'))
    <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
         <strong>{{ session('success') }}</strong>
    </div>
@endif

    <p class="Lead">Welcome {{ $userDetails->first_name }} {{ $userDetails->last_name }}! You have {{ $taskDetails }} ongoing task(s)</p>
    

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

    <!-- Modal for viewing Details-->

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

    <!-- Modal for finishing tasks-->

    <div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title lead" id="exampleModalLabel">Task Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

               <form method="POST" action="{{route('updateTask')}}">
                @csrf

                <div class="modal-body" id="finishBody">

                  
                </div>
                <div class="container">
                   <label class="small">Remarks:</label>
                  <input type="text" class="form-control mb-1" name="remarks">
                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-dark col-md-12">Finish</button>
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

        var dataTable= $('#table_id').DataTable( {
        "ajax": "{{ route('user_dtb') }}",
        "columns": [
            { "data": "project.project_name" },
            { "data": "task_title" },
            { "data": "task_name" },
            { "data": "due_date" },
            { "data": "date_time" },
            { "data": "status" },
            { "data": "actions" },
           
        ],

        initComplete: function () {
            this.api().columns([5]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
        } );
        } );

  

  //show Modal Details
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

  //show Modal Finish
  $(document).on('click','.finish',function(){
          var id = $(this).attr('taskId');

          $.ajax({
            url:"{{ route('finishTask') }}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#finishModal').modal('show');
             
              $('#finishBody').html(data);
             
            }   
          });  
        });
</script>
@endsection
