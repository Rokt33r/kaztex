<h2>Sign Up</h2>

{{Form::open(['route'=>'register', 'method'=>'post'])}}

@include('partials.errors')

<div class="form-group">
    {{Form::label('name', 'Username')}}
    {{Form::text('name', null, ['class'=>'form-control'])}}
</div>

<div class="form-group">
    {{Form::label('email', 'E-mail')}}
    {{Form::text('email', null, ['class'=>'form-control'])}}
</div>

<div class="form-group">
    {{Form::label('password', 'Password')}}
    {{Form::password('password', ['class'=>'form-control'])}}
</div>

<div class="form-group">
    {{Form::label('password_confirmation', 'Password(Re)')}}
    {{Form::password('password_confirmation', ['class'=>'form-control'])}}
</div>

<div class="form-group">
    {{Form::submit('Sign Up')}}
</div>

{{Form::close()}}