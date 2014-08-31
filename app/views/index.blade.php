@extends('master')

@section('headExt')
<link href="assets/css/index.css" rel="stylesheet">
@stop

@section('body')
@if(Auth::check())
<div class="container-fluid">
<div class="row">
	<div class="col-sm-4 col-md-3 col-lg-2 side-bar">
		<h1>Side Bar <small>⌘+¥</small></h1>
		<h2>My notes</h2>
		<ul>
		@if(Auth::user()->posts->isEmpty())
			<li>
				Empty...
			</li>
		@else
			@foreach(Auth::user()->posts as $post)
			<li>
				{{$post->title}}
			</li>
			@endforeach
		@endif
		</ul>
	</div>
	<div class="col-sm-8 col-md-9 col-lg-10">
		<h1>Welcome you, {{Auth::user()->name}}</h1>
		<p>You have no note now.</p>
		<button class="btn btn-primary">Make a new Note</button>
	</div>
</div>
</div>
@else

<div class="container">
	<div class="col-sm-6">
		<div class="jumbotron catch">
			<h1>KazTex</h1>
			<div class="catch-copy">Simple</div>
			<div class="catch-copy">Stylish</div>
			<div class="catch-copy">Swift</div>
			<h3>Note-taking App</h3>
				<h4>for students</h4>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="signin-form-container">
			<h2>Sign In</h2>
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
			{{Form::submit('Sign in',['class'=>'btn btn-primary'])}}
			<a href="{{route('signup.create')}}" class="btn btn-default">Sign Up</a>
		{{Form::close()}}
		</div>
	</div>
</div>
@endif
@stop
