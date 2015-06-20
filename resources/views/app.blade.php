@extends('template')
@section('body')
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
                            <button class="btn btn-default">CREATE CONTEST</button>
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


