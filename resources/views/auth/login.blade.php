@extends('template')
@section('body')
    <style>
        body {
            background: #bababa;
        }
    </style>
    <div id="image-signup">

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4" id="signup">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="row" style="margin:45px;padding-left:45px">
                                <p>LOGO</p>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit"
                                            class="btn btn-primary btn-large col-md-12 col-sm-12 col-xs-12">
                                        Sign Up With Facebook
                                    </button>
                                </div>
                            </div>

                            <table width="100%">
                                <td>
                                    <hr/>
                                </td>
                                <td style="width:1px; padding: 0 10px; white-space: nowrap;">Or</td>
                                <td>
                                    <hr/>
                                </td>
                            </table>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                               placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="password"
                                               placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div >
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="btn btn-primary btn-large col-md-12 col-sm-12 col-xs-12"
                                                    style="background: #ec6814;border-color: #ec6814">
                                                Sign In
                                            </button>
                                        </div>

                                        <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your
                                            Password?</a>
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
