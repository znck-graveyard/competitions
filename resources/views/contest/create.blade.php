@extends('app')
@section('styles')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.14.30/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.14.30/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select option:first').attr('disabled', '');

            $(function () {
                $('[data-toggle="popover"]').popover({trigger: 'hover'})
            })

            $('.picker-date, .picker-date > input').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'en'
            });

            $('.picker-time, .picker-time > input').datetimepicker({
                format: 'LT',
                locale: 'en'
            });
        });
    </script>
@endsection

@section('content')

    <div class="banner-slim underlay" style="background-image: url('{{ asset('image/banner-preferences.jpg') }}')">
        <div class="text-white text-center">
            <h1>Create a Contest</h1>

            <h3>Create opportunities, discover amazing talents, stay inspired.</h3>
        </div>
    </div>

    <div class="container">
        <br>
        @if(count($errors))
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                    </div>
                </div>
            </div>
        @endif

        {!! Form::model($contest, ['url' => $action,'files' => true,'method' => isset($method) ? $method : 'post']) !!}
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="name" class="text-uppercase required">Name of the Contest</label>
                            {!! Form::text('name', null, ['class' => 'input-lg form-control', 'required' => '', 'placeholder' => 'enter name of the contest', 'id' => 'name']) !!}
                        </div>
                        @if($errors->has('name')) <div class="alert alert-danger"> {{ $errors->first('name') }} </div> @endif
                    </div>

                    @if($errors->has('slug'))
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="slug" class="text-uppercase required">URL of the contest</label>
                                {!! Form::text('slug', null, ['class' => 'input-lg form-control', 'required' => '', 'placeholder' => 'unique url to the contest', 'id' => 'slug']) !!}
                            </div>
                            @if($errors->has('slug')) <div class="alert alert-danger"> {{ $errors->first('slug') }} </div> @endif
                        </div>
                    @endif

                    <div class="col-xs-12 col-sm-6">
                        <div class="row row-has-2-children">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="type" class="text-uppercase required">Contest Type</label>
                                    {!! Form::select('contest_type', $contestTypes, null, ['class' => 'input-lg form-control', 'required' => '', 'id' => 'type']) !!}
                                </div>
                                @if($errors->has('contest_type')) <div class="alert alert-danger"> {{ $errors->first('contest_type') }} </div> @endif
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="submission_type" class="text-uppercase required">Submission Format</label>
                                    {!! Form::select('submission_type', $submissionTypes, null, ['class' => 'input-lg form-control', 'required' => '', 'id' => 'submission_type']) !!}
                                </div>
                                @if($errors->has('submission_type')) <div class="alert alert-danger"> {{ $errors->first('submission_type') }} </div> @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="row row-has-2-children">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="start_date" class="text-uppercase required">Start Date</label>

                                    <div class="input-group picker-date date input-group-lg">
                                        {!! Form::text('start_date', null, ['class' => 'input-lg form-control', 'required' => '', 'id' => 'start_date', 'placeholder' => 'select start date']) !!}
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('start_date')) <div class="alert alert-danger"> {{ $errors->first('start_date') }} </div> @endif
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="start_time" class="text-uppercase required">Start Time</label>

                                    <div class="input-group date picker-time input-group-lg">
                                        {!! Form::text('start_time', null, ['class' => 'input-lg form-control', 'required' => '', 'id' => 'start_time', 'placeholder' => 'select start time']) !!}
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('start_time')) <div class="alert alert-danger"> {{ $errors->first('start_time') }} </div> @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="row row-has-2-children">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="end_date" class="text-uppercase required">end Date</label>

                                    <div class="input-group date picker-date input-group-lg">
                                        {!! Form::text('end_date', null, ['class' => 'input-lg form-control', 'required' => '', 'id' => 'end_date', 'placeholder' => 'select end date']) !!}
                                        <span class="input-group-addon"><i
                                                    class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('end_date')) <div class="alert alert-danger"> {{ $errors->first('end_date') }} </div> @endif
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="end_time" class="text-uppercase required">end Time</label>

                                    <div class="input-group date picker-time input-group-lg">
                                        {!! Form::text('end_time', null, ['class' => 'input-lg form-control', 'required' => '', 'id' => 'end_time', 'placeholder' => 'select end time']) !!}
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('end_time')) <div class="alert alert-danger"> {{ $errors->first('end_time') }} </div> @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="description" class="text-uppercase required">Description</label>
                            {!! Form::textarea('description', null, ['class' => 'input-lg form-control', 'required' => '', 'placeholder' => 'tell about the contest (markdown accepted.)', 'id' => 'description']) !!}
                        </div>
                        @if($errors->has('description')) <div class="alert alert-danger"> {{ $errors->first('description') }} </div> @endif
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="rules" class="text-uppercase required">Rules and Regulations</label>
                            {!! Form::textarea('rules', null, ['class' => 'input-lg form-control', 'required' => '', 'placeholder' => 'tell about the contest (markdown accepted.)', 'id' => 'rules']) !!}
                        </div>
                        @if($errors->has('rules')) <div class="alert alert-danger"> {{ $errors->first('rules') }} </div> @endif
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="max_entries" class="text-uppercase required">Maximum submissions per person</label>
                            {!! Form::input('number', 'max_entries', null, ['class' => 'input-lg form-control', 'required' => '', 'min' => 1, 'placeholder' => 'max. submissions', 'id' => 'max_entries']) !!}
                        </div>
                        @if($errors->has('max_entries')) <div class="alert alert-danger"> {{ $errors->first('max_entries') }} </div> @endif
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="max_iteration" class="text-uppercase required">Maximum iterations per submission</label>
                            {!! Form::input('number', 'max_iteration', null, ['class' => 'input-lg form-control', 'required' => '', 'min' => 1, 'placeholder' => 'max. iterations', 'id' => 'max_iteration']) !!}
                        </div>
                        @if($errors->has('max_iteration')) <div class="alert alert-danger"> {{ $errors->first('max_iteration') }} </div> @endif
                    </div>

                    <div class="col-xs-12">
                        <div class="row row-eq-height">
                            <div class="col-xs-12 col-sm-6">
                                <label class="text-uppercase">Contest Banner</label>
                                <div class="file-input">
                                    <div class="thumbnail pull-left">
                                        <img src="{{ $contest->exists ? route('contest.cover', [$contest->slug, 196]) : asset('image/placeholder.jpg') }}"/>
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
                                        </div>
                                    </div>
                                </div>
                                <p style="margin-bottom: 15px">
                                    <small>
                                        Add a nice photo to the event banner.
                                    </small>
                                </p>
                                @if($errors->has('cover_photo')) <div class="alert alert-danger"> {{ $errors->first('cover_photo') }} </div> @endif
                                @if($errors->has('cover_photo_link')) <div class="alert alert-danger"> {{ $errors->first('cover_photo_link') }} </div> @endif
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <label class="text-uppercase required">Prizes</label>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">1st prize</span>
                                        {!! Form::text('prize_1', null, ['class' => 'input-lg form-control', 'required' => '']) !!}
                                    </div>
                                </div>
                                @if($errors->has('prize_1')) <div class="alert alert-danger"> {{ $errors->first('prize_1') }} </div> @endif
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">2nd prize</span>
                                        {!! Form::text('prize_2', null, ['class' => 'input-lg form-control', 'required' => '']) !!}
                                    </div>
                                </div>
                                @if($errors->has('prize_2')) <div class="alert alert-danger"> {{ $errors->first('prize_2') }} </div> @endif
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">3rd prize</span>
                                        {!! Form::text('prize_3', null, ['class' => 'input-lg form-control', 'required' => '']) !!}
                                    </div>
                                </div>
                                @if($errors->has('prize_3')) <div class="alert alert-danger"> {{ $errors->first('prize_3') }} </div> @endif
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">Total</span>
                                        {!! Form::text('prize', null, ['class' => 'input-lg form-control', 'required' => '', 'placeholder' => 'total prize worth']) !!}
                                    </div>
                                </div>
                                @if($errors->has('prize')) <div class="alert alert-danger"> {{ $errors->first('prize') }} </div> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-huge btn-wide btn-primary text-uppercase">Save</button>
            </div>
        </div>
        {!! Form::close() !!}
        <br>
    </div>
@endsection