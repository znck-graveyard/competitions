<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title or 'Blah Blah Blah' }}</title>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
                        <button class="btn btn-default" name="contest_create" id="contest_create">CREATE CONTEST
                        </button>
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

            </ul>
        </div>
    </div>
</nav>

@yield('content')

<script type="text/javascript" src="{{ asset('/javascript/app.js') }}"></script>

</body>
</html>
