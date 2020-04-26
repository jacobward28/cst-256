

<!-- Ensures that the one looking at the page is an administrator -->
@extends('layouts.appmaster')
@section('title','Job Admin')

<!-- Imports needed for the included Jquery table to work properly -->
@section('imports')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="public/css/table.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
@endsection

@section('style')
<style>
    .formLabel{
        color:black;
    }
    .form-control{
        width:60%;
    }
    #ModalLabel{
        color:black;
    }
    #jobs_info{
        color:white !important;
        margin-left:7.5%;
    }
    #jobs_paginate{
        margin-right:7.5%;
    }
</style>
@endsection

@section('content')

<!-- Prints out any errors if there are any after an admin has attempted to edit a job -->
@if($errors->count() != 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger" role="alert" style="width:20%;">{{$error}}</div><br>
	@endforeach
@endif

<!-- Data table using jquery for managaing job -->
<table id="jobs" class="table table-striped table-bordered" style="width:85%;">
	<thead>
		<tr>
<!-- 			All the column names for the table -->
			<th scope="col">ID</th>
			<th scope="col">Title</th>
			<th scope="col">Company</th>
			<th scope="col">State</th>
			<th scope="col">City</th>
			<th scope="col">Description</th>
		</tr>
	</thead>
	<tbody>
<!-- 		Iterates over each user returned with this page -->
		@foreach($results as $job)
			<tr>
<!-- 				Iterates over each value for that specific user to allow administrators to view all of a job's information -->
				@foreach($job as $value)
					<td>{{$value}}</td>
				@endforeach
		@endforeach
	</tbody>
</table>

<!-- Script from dataable to enable jquery functionality -->
<script>
	$(document).ready( function () {
  		$('#jobs').DataTable();
	} );
</script>
@endsection