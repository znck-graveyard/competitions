@extends('app')
@section('content')
    <img src="{{ $user->attributes()->cover_image }}">
    <img src="{{ $user->attributes()->profile_pic }}" alt="image" class="thumbnail">
    <div>
        <h1>{{ $user->name }}</h1>

        <h3>{{ $user->attributes()->short_bio }}</h3>
        @if(isset( $user->attributes()->facebook_username ))
            <a href="{{ $user->attributes()->facebook_username  }}"><img src="../image/social/facebook.png"></a>
        @endif
        @if(isset( $user->attributes()->instagram_username ))
            <a href="{{ $user->attributes()->instagram_username  }}"><img src="../image/social/instagram.png"></a>
        @endif
        @if(isset( $user->attributes()->twitter_username  ))
            <a href="{{ $user->attributes()->twitter_username  }}"><img src="../image/social/twitter.png"></a>
        @endif
    </div>
    <div class="container">
        <ul>
            @foreach ($entries as $entry)


            @endforeach
        </ul>

    </div>

@endsection