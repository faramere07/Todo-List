@extends('admin::layouts.master')

@section('content')

  <div class="container-fluid" style="margin-top: 70px; margin-bottom: 150px;">
      <div class="form-row col-md-12"> 
          @if (Session::has('message'))
              <div class="alert alert-success alert-dismissible fade show" style="display: block; position: relative; margin-bottom: 1%; text-align: left;">
                <strong>{{ Session::get('message') }}!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

          @elseif (Session::has('error'))
              <div class="alert alert-danger alert-dismissible fade show" style="display: block; position: relative; margin-bottom: 1%; text-align: left;">
                <strong>{{ Session::get('error') }}!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          @endif
          <div class="form-row col-md-12" style="padding:10px;"> 
            <h1 class="lead my-3 ml-1">Task Types</h1>

            <button type="button" class="col-md-3 ml-auto btn btn-outline-info" data-toggle="modal" data-target="#addUser">
                  Add New User Account
            </button>
          </div>
          <hr>
          <div class="form-row col-md-12" style="padding:10px; border:1px solid #FFF0F5;">
              <div class="col-md-12">
                  <table id="user_table" class="display table-bordered" style="width: 100%;">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Profile Picture</th>
                              <th>Username</th>
                              <th>Name</th>
                              <th>User Type</th>
                              <th>Actions</th>
                          </tr>
                      </thead>       
                  </table>
              </div>
          </div>
      </div>
  </div>

  <!-- Add user modal -->
  <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="POST" action="{{ route('addUser') }}">
        @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add User Account</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-row col-md-12 justify-content-center">
                    <div class="form-group col-md-12">
                      <label for="exampleInputPassword1">Username</label>
                      <input type="text" class="form-control" name="username"max="25" required>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="exampleInputPassword1">Username</label>
                      <select type="text" class="form-control" name="type_id"required>
                          @foreach($user_types as $types)
                              <option value="{{ $types->id }}">{{ $types->type_name }}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="exampleInputPassword1">Password (Default: 123456789)</label>
                      <input type="password" class="form-control" name="password"max="25" value="123456789" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <div class="form-group col-md-12">
              <button type="submit" class="btn btn-outline-primary col-md-12" id="add">Create User Account</button>
            </div>
            </div>
          </div>
      </form>
      
    </div>
  </div>

  <!-- View User modal -->
  <div class="modal fade" id="viewUserDetails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="">
              @csrf
            <div class="modal-body" id="viewBody">

                <!-- echo user details modal content -->

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
        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            language:{
              emptyTable: "No User Added.",
            },
            "ajax": "{{route('usersShow')}}",
            "columns": [
                { "data": "userDetail.profile_picture"},
                { "data": "username" },
                { "data": "first_name" },
                { "data": "type_name" },
                { "data": "actions" },
            ],
            columnDefs:[
                {
                  "width":"150px","targets":[0],
                },
                {
                  "width":"100px","targets":[3],
                },
                {
                  "targets":[0],
                  "render": function(data, type, row){
                      if(row.profile_picture == null){
                          return "<img style='width:100px; height:100px;' src='{{ asset('images/default-profile.png') }}'/>";
                      }else{
                          return "<img style='width:100px; height:100px;' src='../images/"+row.profile_picture+"'/>";
                      }
                  }
                },
                {
                  "targets":[2],
                  "render": function(data, type, row){
                      if(row.first_name == null){
                        return "<i>(To Be Filled-up)</i>"
                      }else{
                        return row.first_name + " " + row.mid_name + " " + row.last_name;
                      }
                  }
                },
            ],
        });

    });

    //show Modal view user details
  $(document).on('click','.view',function(){
          var id = $(this).attr('userId');
        
          $.ajax({
            url:"{{ route('viewUserDetails') }}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#viewUserDetails').modal('show');
              $('#viewBody').html(data);
            
            },
          error: function(jqxhr, status, exception) {
             alert('User still needs to fill his/her details.');
         }
          });  
        });

 
      $( "#addUser" ).submit(function( event ) {
        $('#add').prop('disabled', true);
      });

</script>

@endsection
