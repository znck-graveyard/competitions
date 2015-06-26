<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ asset('/javascript/app.js') }}"></script>


    @yield('head')
</head>
<body>


<nav class="navbar navbar-default" role="navigation" id="navbar-head">
    <div class="navbar-inner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">XYZ.com</a>
            </div>


            <div class="collapse navbar-collapse" id="navbar-collapse">
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
                        <button class="btn btn-default" name="contest_create" id="contest_create">CREATE CONTEST</button>
                    </li>
                </ul>


            </div>

        </div>
    </div>
</nav>
<nav class="navbar navbar-default " role="navigation" id="secondary-nav">
    <div class="container">
        <div class="navbar-inner" id="contest-category">
        <ul class="nav navbar-nav ">
            <li><a href="{{ URL::to('contest/ART') }}">ART</a></li>
            <li><a href="{{ URL::to('contest/MUSIC') }}">MUSIC</a></li>
            <li><a href="{{ URL::to('contest/DANCE') }}">DANCE</a></li>
            <li><a href="#">SINGING</a></li>
            <li><a href="#">PHOTOGRAPHY</a></li>
            <li><a href="#">SHORT FILMS</a></li>
            <li><a href="#">CONTENT WRITING</a></li>
            <li><a href="#">BUSINESS IDEA</a></li>
        </ul>
        </div>
    </div>
</nav>

@yield('content')

</body>
</html>
