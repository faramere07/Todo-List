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
          <h1 class="lead my-3">Projects</h1>
          <hr>  
          <div class="form-row col-md-12" style="padding:10px; border:1px solid #FFF0F5;">
              <div class="col-md-12">
                  <table id="project_table" class="display table-bordered" style="width: 100%;">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Project Name</th>
                              <th>Project Description</th>
                              <th>Creator</th>
                              <th>Actions</th>
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
            "ajax": "{{route('projectShow')}}",
            "columns": [
                { "data": "project_name"},
                { "data": "project_desc" },
                { "data": "name"},
                { "data": "actions" },
            ],
        });

    });


</script>

@endsection
