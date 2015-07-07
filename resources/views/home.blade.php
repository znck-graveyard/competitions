@extends('app')

@section('content')
    <div id="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" id="home-banner-container">
                    <div id="home-banner-content">
                        <div>
                            <h1 class="text-white text-center">India's Largest Talent Community</h1>

                            <h3 class="text-white text-center"
                                style="font-weight: normal">Whizzspace is an online talent platform where people can showcase <br/> their skills and compete to win fame and fortune.</h3>

                            <div class="text-center">
                                <a href="" class="btn btn-primary" role="button">Learn More</a>
                                <a href="#contests" class="btn btn-white" role="button">Explore</a>
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
        @include('trending.contests')
    <br/>
    <div class="container" id="contests">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-orange text-uppercase text-center">Explore Contests</h2>
            </div>
        </div>
        @include('trending.categories')
    </div>
@endsection
