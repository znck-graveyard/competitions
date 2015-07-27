@extends('app')

@section('scripts')
    <script>
        $(function(){
            $('[data-toggle=tooltip]').tooltip();
        });
    </script>
@endsection

@section('content')
    <div class="banner-slim underlay" style="background-image: url('{{ asset('image/banner-preferences.jpg') }}')">
        <div class="text-white text-center">
            <h1>Participate in the Contest</h1>

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

        {!! Form::model($entry, ['url' => $action, 'files'=> true, 'method' => $method]) !!}
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="row">
                    @yield('form')

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="text-uppercase">
                                {!! Form::checkbox('agree', null, null, ['required' => '']) !!} I agree <a href="{{ url('terms')  }}" target="_blank" title="open in new tab" data-toggle="tooltip">terms and conditions</a> of Wizzspace.
                            </label>
                        </div>
                        @if($errors->has('agree'))
                            <div class="alert alert-danger">{!! $errors->first('agree') !!}</div>
                        @endif
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            {!! Form::submit('submit', ['class' => 'btn btn-huge btn-wide btn-primary text-uppercase']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection