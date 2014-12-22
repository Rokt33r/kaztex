<h2>Sign In</h2>

{{Form::open(['route'=>'sessions', 'method'=>'post'])}}

@include('partials.errors')

<div class="form-group">
    {{Form::label('email', 'E-mail')}}
    {{Form::text('email', null, ['class'=>'form-control'])}}
</div>

<div class="form-group">
    {{Form::label('password', 'Password')}}
    {{Form::password('password', ['class'=>'form-control'])}}
</div>

<div class="form-group">
    {{Form::submit('Sign In', ['class'=>'btn btn-primary'])}}
    {{link_to_route('register', 'Sign Up', null, ['class'=>'btn btn-default'])}}
</div>

{{Form::close()}}