@extends('template')
@section('body')
    <style>
        body {
            background: #bababa;
        }
    </style>
    <div id="image-signup">

        <div class="container-float">
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
                            ​



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


                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input type="text" class="form-control" name="first_name"
                                               value="{{ old('first_name') }}" placeholder="First Name">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input type="text" class="form-control" name="last_name"
                                               value="{{ old('last_name') }}" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="username"
                                               value="{{ old('username') }}" placeholder="Username">
                                    </div>
                                </div>

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

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="password_confirmation"
                                               placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit"
                                                class="btn btn-primary btn-large col-md-12 col-sm-12 col-xs-12"
                                                style="background: #ec6814;border-color: #ec6814">
                                            Sign Up
                                        </button>
                                    </div>
                                    <div style="float:right; font-size: 90%; position: relative; bottom:-10px; right:15px">
                                        Already a member? <a id="signinlink" href="{{ url('/auth/login') }}">Sign In</a>
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
