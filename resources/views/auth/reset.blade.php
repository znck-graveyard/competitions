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
                            <img src="{{ url('image/logo.svg') }}" alt="Whizzspace Logo"
                                 style="height: 96px; margin-bottom: 15px"/>
                        </div>
                    </div>
                    @if (count($errors) > 0)
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
                        <form class="form clearfix" role="form" method="POST" action="{{ url('/password/reset') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}"
                                            placeholder="email address">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control input-lg" name="password"
                                            placeholder="password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-huge btn-block text-uppercase">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
