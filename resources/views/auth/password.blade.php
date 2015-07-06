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
                                <img src="logo" alt="Whizzspace Logo"
                                     style="height: 96px; margin-bottom: 15px"/>
                            </div>
                        </div>
					@if (session('status'))
						<div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
					@endif

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
                        <form class="form clearfix" role="form" method="POST" action="{{ url('/password/email') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="email" class="form-control input-lg"
                                           name="email" value="{{ old('email') }}"
                                            placeholder="Your email address">
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary text-uppercase btn-block btn-huge">
                                        Send Password Reset Link
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
