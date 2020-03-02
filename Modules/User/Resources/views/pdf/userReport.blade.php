<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
        <style type="text/css">
        	h3{
        
				  font-family: 'Helvetica';
	
        	}
		    table, td, th{
		      border: 1px solid #ddd;
		    }
		    table{
		      border-collapse: collapse;
		      width: 100%;
		    }
		    th, td {
		      padding: 5px;
		    }
		    #container{
		      padding: 15px;
		    }

  	  	</style>

<body>
	
  	<h3>Tasks
  		as of {{$month}}</h3>
  		<br>
	<table>
		<tr>
            <th>Project</th>
            <th>Title</th>
            <th>Description</th>
            <th>Due Time</th>
            <th style="width: 80px;">Due Date</th>
            <th>Status</th>
            <th>Remarks</th>
		</tr>

		@foreach($tasks as $q)
		<tr>
			<td>{{$q->project->project_name}}</td>
			<td>{{$q->task_title}}</td>
			<td>{{$q->task_description}}</td>
			<td>{{$q->date_time}}</td>
			<td>{{$q->due_date}}</td>
			<td>{{$q->status}}</td>
			<td>{{$q->remarks}}</td>
		</tr>
		@endforeach
	</table>
	
</body>
</html>