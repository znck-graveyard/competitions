@extends('app')

@section('content')
    <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">


        <div class="carousel-inner">
            <div class="item slides active">
                <div class="banner"></div>
                <div class="hero">
                    <hgroup>
                        <h1>India's Largest Talent Community</h1>

                        <h3>is an online talent platform where users can showcase heir skills and compete to win fame
                            and fortune </h3>
                    </hgroup>
                    <a href="" class="btn btn-primary btn-lg" role="button"
                       style="background: #ec6814;border-color: #ec6814">Learn More</a>
                    <a href="" class="btn btn-primary btn-lg" role="button"
                       style="background: #ffffff;border-color: #ffffff;color: #000000 ">Explore</a>
                </div>
            </div>

        </div>

        @include('trending.contests')

    </div>
    </div>

@endsection
