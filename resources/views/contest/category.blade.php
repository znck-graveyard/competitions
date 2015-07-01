@extends('app')
@section('content')
    <div class="banner banner-category" class="{{ str_slug($type) }}"
            style="background-image: {{ config('banners.' . str_slug($type)) }}">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 banner-container">
                    <div class="banner-content">
                        <div>
                            <h1 class="text-white text-center text-uppercase">{{ ucfirst($type) }}</h1>

                            <h3 class="text-white text-center"
                                style="font-weight: normal">Showcase your Work and stay inspired.</h3>

                            <div class="text-center">
                                <a href="#contests" class="btn btn-primary" role="button">Participate</a>
                                <a href="" class="btn btn-white" role="button">Create Contest</a>
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
            @foreach($contests as $contest)
                @include('contest.partial.thumbnail', compact('contest'))
            @endforeach
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                {!! $contests->render(); !!}
            </div>
        </div>
    </div>

    <br/>

@endsection