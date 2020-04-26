

@extends('layouts.appmaster')
@section('title','User Admin')

<!-- Imports needed for the included Jquery table to work properly -->
@section('imports')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<!--<link rel="stylesheet" type="text/css" href="public/css/table.css">-->
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
</style>
@endsection

@section('content')

<!-- Prints out any errors if there are any after an admin has attempted to edit a user -->
@if($errors->count() != 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger" role="alert" style="width:20%;">{{$error}}</div><br>
	@endforeach
@endif

<!-- Data table using jquery for managaing users -->
<table id="users" class="table table-striped table-bordered" style="width:85%;">
	<thead>
		<tr>
<!-- 			All the column names for the table -->
			<th scope="col">ID</th>
			<th scope="col">Username</th>
			<th scope="col">Password</th>
			<th scope="col">Email</th>
			<th scope="col">First Name</th>
			<th scope="col">Last Name</th>
			<th scope="col">Status</th>
			<th scope="col">Role</th>
			<th scope="col">Edit</th>
			<th scope="col">Edit Profile</th>
			<th scope="col">Delete</th>
		</tr>
	</thead>
	<tbody>
<!-- 		Iterates over each user returned with this page -->
		@foreach($results as $user)
			<tr>
<!-- 				Iterates over each value for that specific user to allow administrators to view all of a user's information -->
				@foreach($user as $value)
					<td>{{$value}}</td>
				@endforeach
<!-- 				Bootstrap modal for editing users -->
				<div class="modal fade" id="editModal{{$user['IDUSERS']}}" tabindex="-1" role="dialog" aria-labelledby="{{$user['IDUSERS']}}eLabel" aria-hidden="true">
  					<div class="modal-dialog" role="document">
  						<div class="modal-content">
      						<div class="modal-header">
        						<h5 class="modal-title" id="ModalLabel">Edit User</h5>
        						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          							<span aria-hidden="true">&times;</span>
        						</button>
      						</div>
      						<div class="modal-body">
<!--       							Form contained within the modal for the actual editing of the users -->
        						<form id="edit{{$user['IDUSERS']}}" action="userEditHandler" method="post"></form>
        							<div class="form-group">
        								<input form="edit{{$user['IDUSERS']}}" type="hidden" name="_token" value="<?php echo csrf_token()?>"/>
        								<input form="edit{{$user['IDUSERS']}}" type="hidden" name="id" value="{{$user['IDUSERS']}}">
        								<label class="formLabel" for="uname">Username: </label>
										<input form="edit{{$user['IDUSERS']}}" type="text" class="form-control" id="uname" value="{{$user['USERNAME']}}" name="username"><br>
										<label class="formLabel" for="pword">Password: </label>
										<input form="edit{{$user['IDUSERS']}}" type="text" class="form-control" id="pword" value="{{$user['PASSWORD']}}" name="password"><br>
										<label class="formLabel" for="email">Email: </label>
										<input form="edit{{$user['IDUSERS']}}" type="text" class="form-control" id="email" value="{{$user['EMAIL']}}" name="email"><br>
										<label class="formLabel" for="fname">First Name: </label>
										<input form="edit{{$user['IDUSERS']}}" type="text" class="form-control" id="fname" value="{{$user['FIRSTNAME']}}" name="firstname"><br>
										<label class="formLabel" for="lname">Last Name: </label>
										<input form="edit{{$user['IDUSERS']}}" type="text" class="form-control" id="lname" value="{{$user['LASTNAME']}}" name="lastname"><br>
										<label class="formLabel" for="status">Status: </label>
										<select form="edit{{$user['IDUSERS']}}" class="form-control" id="status" name="status">
											<option value="1" <?php if($user['STATUS']==1){echo "selected";}?>>Active</option>
											<option value="0" <?php if($user['STATUS']==0){echo "selected";}?>>Suspended</option>
										</select>
										<label class="formLabel" for="role">Role: </label>
										<select form="edit{{$user['IDUSERS']}}" class="form-control" id="role" name="role">
											<option value="0" <?php if($user['ROLE']==0){echo "selected";}?>>User</option>
											<option value="1" <?php if($user['ROLE']==1){echo "selected";}?>>Admin</option>
										</select>
									</div>
      						</div>
      						<div class="modal-footer">
<!--       							Button to close user edit modal -->
        						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<!--         						Button to submit changes made to user to the admin controller -->
        						<button form="edit{{$user['IDUSERS']}}" type="submit" class="btn btn-primary">Save changes</button>
      						</div>
    					</div>
  					</div>
				</div>
<!-- 				Button to open user edit modal -->
				<td><button type="button" class="btn btn-primary" data-toggle="modal" href="#editModal{{$user['IDUSERS']}}">Edit</button></td>
				<form id="viewProfile{{$user['IDUSERS']}}" action="userProfile" method="get"></form>
				<input form="viewProfile{{$user['IDUSERS']}}" type="hidden" name="_token" value="{{csrf_token()}}"/>
				<input form="viewProfile{{$user['IDUSERS']}}" type="hidden" name="ID" value="{{$user['IDUSERS']}}"/>
				<td><button type="submit" class="btn btn-primary" form="viewProfile{{$user['IDUSERS']}}">View Profile</button>
<!-- 				Button to open the delete confirmation modal -->
				<td><button type="button" class="btn btn-primary" data-toggle="modal" href="#deleteModal{{$user['IDUSERS']}}">Delete</button></td>
<!-- 				Delete confirmation modal -->
				<div class="modal fade" id="deleteModal{{$user['IDUSERS']}}" tabindex="-1" role="dialog" aria-labelledby="{{$user['IDUSERS']}}dLabel" aria-hidden="true">
  					<div class="modal-dialog" role="document">
    					<div class="modal-content">
      						<div class="modal-header">
        						<h5 class="modal-title" id="ModalLabel">Warning!</h5>
        						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          							<span aria-hidden="true">&times;</span>
        						</button>
      						</div>
      						<div class="modal-body" id="ModalLabel">
      							<p>
      							Are you sure that you want to delete this user? This will be permanent and is not recommended.
      							It's recommended that you edit and suspend a user instead.
      							</p>
<!--       							Form containing hidden inputs containing necessary information -->
        						<form id="delete{{$user['IDUSERS']}}" action="userRemoveHandler" method="post"></form>
								<input form="delete{{$user['IDUSERS']}}" type="hidden" name="_token" value="<?php echo csrf_token()?>"/>
								<input form="delete{{$user['IDUSERS']}}" type="hidden" name="id" value="{{$user['IDUSERS']}}"/>
      						</div>
      						<div class="modal-footer">
<!--       							Button to close the modal -->
        						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<!--         						Button that submits delete form -->
       	 						<button form="delete{{$user['IDUSERS']}}" type="submit" class="btn btn-primary">Delete</button>
      						</div>
    					</div>
  					</div>
				</div>
			</tr>
		@endforeach
	</tbody>
</table>

<!-- Script from dataable to enable jquery functionality -->
<script>
	$(document).ready( function () {
  		$('#users').DataTable();
	} );
</script>
@endsection