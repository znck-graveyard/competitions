@extends('app')

@section('content')
    <div id="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" id="home-banner-container">
                    <div id="home-banner-content">
                        <div>
                            <h1 class="text-white text-center">India's Largest Talent Community</h1>


                            <div class="text-center">
                                <a href="" class="btn btn-primary" role="button">Learn More</a>
                                <a href="" class="btn btn-white" role="button">Explore</a>
                            </div>
                        </div>
                    </div>
                    <div id="stats-container">
                        @include('stats.counter')
                    </div>
                </div>
            </div>
        </div>



    </div>
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-orange text-uppercase text-center">Trending</h2>
            </div>
        </div>
        @include('trending.contests')
    </div>
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-orange text-uppercase text-center">Explore Contests</h2>
            </div>
        </div>
        @include('trending.categories')
    </div>
@endsection
