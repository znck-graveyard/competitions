<div class="form-group">
    <label for="entry" class="text-uppercase required">Your Entry</label>
    {!! Form::file('entry', ['class' => 'form-control input-lg', 'required' => '']) !!}
</div>
@if($errors->has('entry'))
    <div class="alert alert-danger">{!! $errors->first('entry') !!}</div>
@endif
