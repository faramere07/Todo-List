@extends('admin::layouts.master')

@section('content')

  <div class="container-fluid" style="margin-top: 70px; margin-bottom: 150px;">
      <div class="form-row col-md-12">
          <div class="col-md-7">
              <div id='calendar'></div>

              <div style='clear:both'></div>
          </div>
          <div class="col-md-1">
            
          </div>
          <div class="col-md-4" style="margin-top: 20px;">
              <div class="col-md-12"><h3><u>Administrator</u></h3></div>
              <div class="col-md-12">
                  <h6>Things Admin can do:</h6>
              </div>
              <div class="col-md-12">
                  <ul style="list-style-type: disc;">
                      <li>
                          Create accounts and assign user type.
                      </li>
                      <li>
                          Generate monthly report.
                      </li>
                      <li>
                          Edit settings for specific user.
                      </li>
                      <li>
                          Edit settings for specific task.
                      </li>
                      <li>
                          Edit your own profile and password.
                      </li>
                      <li>
                          Deactivate user accounts.
                      </li>
                  </ul>
              </div>
              <div class="col-md-12">
                  <h6>Legends in Table:</h6>
              </div>
              <div class="col-md-12">
                  <ul style="list-style: none;">
                      <li>
                          <div style="padding:2%; width: 2%; background-color: red; display: inline-block; border: 1px solid;"></div>
                          Unfinished task.
                      </li>
                      <li>
                          <div style="padding:2%; width: 2%; background-color: green; display: inline-block; border: 1px solid;"></div>
                          Finished task.
                      </li>
                      <li>
                          <div style="padding:2%; width: 2%; border: 1px solid; display: inline-block;"></div>
                          Ongoing task.
                      </li>
                      <li>
                          <div style="padding:2%; width: 2%; border: 1px solid; display: inline-block; background-color: orange;"></div>
                          Deleted task.
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      
      <div class="form-row col-md-12" style="margin-top: 20px;">
          <div class="form-row col-md-12" style="background-color: #0b1e42; padding:10px;"> 
              <select class="form-control col-md-2 ml-auto">
                  <option disabled selected>-- Choose Filter --</option>
                  <option>All</option>
                  <option>Ongoing</option>
                  <option>Finished</option>
                  <option>Unfinished</option>
                  <option>Deleted</option>
              </select>
          </div>
          <div class="form-row col-md-12" style="padding:10px; border:1px solid #FFF0F5">
              <div class="col-md-12">
                  <table class="display table-bordered" id="task_table">
                      <thead>
                          <tr>
                              <th>Star Date</th>
                              <th>Due Date</th>
                              <th>Project Name</th>
                              <th>Task Title</th>
                              <th>Task Status</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>
  </div>


<!--Task View Modal -->
  <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">

  //DataTables Ajax
      $('#task_table').DataTable({
          processing: true,
          serverSide: true,
          language:{
            emptyTable: "No Task Added.",
          },
          "ajax": "{{route('viewTask')}}",
            "columns": [
                { "data": "created"},
                { "data": "due"},
                { "data": "project"},
                { "data": "task" },
                { "data": "description" },
                { "data": "actions" },
          ],
      });

  //Calendar
    document.addEventListener('DOMContentLoaded', function() {
      var Calendar = FullCalendar.Calendar;

      var calendarEl = document.getElementById('calendar');
      var calendar = new Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth'
        },
        selectable:true,
        select: function(arg){
          var dates = arg.start;
          var d = new Date(dates);
 
          var date = d.getDate();
          var month = d.getMonth() + 1;
          var year = d.getFullYear();
           
          var dateStr = year + "-" + month + "-" + date;
          alert(dateStr);
        }
      });
      calendar.render();

    });

    //Task Modal

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $("input[name='_token']").val();

    $(document).on('click','.taskview', function(){
        var taskid = $(this).attr('taskid');
        
        $.ajax({
            url:'<?php echo route('taskDetailsAdmin') ?>',
            method:"POST",
            data:{taskid:taskid, _token:_token},
            success:function(data){
              alert(data);
              $('#taskModal').modal('show');
            }
        });
    })
</script>

@endsection
