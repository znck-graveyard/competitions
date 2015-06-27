@extends('app')

@section('head')


@endsection
@section('content')

    <div class="jumbotron picCheer darken">
        <hgroup style="text-align: center">
            <h1>Create a Contest</h1>

            <h3>Create opportunities, discover amazing talents, stay inspired. </h3>
        </hgroup>

    </div>
    <div class="container">
        <p><b>Before Creating contest please enter some information below.</b> </p>
        {!! Form::open(['url'=>'contest/createFirstTime','files'=> true]) !!}
        <div class="row margin_bottom">
            <div class="col-md-5">
                <label for="first_name">First Name*</label>
                <input type="text" class="form-control" name="first_name" placeholder="enter your first name">
            </div>
            <div class="col-md-5 col-md-offset-1">
                <label for="last_name">Last Name*</label>
                <input type="text" class="form-control" name="last_name" placeholder="enter your last name">

            </div>
        </div>

        <div class="row margin_bottom">
            <div class="col-md-5">
                <label for="first_name">User Name*</label>
                <input type="text" class="form-control" name="username" placeholder="enter your username">
            </div>
            <div class="col-md-5 col-md-offset-1">
                <label for="last_name">Email Id*</label>
                <input type="text" class="form-control" name="email" placeholder="enter your email id">

            </div>


        </div>
        <div class="row margin_bottom">
            <div class="form-group col-md-5">
                <label for="datepicker">Date Of Birth*</label>

                <div class=" date">
                    <input class="form-control datepicker " id="date_of_birth"
                           placeholder="Select Date of Birth"/>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <label for="gender">Gender*</label>
                <select class="input-large form-control"  name="gender">
                    <option value="" selected="selected">Select Gender</option>
                    <option value="MALE" >MALE</option>
                    <option value="FEMALE" >FEMALE</option>

                </select>
            </div>
        </div>
        <div class="row margin_bottom">
            <div class="col-md-5">
                <label  for="contest_banner">Profile Pic</label>
                <input type="file" accept="image/png, image/jpeg, image/gif" name="profile_pic"/>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <label  for="contest_banner">Cover Image</label>
                <input type="file" accept="image/png, image/jpeg, image/gif" name="cover_image"/>

            </div>
        </div>
        <div class="row margin_bottom">

            <div class="col-md-5">
                <label for="description">A Short Bio*</label>
                <textarea class="form-control" rows="6" name="short_bio" ></textarea>
            </div>

            <div class="col-md-5 col-md-offset-1">
<label>Be Socially Active</label>
                <table class="table">
                    <tr>
                        <td class="col-md-1 col-sm-1"><label ><img src="{{ URL::asset('/image/facebook150.png') }}" width="35" height="35"></label></td>

                        <td class="col-md-11 col-sm-11">
                            <input type="text" placeholder="facebook.com/username"
                                   class="form-control"
                                   name="facebook_username">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-1 col-sm-1"><label ><img src="{{ URL::asset('/image/twitter150.png') }}" width="35" height="35"></label></td>

                        <td class="col-md-11 col-sm-11">
                            <input type="text" placeholder="twitter.com/username"
                                   class="form-control"
                                   name="twitter_username">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-1 col-sm-1"><label ><img src="{{ URL::asset('/image/instagram150.png') }}" width="35" height="35"></label></td>

                        <td class="col-md-11 col-sm-11">
                            <input type="text" placeholder="instagram.com/username"
                                   class="form-control"
                                   name="instagram_username">
                        </td>
                    </tr>
                    </table>
            </div>

            </div>
        <div class="row margin_top" style="margin-left: 15px;">
            <div class="row " >
                <button class="btn btn-primary">BACK</button>
                <button type="submit" class="btn btn-primary">PROCEED</button>
            </div>
        </div>



        {!! Form::close() !!}

    </div>
@endsection