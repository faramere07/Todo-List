@extends('admin::layouts.master')

@section('content')

  <div class="container-fluid" style="margin-top: 70px; margin-bottom: 150px;">
      <div class="form-row col-md-12" style="margin-top: 20px;">
          <div class="form-row col-md-12" style="background-color: #FFF0F5; padding:10px;"> 
              <button type="button" class="form-control col-md-2 ml-auto btn btn-outline-info">
                  Add User
              </button>
          </div>
          <div class="form-row col-md-12" style="padding:10px; border:1px solid #FFF0F5">
              <table id="table_id" class="display">
                  <thead>
                      <tr>
                          <th>Profile Picture</th>
                          <th>Username</th>
                          <th>Name</th>
                          <th>Actions</th>
                      </tr>
                  </thead>       
              </table>
          </div>
      </div>
  </div>


<script type="text/javascript">

    $(document).ready(function(){

      //DataTables Ajax
        $('#table_id').DataTable({
            processing: true,
            serverSide: true,
            language:{
              emptyTable: "No User Added.",
            },
            "ajax": "{{route('usersShow')}}",
            "columns": [
                { "data": "profile_picture"},
                { "data": "username" },
                { "data": "first_name" },
                { "data": "actions" },
            ],
            columnDefs:[
                {
                  "targets":[0],
                  "render": function(data, type, row){
                      if(row.profile_picture == null){
                          return "<img style='width:150px; height:150px;' src='{{ asset('images/default.png') }}'/>";
                      }else{
                          return "<img style='width:150px; height:150px;' src='../public/images/"+row.profile_picture+"'/>";
                      }
                  }
                },
                {
                  "targets":[2],
                  "render": function(data, type, row){
                      if(row.first_name == null){
                        return "<i>(To Be Fill-up)</i>"
                      }else{
                        return row.first_name + " " + row.mid_name + " " + row.last_name;
                      }
                  }
                }
            ],
        });

    });
      

</script>

@endsection
