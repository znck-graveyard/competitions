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
                    @forelse($contests as $contest)
                        @include('profile.partial.thumbnail', compact('contest'))
                    @empty
                        <div class="col-xs-12 empty-state text-center">
                            <img src="{{ asset('image/placeholder-slim.jpg') }}"/>
                            <h4>
                                There are no contests as of now!<br/>Keep looking this space for more updates.
                            </h4>
                        </div>
                        <br>
                    @endforelse
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