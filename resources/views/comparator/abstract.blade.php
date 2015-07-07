@extends('app')

@section('content')
    <div class="comparator comparator-default underlay">
        <div class="container">
            <div class="arena left">
                <div class="entries">
                    <div class="entry left text-center">
                        <div class="wrapper">
                            <div class="content" style="background-image: url('{{ $one->image or 'https://unsplash.it/1600/900/?random&mVrJ' }}')">
                                <img src="{{ $one->image or 'https://unsplash.it/1600/900/?random&mVrJ' }}" alt="{{ $one->title }}"/>
                            </div>
                            <div class="caption">
                                <div class="profile">
                                    <img src="{{ $one->entryable->image or asset('image/placeholder.jpg') }}"/>
                                </div>
                                <div class="info row text-left">
                                    <div class="col-xs-12">
                                        <div class="pull-right">
                                            <a class="visible-xs-block an" href="#" data-show="both">
                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                            </a>
                                            <a class="btn btn-white btn-huge text-uppercase an hidden-xs" href="#" data-show="both">How to vote?</a>
                                            <a class="btn btn-primary btn-huge text-uppercase an hidden-xs" href="#" data-show="right">Opponent's entry</a>
                                        </div>
                                        <div class="title text-uppercase">
                                            {{ $one->title }}
                                        </div>
                                        <div class="name">
                                            by {{ $one->entryable->name }}
                                        </div>
                                        <div class="stats">
                                            {{ $one->views }} {{ str_plural('view', $one->views) }} | {{ $one->upvotes }} {{ str_plural('upvote', $one->upvotes) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="anchor an" href="#" role="button" data-show="left">
                                <span class="glyphicon glyphicon-arrow-left"></span>
                            </a>
                        </div>
                    </div>
                    <div class="entry right text-center">
                        <div class="wrapper">
                            <div class="content" style="background-image: url('{{ $other->image or 'https://unsplash.it/1600/900/?random&mVrK' }}')">
                                <img src="{{ $other->image or 'https://unsplash.it/1600/900/?random&mVrK' }}" alt="{{ $other->title }}"/>
                            </div>
                            <div class="caption">
                                <div class="profile">
                                    <img src="{{ $other->entryable->image or asset('image/placeholder.jpg') }}"/>
                                </div>
                                <div class="info row text-left">
                                    <div class="col-xs-12">
                                        <div class="pull-right">
                                            <a class="btn btn-white btn-huge text-uppercase an" href="#" data-show="both">Vote Now?</a>
                                            <a class="btn btn-primary btn-huge text-uppercase an" href="#" data-show="left">Contestant's entry</a>
                                        </div>
                                        <div class="title text-uppercase">
                                            {{ $other->title }}
                                        </div>
                                        <div class="name">
                                            by {{ $other->entryable->name }}
                                        </div>
                                        <div class="stats">
                                            {{ $other->views }} {{ str_plural('view', $other->views) }} | {{ $other->upvotes }} {{ str_plural('upvote', $other->upvotes) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="anchor an" href="#" role="button" data-show="right">
                                <span class="glyphicon glyphicon-arrow-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dashboard">
                    <div class="caption">
                        <div class="profile">
                            <img src="{{ $one->entryable->image or asset('image/placeholder.jpg') }}"/>
                        </div>
                        <div class="info row text-left">
                            <div class="col-xs-4">
                                <div class="title text-uppercase">
                                    {{ $one->entryable->name }}
                                </div>
                            </div>
                            <div class="col-xs-4"></div>
                            <div class="col-xs-4">
                                <div class="title text-right text-uppercase">
                                    {{ $other->entryable->name }}
                                </div>
                            </div>
                        </div>
                        <div class="profile">
                            <img src="{{ $other->entryable->image or asset('image/placeholder.jpg') }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var $comparator = $('.comparator');
        var w = 48;
        var width;
        var adjustDimensions = function () {
            width = $comparator.find('.arena').width();
            width -= w;
            var height = window.innerHeight - 2 * w;
            $comparator.find('.arena').height(height);
            $comparator.find('.entries').width(width * 2 + w);
            $comparator.find('.wrapper').width(width).height(height);
        };
        $(window).on('resize', adjustDimensions);
        adjustDimensions();
        $comparator.on('click', '.an', function(event){
            event.preventDefault();
            var which = $(this).attr('data-show');
            if (which == 'left') {
                $comparator.find('.entries').animate({left: 0}, 500, function() {
                    $comparator.find('.arena').removeClass('left right both').addClass(which, 'slow');
                });
            } else if (which == 'right') {
                $comparator.find('.entries').animate({left: (w - width) + 'px'}, 500, function() {
                    $comparator.find('.arena').removeClass('left right both').addClass(which, 'slow');
                });
            } else {
                $comparator.find('.arena').removeClass('left right both').addClass(which, 'slow');
            }
        });
    </script>
@endsection