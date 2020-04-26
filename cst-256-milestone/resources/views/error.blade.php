@extends('layouts.appmaster')
@section('title','Error')

@section('content')
	<div class="alert alert-danger" role="alert" style="width:20%;">
		{{$error_message}}
	</div>
@endsection