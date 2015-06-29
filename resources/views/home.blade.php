@extends('app')

@section('content')
    <div id="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" id="home-banner-container">
                    <div id="home-banner-content">
                        <div>
                            <h1 class="text-white text-center">India's Largest Talent Community</h1>

<<<<<<< HEAD

        <div class="carousel-inner">
            <div class="item slides active">
                <div class="banner"></div>
                <div class="hero">
                    <hgroup>
                        <h1>India's Largest Talent Community</h1>
=======
                            <h4 class="text-white text-center">is an online talent platform where users can showcase heir skills and compete to win fame
                                and fortune </h4>
>>>>>>> 6f62b361f1f693a4e496e2013e66ceb07a59dc94


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

        @include('trending.contests')

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
