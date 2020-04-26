@extends('layouts.appmaster')
@section('title','Login')

@section('content')
		<!-- Form to capture user login input -->
		<form action='loginHandler' id="testingLogin" method="POST">
			<input type="hidden" name="_token" value="<?php echo csrf_token()?>"/>
			<div class="form-group">
				<label for="uname">Username: </label>
				<input type="text" class="form-control" id="uname" style="width:20%;" name="username" value="tester"><br>
				@if($errors->first('username') != null)
					<div class="alert alert-danger" role="alert" style="width:20%;">{{$errors->first('username')}}</div>
				@endif
			</div>
			<div class="form-group">
				<label for="pword">Password: </label>
				<input type="password" class="form-control" id="pword" style="width:20%;" name="password" value="testing"><br>
				@if($errors->first('password') != null)
					<div class="alert alert-danger" role="alert" style="width:20%;">{{$errors->first('password')}}</div>
				@endif
			</div>
			<button type="submit" class="btn btn-primary">Login</button>
		</form>
		
		<!-- Link to take user to registration page -->
		<a href="Register">Register Here</a>
@endsection