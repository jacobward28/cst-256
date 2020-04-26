@extends('layouts.appmaster')
@section('title','Job Posting')

@section('content')
	<div class="card border" style="width: 70%;margin: auto;margin-top: 20%;">
        <div class="card-header">
            <h5 class="text mb-0">{{$job['TITLE']}}</h5>
        </div>
        <div class="card-body">
            <p>
            	Company: {{$job['COMPANY']}}<br>
            	Location: {{$job['CITY']}}, {{$job['STATE']}}<br>
            	Description: {{$job['DESCRIPTION']}}
            </p>
            @if(Session::has('ID'))
            	@if(!$applied)
            		<form action="jobApply" method="post">
            			<input type="hidden" name="_token" value="{{csrf_token()}}">
            			<input type="hidden" name="jobID" value="{{$job['IDJOBS']}}">
            			<input type="hidden" name="userID" value="{{Session::get('ID')}}">
            			<button type="submit" class="btn btn-primary">Apply</button>
            		</form>
            	@else
            		<form action="jobCancel" method="post">
            			<input type="hidden" name="_token" value="{{csrf_token()}}">
            			<input type="hidden" name="jobID" value="{{$job['IDJOBS']}}">
            			<input type="hidden" name="userID" value="{{Session::get('ID')}}">
            			<button type="submit" class="btn btn-primary">Cancel Application</button>
            		</form>
            	@endif
            @else
            	<div class="alert alert-warning" style="width:40%;">Please login if you'd like to apply</div>
            @endif
        </div>
	</div>
@endsection