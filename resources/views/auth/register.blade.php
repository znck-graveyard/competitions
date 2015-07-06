@extends('app')

@section('scripts')
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1458806661106453',
                xfbml      : true,
                version    : 'v2.3'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection

@section('content')
    <div class="auth-banner"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" id="signup">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <img src="logo" alt="Whizzspace Logo"
                                    style="height: 96px; margin-bottom: 15px"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <a class="btn btn-facebook text-uppercase btn-huge btn-block" href="#">
                                    Sign Up With Facebook
                                </a>
                            </div>
                        </div>
                        <hr/>
                        @if(count($errors) > 0)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <form class="form clearfix" role="form" method="POST"
                                action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="col-xs-6" style="padding-right: 7.5px">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" name="first_name"
                                               value="{{ old('first_name') }}" placeholder="first name">
                                    </div>
                                </div>

                                <div class="col-xs-6" style="padding-left: 7.5px">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" name="last_name"
                                               value="{{ old('last_name') }}" placeholder="last name">
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" name="username"
                                               value="{{ old('username') }}" placeholder="username">
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control input-lg" name="email"
                                               value="{{ old('email') }}"
                                               placeholder="email address">
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="password" class="form-control input-lg" name="password"
                                               placeholder="password">
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-huge btn-block text-uppercase"
                                                type="submit"> Sign Up </button>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <small class="pull-right text-uppercase">
                                            Already a member? <a class="text-link" href="{{ url('/auth/login') }}">Sign In</a>
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
