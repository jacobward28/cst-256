

@extends('layouts.appmaster')
@section('title','Login Results')

@section('content')
		<!-- Checks to see the result of the attempted log in -->
		@if($result)
			<!-- Checks to see that the user's account has not been suspended -->
			@if($status)
				<h3 class="alert alert-success" role="alert" style="width:30%;">You logged in successfully</h3>
			@else
				<!-- If the user's account has been suspended flushes the session and gives a message to the user -->
				<div class="alert alert-danger" role="alert" style="width:40%;">Your account has been disabled please contact an administrator</div>
			@endif
		@else
			<!-- Lets the user know that they entered invalid login credentials -->
			<div class="alert alert-danger" role="alert" style="width:20%;"><h3>Invalid login credentials</h3>
			<a href="Login" class="alert-link">Try Again</a></div>
		@endif
@endsection