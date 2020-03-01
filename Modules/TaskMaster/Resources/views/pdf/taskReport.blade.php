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

  	
	<table>
		<tr>
			<th>Project Name</th>
            <th>Project Description</th>
            <th>Status</th>

		</tr>
		@foreach($query as $q)
		<tr>
			<td>{{$q->project->project_name}}</td>
			<td>{{$q->status}}</td>

		</tr>
		@endforeach
	</table>
	
</body>
</html>