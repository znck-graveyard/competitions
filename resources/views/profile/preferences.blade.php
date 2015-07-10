@extends('app')
@section('title'){{ $user->name . '  - Preferences' }}@endsection

@section('content')
    <div class="banner-slim underlay" style="background-image: url('{{ asset('image/banner-preferences.jpg') }}')">
        <div class="text-white text-center">
            <h1>Update your profile</h1>

            <h3></h3>
        </div>
    </div>
    <div class="container">
        <br/>
        @include('profile.create')
    </div>
@endsection