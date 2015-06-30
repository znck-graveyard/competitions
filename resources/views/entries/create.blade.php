@extends('app')
@section('content')

    <div class="jumbotron picCheer darken">
        <hgroup style="text-align: center">
            <h1>Participate in the Contest</h1>

            <h3>Create opportunities, discover amazing talents, stay inspired. </h3>
        </hgroup>

    </div>

    <div class="container">
        <p>Please upload your entry in required file format and a small abstract to support the same. </p>

        {!! Form::open(['url'=>'submission/create','files'=> true]) !!}

        <div class="row">
            <div class="col-md-3">
                <label for="name">Title of the Submission*</label>
                <input type="text" class="form-control" placeholder="Enter title" name="title">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="abstract">Abstract*</label>
                <textarea class="form-control" rows="8" name="abstract"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <label for="file_name">SUBMISSION FILE*</label>
                    <input type="file" name="file_name">
                    <input type="text" name="file_name" class="form-control"
                           placeholder="enter link of the submission file">
                </div>
            </div>
            <div style="font-size: 90%;">
                Upload your submission or enter online link of the same
            </div>
        </div>

        <div>

            <label>TEAM MEMBERS(Enter Profile links of your team members,please do not mention yours)*</label>


            <div class="row">

                <div class="col-md-1">
                    <label><img src="">1</label>
                </div>
                <div class=" col-md-2">
                    <input type="text" class="form-control">
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-primary" style="margin-bottom: 20px;">ADD</button>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-1">
                    <button class="btn btn-primary">BACK</button>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">SUBMIT</button>


                </div>

            </div>
            <div style="font-size: 90%;">
                By Clicking Submit,you agree to term's and conditions
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection