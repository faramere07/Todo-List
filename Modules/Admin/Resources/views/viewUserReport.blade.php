@extends('admin::layouts.master')

@section('content')
 
<form method="POST" id="topdf"  action="{{route('userReportPDF')}}" target="_blank"> 
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
                              <div class="col-md-2">
                                <label>Date From</label>
                              </div>
                              <div class="col-md-2">
                                <label>Date To</label>
                              </div>
                              <div class="col-md-2">
                                <label>User Type</label>
                              </div>
                            
                              
                            </div>
                            <div class="row d-flex justify-content-center" id="filters">
                              

                              <div class="col-md-2">
                                <input type="date" name="min" id="min" class="form-control" required>
                              </div>
                              <div class="col-md-2">
                                <input type="date" name="max" id="max" class="form-control" required>
                              </div>
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
                              <th>First Name</th>
                              <th>Middle name</th>
                              <th>Last Name</th>
                              <th>User Type</th>
                             

                              
                          </tr>
                      </thead>
                    
                    </table>



                </div>
            </div>
            <br>

</form>



    <script type="text/javascript">
  $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          var token = $("input[name='_token']").val();

   
    $(document).ready(function(){
var count=0;



      $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {

            var d1 = new Date($('#min').val());
            var d2 = new Date($('#max').val());
            var d3 = new Date(data[6]);
              // var min = Date.parse($('#min').val());
              // var max = Date.parse($('#max').val());
              // var age = Date.parse( data[6] ) || 0; // use data for the age column


              var min = d1.getTime();
              var max = d2.getTime();
              var age = d3.getTime();
       
              if ( ( isNaN( min ) && isNaN( max ) ) ||
                   ( isNaN( min ) && age <= max ) ||
                   ( min <= age   && isNaN( max ) ) ||
                   ( min <= age   && age <= max ) )
              {
                  return true;
              }
              return false;
          }
      );


      //DataTables Ajax
        var table= $('#user_table').DataTable({
          "ajax": "{{route('usersShowReport')}}",
          "columns": [
              { "data": "profile_picture" },
              { "data": "username" },
              { "data": "first_name" },
              { "data": "last_name" },
              { "data": "mid_name" },
              { "data": "type_name" },
              { "data": "created_at"},
          ],
          "columnDefs": [
              { "targets": 0,
                "render": function(data) {
                  return '<img style="width:150px; height:150px;" src=../images/'+data+'>'
                }
              }
              ,
              {
                  "targets": [ 6 ],
                  "visible": false
              }  
            ],
             initComplete: function () {
            this.api().columns([5]).every( function () {
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
          } );

        // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
      
    });
      



    </script>
@endsection
