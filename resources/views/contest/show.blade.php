@extends('app')

@section('title'){{ $contest->name }}@endsection

@section('content')
    <br/>
    <div class="container">
        <div class="row row-eq-height">
            <div class="col-xs-12 col-md-9">
                <img src="{{ $contest->image or 'https://unsplash.it/900/500/?random&' . str_random(4) }}" alt=""/>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-contests">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="text-uppercase">In the front</span> | {{ $contest->entries()->count() }} Entries
                        </h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection