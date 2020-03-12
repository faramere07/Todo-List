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
          <h1 class="lead my-3 ml-1">Tasks for {{$project->project_name}}</h1>
          <hr>  
          <div class="form-row col-md-12" style="padding:10px; border:1px solid #FFF0F5;">
              <div class="col-md-12">
                  <table id="project_table" class="display table-bordered" style="width: 100%;">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Assignee</th>
                              <th>Title</th>
                              <th>Description</th>
                              <th>Time</th>
                              <th>Due Date</th>
                              <th>Status</th>
                              <th>Remarks</th>

                          </tr>
                      </thead>       
                  </table>
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

      //DataTables Ajax
            $('#project_table').DataTable({
            processing: true,
            serverSide: true,
            language:{
              emptyTable: "No Project Added.",
            },
            "ajax": "{{route('tasksShow', $project->id)}}",
            "columns": [
              { "data": "assignee" },
              { "data": "task_title" },
              { "data": "task_description" },
              { "data": "date_time" },
              { "data": "due_date" },
              { "data": "status" },
              { "data": "remarks" },
             
            ],
        });

    });

</script>

@endsection
