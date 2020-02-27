<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style type="text/css">
	    table, td, th{
	      border: 1px solid #ddd;
	    }
	    table{
	      border-collapse: collapse;
	      width: 100%;
	    }
	    th, td {
	      padding: 10px;
	    }
	    #container{
	      padding: 15px;
	    }

  	</style>

  	<h2>Projects for the month of {{$month}}</h2>
	<table>
		<tr>
			<th>Project Name</th>
            <th>Project Description</th>
		</tr>
		@foreach($projects as $project)
		<tr>
			<td>{{$project->project_name}}</td>
			<td>{{$project->project_desc}}</td>

		</tr>
		@endforeach
	</table>
	
</body>
</html>