@extends('admin::layouts.master')

@section('content')
 
<form method="POST" id="topdf"  action="" target="_blank"> 
@csrf 
            <div class="form-row"  style="margin-top: 70px;">
              <div class="col-md-12">
              
                  <div class="row">
                    <div class="col-md-8">
                       <h1 class="lead">Generate Report</h1>
                  
                    </div>
                  
                  </div>
                  <hr>

                  
                          <strong>Sort by: </strong><br>
                          <div class="mb-3 p-3">
                           
                            <div class="row d-flex justify-content-center">
                              <!-- <div class="col-md-2">
                                <label>Date From</label>
                              </div>
                              <div class="col-md-2">
                                <label>Date To</label>
                              </div> -->
                              <div class="col-md-2">
                                <label>User Type</label>
                              </div>
                            
                              
                            </div>
                            <div class="row d-flex justify-content-center" id="filters">
                              

                              <!-- <div class="col-md-2">
                                <input type="date" name="min" id="min" class="form-control" required>
                              </div>
                              <div class="col-md-2">
                                <input type="date" name="max" id="max" class="form-control" required>
                              </div> -->
                            </div>
                            <div class="row d-flex justify-content-center mt-2">
                              <div class="col-md-8">
                                 <button type="submit" class="btn btn-outline-danger col-md-12 " id="addBtn" data-target="#addModal" data-toggle="modal" >Export as PDF</button>
                              </div>
                            </div>
                          </div>
                       
                    <table id="user_table" class="table table-bordered">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Profile Picture</th>
                              <th>Username</th>
                              <th>Name</th>
                              <th>User Type</th>
                              
                          </tr>
                      </thead>
                    
                    </table>



                </div>
            </div>
            <br>

</form>



    <script type="text/javascript">

   
    $(document).ready(function(){
var count=0;
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


          initComplete: function () {
            this.api().columns([3]).every( function () {
                var column = this;
                count++;
                $('<div class="col-md-2" id="lalagyan'+count+'"></div>')
                    .appendTo( "#filters" );

                var select = $('<select class="mb-2 form-control" name="select'+count+'"><option value=""></option>All</select>')
                    .appendTo( "#lalagyan"+count )
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
        });

    });
      



    </script>
@endsection
