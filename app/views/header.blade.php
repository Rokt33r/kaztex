<nav class="navbar navbar-default" role="navigation">
<div class="container-fluid">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="#">KazTex <small>prototype</small></a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

	@if(Auth::check())
	<ul class="nav navbar-nav navbar-right">

		<p class="navbar-text hidden-xs">Welcome you,
			<a href="#" class="navbar-link">{{Auth::user()->name}}</a>&nbsp;
		</p>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="{{route('signout')}}">Sign Out</a></li>
          </ul>
        </li>
	</ul>
	@else
	<ul class="nav navbar-nav navbar-right">
		<li><a href="{{route('signin')}}">Sign in</a></li>
		<li><a href="{{route('signup.create')}}">Sign up</a></li>
	</ul>
	@endif
	</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
