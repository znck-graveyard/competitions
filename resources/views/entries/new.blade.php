@extends('app')

@section('head')


@endsection
@section('content')

    <div class="jumbotron picCheer darken">
        <hgroup style="text-align: center">
            <h1>Participate in the Contest</h1>

            <h3>Create opportunities, discover amazing talents, stay inspired. </h3>
        </hgroup>
    </div>
    <div class="container">
        <p><b>Before Submitting please enter some information below.</b></p>

        @include('profile.create')
    </div>
@endsection