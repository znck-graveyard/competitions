@section('styles')
    @parent
    <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


    <script>
        $(document).ready(function () {
            $('.input-group.date').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).datepicker('update', new Date());

        });
    </script>
@endsection

<div class="container">
    @if(count($errors))
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
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
    {!! Form::model($user, ['route'=>'profile.update','files'=> true]) !!}
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="first-name" class="text-uppercase required">First Name</label>
                        {!! Form::text('first_name', null, ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'enter your first name', 'id' => 'first-name']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="last-name" class="text-uppercase required">Last Name</label>
                        {!! Form::text('last_name', null, ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'enter your last name', 'id' => 'last-name']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="username" class="text-uppercase required">Username</label>
                        {!! Form::text('username', null, ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'choose your username', 'id' => 'username']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="email" class="text-uppercase required">email</label>
                        {!! Form::email('email', null, ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'enter your email', 'id' => 'email']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="text-uppercase required" for="dob">Date of Birth</label>

                        <div class="input-group date">
                            {!! Form::text('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : old('date_of_birth'), ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'select your date of birth', 'id' => 'dob', 'data-type'=>'date']) !!}
                            <span class="input-group-addon" style="cursor: pointer">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="text-uppercase required" for="gender">Gender</label>
                        {!! Form::select('gender', ['male' => 'male', 'female' => 'female', 'other' => 'other'], null, ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'enter your first name', 'id' => 'gender']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="file-input">
                        <div class="thumbnail pull-left">
                            <img id="profile_photo_preview" src="{{ route('user.photo', [$user->username ?: $user->id, 196]) }}"/>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>
                                        <a class="btn btn-default btn-huge text-uppercase" role="button">upload</a>
                                        {!! Form::file('profile_photo', ['class' => 'hidden']) !!}
                                        <span style="margin-left: 15px"><b>or</b></span>
                                    </label>
                                </div>

                                <div>
                                    {!! Form::text('profile_photo_link', old('cover_link'), ['class' => 'input-lg form-control', 'placeholder' => 'enter link of the photo',]) !!}
                                </div>

                                <script>
                                    $('[name=profile_photo]').on('change', function(ev) {
                                        var f = ev.target.files[0];
                                        var fr = new FileReader();

                                        fr.onload = function(ev2) {
                                            console.dir(ev2);
                                            $('#profile_photo_preview').attr('src', ev2.target.result);
                                        };

                                        fr.readAsDataURL(f);
                                    });

                                    $('[name=profile_photo_link]').on('change', function() {
                                        $('#profile_photo_preview').attr('src', $(this).val());
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <p style="margin-bottom: 15px">
                        <small>
                            Add a nice pic of yours for your WhizzSpace profile.
                        </small>
                    </p>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="file-input">
                        <div class="thumbnail pull-left">
                            <img id="cover_photo_preview" src="{{ route('user.cover', [$user->username ?: $user->id, 196]) }}"/>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>
                                        <a class="btn btn-default btn-huge text-uppercase" role="button">upload</a>
                                        {!! Form::file('cover_photo', ['class' => 'hidden']) !!}
                                        <span style="margin-left: 15px"><b>or</b></span>
                                    </label>
                                </div>

                                <div>
                                    {!! Form::text('cover_photo_link', old('cover_link'), ['class' => 'input-lg form-control', 'placeholder' => 'enter link of the photo',]) !!}
                                </div>

                                <script>
                                    $('[name=cover_photo]').on('change', function(ev) {
                                        var f = ev.target.files[0];
                                        var fr = new FileReader();

                                        fr.onload = function(ev2) {
                                            console.dir(ev2);
                                            $('#cover_photo_preview').attr('src', ev2.target.result);
                                        };

                                        fr.readAsDataURL(f);
                                    });

                                    $('[name=cover_photo_link]').on('change', function() {
                                        $('#cover_photo_preview').attr('src', $(this).val());
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <p style="margin-bottom: 15px">
                        <small>
                            Add a beautiful cover for your WhizzSpace profile.
                        </small>
                    </p>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="text-uppercase required" for="bio">A short bio</label>
                        {!! Form::textarea('bio', old('bio'), ['class' => 'input-lg form-control', 'required' =>'', 'placeholder' => 'tell everyone about you', 'id' => 'bio']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <label class="text-uppercase">Be socially active</label>

                    <div class="form-group">
                        <div class="input-with-icon">
                            <label for="twitter"><img src="{{ asset('image/social/twitter.png') }}"/></label>
                            {!! Form::text('connection_twitter', null, ['class' => 'input-lg form-control', 'placeholder' => 'twitter.com/username', 'id' => 'twitter']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-with-icon">
                            <label for="facebook"><img src="{{ asset('image/social/facebook.png') }}"/></label>
                            {!! Form::text('connection_facebook', null, ['class' => 'input-lg form-control', 'placeholder' => 'facebook.com/username', 'id' => 'facebook']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-with-icon">
                            <label for="instagram"><img src="{{ asset('image/social/instagram.png') }}"/></label>
                            {!! Form::text('connection_instagram', null, ['class' => 'input-lg form-control', 'placeholder' => 'instagram.com/username', 'id' => 'instagram']) !!}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row ">
                <div class="col-xs-12">
                    <a href="{{ route('home') }}" class="btn btn-blue btn-huge text-uppercase">Back</a>
                    <button type="submit" class="btn btn-primary btn-huge text-uppercase">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<br/>