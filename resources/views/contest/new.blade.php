@extends('app')

@section('content')
    <div class="banner-slim underlay" style="background-image: url('{{ asset('image/banner-preferences.jpg') }}')">
        <div class="text-white text-center">
            <h1>Create a Contest</h1>

            <h3>Create opportunities, discover amazing talents, stay inspired.</h3>
        </div>
    </div>
    <div class="container">
        <br/>
        @include('profile.create', compact('user'))
    </div>
@endsection