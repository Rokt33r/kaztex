<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>
        @yield('title')
    </title>
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
    @yield('head')
</head>
<body>

@yield('body')

@yield('foot')

</body>
</html>