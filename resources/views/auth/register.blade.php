@extends('app')

@section('content')
    <div class="auth-banner"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" id="signup">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h3>Create account</h3>
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6" style="padding-right: 7.5px">
                                <a class="btn btn-facebook text-uppercase btn-huge btn-block" href="{{ route('auth.facebook') }}">
                                    Facebook
                                </a>
                            </div>
                            <div class="col-xs-6" style="padding-left: 7.5px">
                                <a class="btn btn-google text-uppercase btn-huge btn-block" href="{{ route('auth.google') }}">
                                    Google
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
                                action="{{ route('auth.signup') }}">
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
                                            <a class="text-link" href="{{ route('auth.login') }}">Already a member? Sign In</a>
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
