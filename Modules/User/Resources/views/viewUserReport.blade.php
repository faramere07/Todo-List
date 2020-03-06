@extends('user::layouts.master')

@section('content')
  

<form method="POST" id="topdf"  action="{{route('userReport')}}" target="_blank"> 
@csrf 
            <div class="form-row" style="margin-top: 70px;">
              <div class="col-md-12">

                  <div class="row">
                    <div class="col-md-8">
                       <h1 class="lead">Generate Report</h1>
                  
                    </div>
                  
                  </div>
                  <hr>

                  
                          <strong>Sort by: </strong><br>
                          <div class="mb-3 p-3">
                            <!-- <div class=" d-flex justify-content-center">
                              <div class="col-md-8">
                                <input type="text" id="searchbox" placeholder="search" class="form-control">
                              </div>
                            </div> -->
                            <div class="row d-flex justify-content-center">
                              <div class="col-md-2">
                                <label>Date From</label>
                              </div>
                              <div class="col-md-2">
                                <label>Date To</label>
                              </div>
                              <div class="col-md-2">
                                <label>Project</label>
                              </div>
                              <div class="col-md-2">
                                <label>Task Status</label>
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
      <table id="table_id" class="table table-bordered">

        <thead class="thead thead-dark">
              <tr>
                  <th>Project Name</th>
                  <th>Task</th>
                  <th>Task Type</th>
                  <th>Due Date</th>
                  <th>Time</th>
                  <th>Status</th>
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
        var count=0;

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = Date.parse($('#min').val());
        var max = Date.parse($('#max').val());
        var age = Date.parse( data[3] ) || 0; // use data for the age column
 
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
        var table= $('#table_id').DataTable( {
        "ajax": "{{ route('user_dtb') }}",
        "columns": [
            { "data": "project.project_name" },
            { "data": "task_title" },
            { "data": "task_name" },
            { "data": "due_date" },
            { "data": "date_time" },
            { "data": "status" },
        
           
        ],

        initComplete: function () {
            this.api().columns([0,3]).every( function () {
                var column = this;
                count++;
                $('<div class="col-md-2" id="lalagyan'+count+'"></div>')
                    .appendTo( "#filters" );
                var select = $('<select class="mb-2 form-control" name="select'+count+'"><option value="">All</option></select>')
                    .appendTo("#lalagyan"+count )
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
        },

        'rowCallback': function(row, data, index){
            
            if(data.due_date < newDate && data.status == 'Ongoing'){
                $(row).css('color', '#e8000c');
            }

            if(data.status == 'Ongoing' && data.due_date >= newDate){
                console.log(data.status); 
                $(row).find('td:eq(5)').css('color', '#02cc38');
            }if(data.status == 'Finished(On-Time)'){
                console.log(data.status); 
                $(row).find('td:eq(5)').css('color', 'blue');
            }if(data.status == 'Finished(Late)'){
                console.log(data.status); 
                $(row).find('td:eq(5)').css('color', 'red');
            }
            
          }
        } );

         $('#min, #max').change(function () {
                table.draw();
            });
        } );

  

  
 // Event listener to the two range filtering inputs to redraw on input
          
</script>
@endsection
