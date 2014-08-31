<!DOCTYPE html>
<html>
    <head>
        <base href="/">
        <meta charset="UTF-8">
        <title>
            @yield('title')
        </title>
        <link href="assets/css/vendor/bootstrap.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <script src="assets/js/vendor/jquery-2.1.0.min.js"></script>
        <script src="assets/js/vendor/bootstrap.min.js"></script>
        @yield('headExt')
    </head>
    <body>
		@include('header')

        @yield('body')

        @yield('footExt')

		@include('alert')
    </body>
</html>
