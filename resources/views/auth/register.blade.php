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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: #bababa;
        }
    </style>
</head>
<body>
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
                                    <a href="{{ url('/login/facebook') }}"
                                            class="btn btn-primary btn-large col-md-12 col-sm-12 col-xs-12">
                                        Sign Up With Facebook
                                    </a>
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
</body>
</html>
