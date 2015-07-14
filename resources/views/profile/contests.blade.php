@extends('app')
@section('title'){{ $user->name . '  - WhizzSpace' }}@endsection

@section('content')
    <div class="container">
        <br>
        <div class="panel panel-contests">
            <div class="panel-heading">
                <div class="panel-title">My Contests</div>
            </div>
            <div class="panel-body">
                <div class="row categories">
                    @foreach($contests as $contest)
                        @include('profile.partial.thumbnail', compact('contest'))
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        {!! $contests->render(); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection