@extends('taskmaster::layouts.master')

@section('content')

   <div class="alert alert-info alert-dismissible fade show" role="alert"></div>

  
            <div class="form-row">
              <div class="col-md-12">
              

                  <div class="row">
                    <div class="col-md-8">
                  
                </div>
                  <div class="col-md-4">
                          <button type="button" class="btn btn-outline-dark col-md-8 float-right" id="addBtn" data-target="#addModal" data-toggle="modal" >Add a task</button>
                      </div>
                  </div>
                  <hr>

                        <span id="filters">
                          Sort by: <br>
                        </span>
                    
                    <table id="table_id" class="table table-bordered">
                      <thead class="thead thead-dark">
                          <tr>
                              <th>Project</th>
                              <th>Title</th>
                              <th>Description</th>
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
            { "data": "task_description" },
            { "data": "date_time" },
            { "data": "due_date" },
            { "data": "status" },
            { "data": "remarks" },
            // { "data": "type_name" },
            { "data": "actions" },
        ],

        'rowCallback': function(row, data, index){
            
            if(data.due_date < newDate){
                $(row).css('background-color', '#fa6057');
            }
            
          },
          initComplete: function () {
            this.api().columns([0,5]).every( function () {
                var column = this;
                count++;
                var select = $('<select class="mr-3 mb-2" id=select"'+count+'"><option value=""></option></select>')
                    .appendTo( "#filters" )
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
