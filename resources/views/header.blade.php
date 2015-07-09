<nav class="navbar navbar-default" style="background-image: none">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="text-link" href="{{ url('/') }}">
                <img src="{{ asset('image/logo.jpg') }}" alt="Whizzspace Logo"/>
            </a>
        </div>

        <div class="collapse navbar-collapse clearfix" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('about') }}">About</a></li>
                <li><a href="{{ url('blog') }}">Blog</a></li>
                @if (Auth::guest())
                    <li><a href="{{ route('auth.login') }}">Login/SignUp</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ Auth::user()->first_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/profile') }}">Profile</a></li>
                            <li><a href="{{ route('auth.login') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
                {{--<li>--}}
                    {{--<p class="navbar-btn">--}}
                        {{--<a class="btn btn-white text-uppercase" href="{{ route('contest.create') }}">create contest</a>--}}
                    {{--</p>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
</nav>

@include('pills')