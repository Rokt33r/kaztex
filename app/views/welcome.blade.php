@extends('layouts.default')

@section('title')
    Welcome!
@stop

@section('body')
    <div class="welcome container">
        <div class="row">
            <div class="col-sm-6 catch">
                <h1>Project<br>Kaztex</h1>
                <p>Simple</p>
                <p>Swift</p>
                <p>Stylish</p>
            </div>
            <div class="col-sm-6">
                @include('partials.signup')
            </div>
        </div>
<hr>
        <div class="about row">
            <div class="col-sm-6 col-sm-offset-3">
                <h2>Spec</h2>
                <p>powered by Laravel 4.2.* + Angular 1.3.*</p>
            </div>
            <div class="col-sm-6 col-sm-offset-3">
                <h2>Author</h2>
                <p>
                    Dick Choi &lt;dkchoi&commat;kazup.co&gt;<br>
                    Yokomizo Kazumasa
                </p>
            </div>
            <div class="col-sm-6 col-sm-offset-3">
                <h2>Contributor</h2>
                <p>
                    Viling Venture Partners<br>
                    Street Academy
                </p>
            </div>


        </div>
    </div>
@stop