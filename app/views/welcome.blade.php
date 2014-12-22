@extends('layouts.default')

@section('title')
    Welcome!
@stop

@section('body')
    <div class="welcome container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Project Kaztex</h1>
                <div>Simple</div>
                <div>Swift</div>
                <div>Stylish</div>
            </div>
            <div class="col-sm-6">
                @include('partials.signup')
            </div>
        </div>
    </div>
@stop