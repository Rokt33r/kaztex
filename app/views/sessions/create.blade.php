@extends('layouts.default')

@section('title')
    Sign In
@stop

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                @include('partials.signin')
            </div>
        </div>
    </div>
@stop