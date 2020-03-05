@extends('taskmaster::layouts.master')

@section('content')
<style type="text/css">
  .dataTables_filter {
     display: none;
}
</style>
   <div class="alert alert-info alert-dismissible fade show" role="alert"></div>

<form method="POST" id="topdf"  action="{{route('taskReport')}}" target="_blank"> 
@csrf 
            <div class="form-row">
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
                              <th>Project</th>
                              <th>Title</th>
                              <th>Date Time</th>
                              <th>Due Date</th>
                              <th>Status</th>
                              <th>Remarks</th>
                
                              
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

//Date
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


//Datatable





/* Custom filtering function which will search data in column four between two values */
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
     var table = $('#example').DataTable();
     
    // Event listener to the two range filtering inputs to redraw on input
   
            
    
        var table= $('#table_id').DataTable( { 
        "ajax": "{{route('taskReport_dtb')}}",
        "columns": [
            { "data": "project_name" },

            { "data": "task_title" },
            { "data": "date_time" },
            { "data": "due_date" },
            { "data": "status" },
            { "data": "remarks" },
            // { "data": "type_name" },
            
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
            this.api().columns([0,4]).every( function () {
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

    //         $("#searchbox").keyup(function() {
    //     dataTable.fnFilter(this.value);
    // }); 

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
    // Event listener to the two range filtering inputs to redraw on input
    // $('#min, #max').keyup( function() {
    //     table.draw();
    // } );

    // Event listener to the two range filtering inputs to redraw on input
    // $('#min, #max').change(function () {
    //     table.draw();
    // });


        // var dataTable= $('#table_id').DataTable( {
        // "ajax": "{{route('taskReport_dtb')}}",
        // "columns": [
        //     { "data": "project_name" },

        //     { "data": "task_title" },
        //     { "data": "date_time" },
        //     { "data": "due_date" },
        //     { "data": "status" },
        //     { "data": "remarks" },
        //     // { "data": "type_name" },
        //     { "data": "actions" },
        // ],

        // 'rowCallback': function(row, data, index){
            
        //     if(data.due_date < newDate && data.status == 'Ongoing'){
        //         // $(row).css('background-color', '#cc1d1d');
        //         $(row).css('color', '#e8000c');
        //     }

        //     if(data.status == 'Ongoing' && data.due_date >= newDate){
        //         console.log(data.status); 
        //         $(row).find('td:eq(4)').css('color', '#02cc38');
        //     }if(data.status == 'Finished(On-Time)'){
        //         console.log(data.status); 
        //         $(row).find('td:eq(4)').css('color', 'blue');
        //     }if(data.status == 'Finished(Late)'){
        //         console.log(data.status); 
        //         $(row).find('td:eq(4)').css('color', 'red');
        //     }
            
        //   },
        //   initComplete: function () {
        //     this.api().columns([0,3,5]).every( function () {
        //         var column = this;
        //         count++;
        //         $('<div class="col-md-2" id="lalagyan'+count+'"></div>')
        //             .appendTo( "#filters" );

        //         var select = $('<select class="mb-2 form-control" name="select'+count+'"><option value=""></option></select>')
        //             .appendTo( "#lalagyan"+count )
        //             .on( 'change', function () {
        //                 var val = $.fn.dataTable.util.escapeRegex(
        //                     $(this).val()
        //                 );
 
        //                 column
        //                     .search( val ? '^'+val+'$' : '', true, false )
        //                     .draw();
        //             } );
 
        //         column.data().unique().sort().each( function ( d, j ) {
        //             select.append( '<option value="'+d+'">'+d+'</option>' )
        //         } );
        //     } );
        // }
        // } );

     




    </script>
@endsection
