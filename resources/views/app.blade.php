<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title',  'Blah Blah Blah')</title>

    <meta name="csrf_token" content="{{ csrf_token() }}"/>
    @yield('meta')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="stylesheet" href="http://brevelabs.com/css/badge.css">

    <script src="{{ asset('javascript/jquery.min.js') }}"></script>
    <script src="{{ asset('javascript/jquery.jcarousel.min.js') }}"></script>
    <script async src="{{ asset('javascript/bootstrap.min.js') }}"></script>

    @yield('head')
    @yield('head.scripts')
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">XYZ.com</a>
        </div>

        <div class="collapse navbar-collapse clearfix" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('/') }}">About</a></li>
                <li><a href="{{ url('/faq') }}">FAQ</a></li>
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/register') }}">Login/SignUp</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ Auth::user()->first_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/profile') }}">Profile</a></li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
                <li>
                    <p class="navbar-btn">
                        <a class="btn btn-white text-uppercase" href="#">create contest</a>
                    </p>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="content-wrapper">
    @yield('content')
</div>

@include('footer')

<script type="text/javascript" src="{{ asset('/javascript/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
@yield('scripts')
<script>
    var $buoop = {c: 2};
    function $buo_f() {
        var e = document.createElement("script");
        e.src = "//browser-update.org/update.min.js";
        document.body.appendChild(e);
    }

    try {
        document.addEventListener("DOMContentLoaded", $buo_f, false)
    }
    catch (e) {
        window.attachEvent("onload", $buo_f)
    }
</script>
</body>
</html>
