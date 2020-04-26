

@extends('layouts.appmaster')
@section('title','Registration Result')

@section('content')
		<!-- Checks to see if the user was successfully registered in the database -->
		@if($result)
		<!-- Tells user they succeeded and gives them a link to the login page -->
		<h4 class="alert alert-success" role="alert" style="width:40%;">You Registered Successfully<br>
		<a href="Login" class="alert-link">Log In</a></h4>
		@else
		<!-- Tells the user that their registration failed and gives them a link back to the registration page to try again -->
		<h4 class="alert alert-danger" role="alert" style="width:40%;">Registration Failed<br>
		<a href="Register" class="alert-link">Try Again</a></h4>
		@endif
@endsection