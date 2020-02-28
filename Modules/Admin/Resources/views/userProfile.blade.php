@extends('admin::layouts.master')

@section('content')

  <div class="container-fluid" style="margin-top: 70px; margin-bottom: 150px;">
      <div class="form-row col-md-12">
          @if (Session::has('message'))
              <div class="alert alert-warning alert-dismissible fade show" style="display: block; position: relative; margin-bottom: 1%; text-align: left;">
                <strong>{{ Session::get('message') }}!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          @endif

          <div class="form-row col-md-12">
              <div class="col-md-4">
                  
                {{ $users->userType->type_name }}
                  <img src="{{ asset('images/'.$users->profile_picture) }}" style="width:100%;">
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
                { "data": "date_time"},
                { "data": "project.project_name"},
                { "data": "task_title" },
                { "data": "task_description" },
          ],
          columnDefs:[
                {
                  "targets": [ 0 ],
                  "render":function(data, type, row){
                      var formattedDate = new Date(row.date_time);
                      var d = formattedDate.getDate();
                      var m =  formattedDate.getMonth() + 1;
                      var y = formattedDate.getFullYear();

                      if (formattedDate.getHours()>=12){
                          var hour = parseInt(formattedDate.getHours()) - 12;
                          var amPm = "PM";
                      } else {
                          var hour = formattedDate.getHours(); 
                          var amPm = "AM";
                      }

                      var time = hour + ":" + formattedDate.getMinutes() + " " + amPm;

                      var newdate = m + "/" + d + "/" + y

                      return time+"</br>"+newdate;
                  }
                },
                {
                  "targets": [1],
                  "render":function(data, type, row){
                      return row.project.project_name +"</br><small>By: "+row.user.username+ " "+row.last_name+"</small>";
                  }
                },
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
</script>

@endsection
