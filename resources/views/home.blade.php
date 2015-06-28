@extends('app')

@section('content')
    <div id="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" id="home-banner-container">
                    <div id="home-banner-content">
                        <div>
                            <h1 class="text-white text-center">India's Largest Talent Community</h1>

                            <h4 class="text-white text-center">is an online talent platform where users can showcase heir skills and compete to win fame
                                and fortune </h4>


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
        @include('trending.contests')
    </div>
    <br/>
    <div class="container">
        @include('trending.categories')
    </div>
@endsection
