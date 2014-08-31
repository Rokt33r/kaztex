@extends('master')

@section('headExt')
@stop

@section('body')

<div class="container">
	<h1>Sign Up</h1>
{{Form::open(['route'=>'signup.store'])}}

	<h2>for Authentification</h2>

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

	<div class="form-group">
		{{Form::password('repassword', ['class'=>'form-control', 'placeholder'=>'Password(Double Chk)'])}}
		@if($errors->first('repassword'))
			<br>
			<div class="alert alert-danger" role="alert">{{$errors->first('repassword')}}</div>
		@endif
	</div>




	<h2>and Some informations...</h2>

	<div class="form-group">
		{{Form::label('name', 'Name')}}
		{{Form::text('name', '',['class'=>'form-control', 'placeholder'=>'Name'])}}
		@if($errors->first('name'))
			<br>
			<div class="alert alert-danger" role="alert">{{$errors->first('name')}}</div>
		@endif
	</div>



	{{Form::submit('Sign Up',['class'=>'btn btn-primary'])}}
	<a href="{{URL::previous()}}" class="btn btn-default">Back</a>


{{Form::close()}}
</div>
@stop
