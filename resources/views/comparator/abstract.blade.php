
<div class="comparator comparator-default underlay">
    <a href="#" class="close btn btn-white" role="button" id="close-comparator">&times;</a>
    <div class="container">
        <div class="arena left">
            <div class="entries" style="padding-bottom: 76px">
                <div class="entry left text-center">
                    <div class="wrapper">
                        @yield('one.content', compact('one'))
                        {!! Form::open(['url' => route('contest.entry.vote',[$contest->slug, $one->uuid])]) !!}
                        <input type="hidden" name="hash" value="{{ Hash::make($one->uuid . $other->uuid) }}">
                        <input type="hidden" name="up" value="{{ $one->uuid }}">
                        <input type="hidden" name="down" value="{{ $other->uuid }}">
                        <div class="vote">
                            <input type="submit" class="btn btn-white btn-huge" value="vote" />
                        </div>
                        {!! Form::close() !!}
                        <div class="caption">
                            <div class="profile">
                                <img src="{{ $one->entryable->imageUrl() }}"/>
                            </div>
                            <div class="info row text-left">
                                <div class="col-xs-12">
                                    <div class="pull-right">
                                        <a class="visible-xs-block btn btn-white btn-huge an" href="#" data-show="both">
                                            <span class="glyphicon glyphicon-thumbs-up"></span>
                                        </a>
                                        <a class="btn btn-white btn-huge text-uppercase an hidden-xs" href="#" data-show="both">Vote Now</a>
                                        <a class="btn btn-primary btn-huge text-uppercase an hidden-xs" href="#" data-show="right">Opponent's entry</a>
                                    </div>
                                    <div class="title text-uppercase">
                                        {{ $one->title }}
                                    </div>
                                    <div class="name">
                                        by <a href="{{ route('user.profile', $one->entryable->username ?: $one->entryable->id) }}">{{ $one->entryable->name }}</a>
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
                        @yield('other.content', compact('other'))
                        {!! Form::open(['url' => route('contest.entry.vote',[$contest->slug, $other->uuid])]) !!}
                        <input type="hidden" name="hash" value="{{ Hash::make($other->uuid . $one->uuid) }}">
                        <input type="hidden" name="up" value="{{ $other->uuid }}">
                        <input type="hidden" name="down" value="{{ $one->uuid }}">
                        <div class="vote">
                            <input type="submit" class="btn btn-white btn-huge" value="vote"/>
                        </div>
                        <div class="caption">
                            <div class="profile">
                                <img src="{{ $other->entryable->imageUrl() }}"/>
                            </div>
                            <div class="info row text-left">
                                <div class="col-xs-12">
                                    <div class="pull-right">
                                        <a class="visible-xs-block btn btn-white btn-huge an" href="#" data-show="both">
                                            <span class="glyphicon glyphicon-thumbs-up"></span>
                                        </a>
                                        <a class="btn btn-white btn-huge text-uppercase an hidden-xs" href="#" data-show="both">Vote Now</a>
                                        <a class="btn btn-primary btn-huge text-uppercase an hidden-xs" href="#" data-show="left">Contestant's entry</a>
                                    </div>
                                    <div class="title text-uppercase">
                                        {{ $other->title }}
                                    </div>
                                    <div class="name">
                                        by <a href="{{ route('user.profile', $other->entryable->username ?: $other->entryable->id) }}">{{ $other->entryable->name }}</a>
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
                        <img src="{{ $one->entryable->imageUrl() }}"/>
                    </div>
                    <div class="info row text-left">
                        <div class="col-xs-6 col-sm-4">
                            <div class="title text-uppercase">
                                <br>
                                <a href="{{ route('user.profile', $one->entryable->username ?: $one->entryable->id) }}">{{ $one->entryable->name }}</a>
                            </div>
                        </div>
                        <div class="col-xs-0 col-sm-4 text-center">
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="title text-right text-uppercase">
                                <br>
                                <a href="{{ route('user.profile', $other->entryable->username ?: $other->entryable->id) }}">{{ $other->entryable->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile">
                        <img src="{{ $other->entryable->imageUrl() }}"/>
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
            $comparator.find('.entries').animate({left: 0}, 0);
            $comparator.find('.arena').removeClass('left right both').addClass(which, 'slow');
        }
    });
</script>