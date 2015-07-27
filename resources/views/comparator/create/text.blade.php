@extends('entries.create')

@section('form')
    <div class="col-xs-12">
        <div class="form-group">
            <label for="title" class="text-uppercase required">Title</label>
            {!! Form::text('title', null, ['class' => 'form-control input-lg', 'placeholder' => 'title of the submission', 'id' => 'title', 'required' => '']) !!}
        </div>
        @if($errors->has('title'))
            <div class="alert alert-danger">{!! $errors->first('title') !!}</div>
        @endif
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <label for="abstract" class="text-uppercase required">Content <small></small></label>
            {!! Form::textarea('content', null, ['class' => 'form-control input-lg', 'id' => 'abstract', 'required' => '', 'style' => 'resize: vertical']) !!}
        </div>
        @if($errors->has('content'))
            <div class="alert alert-danger">{!! $errors->first('content') !!}</div>
        @endif
    </div>
@endsection