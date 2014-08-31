@extends('master')

@section('headExt')
@stop

@section('body')
<div class="container">
	<h1>Sign In</h1>
	{{Form::open(['route'=>'sessions.store'])}}
		<div class="form-group">
			{{Form::label('email', 'E-mail')}}
			{{Form::text('email', '',['class'=>'form-control', 'placeholder'=>'E-mail.'])}}
			@if($errors->first('email'))
				<br>
				<div class="alert alert-danger" role="alert">{{$errors->first('email')}}</div>
			@endif
		</div>
		<div class="form-group">
			{{Form::label('password', 'Password')}}
			{{Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password.'])}}
			@if($errors->first('password'))
				<br>
				<div class="alert alert-danger" role="alert">{{$errors->first('password')}}</div>
			@endif
		</div>
		{{Form::submit('Sign In',['class'=>'btn btn-primary'])}}
		<a href="{{URL::previous()}}" class="btn btn-default">Back</a>
	{{Form::close()}}
</div>
@stop
