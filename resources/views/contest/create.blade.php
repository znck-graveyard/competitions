@extends('app')
@section('head')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.0/jquery.timepicker.min.css">
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.0/jquery.timepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#startdatepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());

        });
        $(document).ready(function() {
            $("#enddatepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());

        });
    </script>



@endsection
@section('content')

    <div class="jumbotron picCheer darken">
        <hgroup style="text-align: center">
            <h1>Create a Contest</h1>

            <h3>Create opportunities, discover amazing talents, stay inspired. </h3>
        </hgroup>

    </div>
    <div class="container">
        <p>Please fill all the details regarding the Contest below.. </p>

        {!! Form::open(['url'=>'contest/create','files'=> true]) !!}
        <div class="row">
            <div class="col-md-5">
                <label for="name">Name of the Contest*</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name of Contest">
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Contest Type*</label>
                            <select class="input-large form-control" id="type" name="type">
                                <option value="" selected="selected">Select anyone Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>

                                @endforeach


                            </select>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label for="submission_type">Submission Format*</label>
                        <select class="input-large form-control" id="submission_type" name="submission_type">
                            <option value="" selected="selected">Select format</option>
                            @foreach($submission_types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date*</label>

                            <div id="startdatepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" readonly placeholder="Select Start Date" name="start_date"/>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time">Time*</label>

                            <div>
                                <input type="text" class="form-control time" name="start_time"
                                       placeholder="hrs:min:sec"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date*</label>

                            <div id="enddatepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" readonly placeholder="Select End Date" name="end_date"/>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_time">Time*</label>
                            <input type="text" class="form-control time" name="end_time" placeholder="hrs:min:sec"/>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-5">
                <label for="description">Description*</label>
                <textarea class="form-control" rows="6" name="description" style="margin-bottom: 15px;"></textarea>
            </div>

            <div class="col-md-5 col-md-offset-1">
                <label for="rules">Rules And Regulations*</label>
                <textarea class="form-control" rows="6" name="rules" style="margin-bottom: 15px;"></textarea>
            </div>


        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <table class="table ">
                        <tr>
                            <div class="col-md-6">
                                <label for="max_entries">Max Entries Per Person*</label>
                                <input type="text" class="form-control" name="max_entries">
                            </div>
                            <div class="col-md-6">
                                <label for="max_iteration">Max Iteration per Entry*</label>
                                <input type="text" class="form-control" name="max_iteration">
                            </div>
                        </tr>
                        <tr>
                            <label style="margin-top:25px !important; margin-left:10px;" for="contest_banner">Contest
                                Banner Creative*</label>
                            <input type="file" accept="image/png, image/jpeg, image/gif" name="contest_banner"/>

                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">

                <label for="prize">Prizes*</label>

                <div>
                    <table class="table ">
                        <tr>
                            <td class="col-md-1 col-sm-1"><label class="prize_label">1</label></td>

                            <td class="col-md-11 col-sm-11">
                                <input type="text"
                                       class="form-control"
                                       name="">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-1 col-sm-1 "><label class="prize_label">2</label></td>

                            <td class="col-md-11 col-sm-11">
                                <input type="text"
                                       class="form-control"
                                       name="">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-1 col-sm-1 "><label class="prize_label">3</label></td>

                            <td class="col-md-11 col-sm-11">
                                <input type="text"
                                       class="form-control"
                                       name="">
                            </td>
                        </tr>
                    </table>

                </div>
                <button class="btn btn-primary" style="margin-bottom: 20px;">Add</button>

            </div>


        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6">
                        <label><input type="radio" name="review" value="peer_review_enabled">PEER BASED REVIEW</label>
                        <select class="input-large form-control" id="peer_review_weightage"
                                name="peer_review_weightage">
                            <option value="" selected="selected">Select Weightage</option>

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label><input type="radio" name="review" value="manual_review_enabled">MANUAL REVIEW</label>
                        <select class="input-large form-control" id="manual_review_weightage"
                                name="manual_review_weightage">
                            <option value="" selected="selected">Select Weightage</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="row">
                    <div class="col-md-12">
                        <label><input type="checkbox" name="team_entry_enabled" value=true>Allow
                            Team Entries</label>
                        <select class="input-large form-control"
                                name="team_size">
                            <option value="" selected="selected">max members in a team</option>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row margin_top" style="margin-left: 15px;">

            <label>Judges For Manual Review(only in case of Manual Review)*</label>

            <div class="row" style="margin-left: 15px;">
                <div class="form-group">
                    <div class="col-md-2">
                        <div class="row margin_right">
                            <input type="text" class="form-control " name="judge_name" placeholder="Name of the judge">
                        </div>
                        <div class="row margin_right">
                            <input type="text" class="form-control" name="judge_email" placeholder="Email of the judge">
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="row margin_right">
                            <input type="text" class="form-control " name="judge_name" placeholder="Name of the judge">
                        </div>
                        <div class="row margin_right">
                            <input type="text" class="form-control" name="judge_email" placeholder="Email of the judge">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row margin_top" style="margin-left: 15px;">
            <div class="row ">
                <button class="btn btn-primary">BACK</button>
                <button type="submit" class="btn btn-primary">CREATE</button>
            </div>
        </div>


        {!! Form::close() !!}


    </div>




@endsection