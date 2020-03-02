@extends('taskmaster::layouts.master')

@section('content')

   <div class="alert alert-info alert-dismissible fade show" role="alert"></div>

<form method="POST" id="topdf"  action="{{route('taskReport')}}" target="_blank"> 
@csrf 
            <div class="form-row">
              <div class="col-md-12">
              

                  <div class="row">
                    <div class="col-md-8">
                       <h1 class="lead">Generate Report</h1>
                  
                    </div>
                  <div class="col-md-4">
                    
                      <button type="submit" class="btn btn-outline-danger col-md-8 float-right" id="addBtn" data-target="#addModal" data-toggle="modal" >Export as PDF</button>
                    
                          
                      </div>
                  </div>
                  <hr>

                        <span id="fil">
                          <strong>Sort by: </strong><br>
                          <div class="row">
                            <div class="col-md-2">
                              Project
                            </div>
                            <div class="col-md-2">
                              Task Status
                            </div>
                          </div>
                          <div class="row" id="filters">
                          </div>
                        </span>
                    
                    <table id="table_id" class="table table-bordered">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Project</th>
                              <th>Title</th>
                              <th>Date Time</th>
                              <th>Due Date</th>
                              <th>Status</th>
                              <th>Remarks</th>
                              
                              <th class="text-right">Actions</th>
                              
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
        $('.alert').hide();
        $('.empty').hide();
        $('.emptyUpdate').hide();


        // const date = new Date();
        // const formattedDate = date.toLocaleDateString('en-GB', {
        //   day: 'numeric', month: 'short', year: 'numeric'
        // }).replace(/ /g, '-');

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
                var count = 0;
 

        var dataTable= $('#table_id').DataTable( {
        "ajax": "{{route('taskReport_dtb')}}",
        "columns": [
            { "data": "project_name" },

            { "data": "task_title" },
            { "data": "date_time" },
            { "data": "due_date" },
            { "data": "status" },
            { "data": "remarks" },
            // { "data": "type_name" },
            { "data": "actions" },
        ],

        'rowCallback': function(row, data, index){
            
            if(data.due_date < newDate && data.status == 'Ongoing'){
                // $(row).css('background-color', '#cc1d1d');
                $(row).css('color', '#e8000c');
            }

            if(data.status == 'Ongoing' && data.due_date >= newDate){
                console.log(data.status); 
                $(row).find('td:eq(4)').css('color', '#02cc38');
            }if(data.status == 'Finished(On-Time)'){
                console.log(data.status); 
                $(row).find('td:eq(4)').css('color', 'blue');
            }if(data.status == 'Finished(Late)'){
                console.log(data.status); 
                $(row).find('td:eq(4)').css('color', 'red');
            }
            
          },
          initComplete: function () {
            this.api().columns([0,5]).every( function () {
                var column = this;
                count++;
                $('<div class="col-md-2" id="lalagyan'+count+'"></div>')
                    .appendTo( "#filters" );

                var select = $('<select class="mb-2 form-control" name="select'+count+'"><option value=""></option></select>')
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

     



        // end
    });
    </script>
@endsection
