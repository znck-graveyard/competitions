@extends('app')
@section('content')
<img src="{{ $user->attributes()->cover_image }}">
    <img src="{{ $user->attributes()->profile_pic }}" alt="image" class="thumbnail">
    <div>
        <h1>{{ $user->name }}</h1>
        <h3>{{ $user->attributes()->short_bio }}</h3>


    </div>
    <div>

    </div>

@endsection