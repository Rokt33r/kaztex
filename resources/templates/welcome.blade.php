@extends('layouts.default')

@section('title')
Welcome
@stop
@section('body')
	<div class="welcome row">
		<div class="col-sm-6">
			<h1>Project Kaztex</h1>
		</div>
		<div class="col-sm-6">
			@include('partials.signup')
		</div>
	</div>
@stop