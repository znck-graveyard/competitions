@extends('app')
@section('head.scripts')
    @parent
    <script src="{{ asset('javascript/vue.min.js') }}"></script>
    <script src="{{ asset('javascript/vue-resource.min.js') }}"></script>
@endsection

@section('meta')
    @parent
    <meta name="ws::contest" content="{{ $contest->slug }}"/>
    <meta name="ws::contest.entries" content="{{ route('contest.entry.index', $contest->slug) }}"/>
@endsection
@section('content')

    <a href="" class="btn btn-white text-uppercase" >How to vote?</a>
    <a href="" class="btn btn-primary text-uppercase">Opponents Entry</a>


@endsection