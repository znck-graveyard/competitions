@extends('app')
@section('content')
    <div class="banner banner-category overlay" class="{{ str_slug($type) }}"
            style="background-image: url({{ config('banners.' . str_slug($type), 'https://unsplash.it/1200/900/?random&' . str_random(4)) }})">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 banner-container">
                    <div class="banner-content">
                        <div>
                            <h1 class="text-white text-center text-uppercase">{{ config('contest.types.' .$type, ucfirst($type)) }}</h1>

                            <h3 class="text-white text-center"
                                style="font-weight: normal">Showcase your Work and stay inspired.</h3>

                            <div class="text-center">
                                <a href="#contests" class="btn btn-primary" role="button">Participate</a>
                                <a href="{{ route('contest.create') }}" class="btn btn-white" role="button">Create Contest</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container" id="contests">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-orange text-uppercase text-center">Explore Contests</h2>
            </div>
        </div>

        <div class="row categories">
            @forelse($contests as $contest)
                @include('contest.partial.thumbnail', compact('contest'))
            @empty
                <div class="col-xs-12 empty-state">
                    <img src="{{ asset('image/placeholder-slim.jpg') }}"/>
                    <h4>
                        There are no contests as of now!<br/>Keep looking this space for more updates.
                    </h4>
                </div>
            @endforelse
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                {!! $contests->render(); !!}
            </div>
        </div>
    </div>

    <br/>

@endsection