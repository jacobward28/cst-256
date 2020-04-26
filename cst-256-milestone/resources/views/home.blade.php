@extends('layouts.appmaster')
@section('title','Home')


@section('content')
	<h2>Home</h2><br>
	@if(isset($message))
		@switch($messageType)
			@case("warning") <div class="alert alert-warning" role="alert" style="width:40%;">{{$message}}</div> @break
			@case("danger") <div class="alert alert-danger" role="alert" style="width:40%;">{{$message}}</div> @break
			@case("success") <div class="alert alert-success" role="alert" style="width:40%;">{{$message}}</div> @break
		@endswitch
	@endif
@endsection