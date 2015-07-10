@extends('app')
@section('title'){{ $user->name . '  - WhizzSpace' }}@endsection

@section('head.scripts')
    @parent
    <script src="{{ asset('javascript/vue.min.js') }}"></script>
    <script src="{{ asset('javascript/vue-resource.min.js') }}"></script>
@endsection

@section('meta')
    @parent
    <meta name="ws::contest.entries" content="{{ route('user.entries', $user->id) }}"/>
@endsection

@section('content')
    <div class="profile">
        <div class="cover" style="background-image: url('{{ route('user.cover', [$user->username]) }}')">

        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="photo-wrapper">
                        <div class="thumbnail photo">
                            <img src="{{ route('user.photo', $user->username) }}"/>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="name text-uppercase">{{ $user->name }}</div>
                                <div class="bio">{{ $user->bio }}</div>
                                <div class="meta">
                                    <div class="social">
                                        @if($user->connection_twitter)
                                            <a class="btn btn-icon btn-gray" href="{{ $user->connection_twitter }}">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if($user->connection_facebook)
                                            <a class="btn btn-icon btn-gray" href="{{ $user->connection_facebook }}">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if($user->connection_instagram)
                                            <a class="btn btn-icon btn-gray" href="{{ $user->connection_instagram }}">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="stats">
                                        {{ $user->stat_submissions }} {{ str_plural('submission', $user->stat_submissions) }} |
                                        {{ $user->stat_views }} {{ str_plural('view', $user->stat_views) }} |
                                        {{ $user->stat_upvotes }} {{ str_plural('upvote', $user->stat_upvotes) }} |
                                        {{ $user->stat_wins }} {{ str_plural('time', $user->stat_wins) }} winner |
                                        {{ $user->stat_creations }} {{ str_plural('contest', $user->stat_creations) }} creator
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container">
        <div id="contest-entries">
            <div class="row text-center">
                <div class="col-xs-12 col-sm-6 col-md-3 text-center" v-repeat="entry: entries | paginate">
                    <a href="@{{ entry.link }}" title="@{{ entry.title }}">
                        <div class="card entry overlay-caption"
                             v-style="background-image: 'url(' + entry.image + '), url({{ asset('image/placeholder.jpg') }})'">
                            <div class="caption text-left">
                                <div class="profile">
                                    <img v-attr="src: entry.contest.image"/>
                                </div>
                                <div class="name" v-text="entry.contest.type"></div>
                                <div class="stats">
                                    <small v-text="entry.views + (entry.views === 1 ? ' view' : ' views')"></small>
                                    <small v-text="entry.upvotes + (entry.upvotes === 1 ? ' upvote' : ' upvotes')"></small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row text-center" v-if="$data.totalPages > 0">
                <nav>
                    <ul class="pagination">
                        <li v-class="disabled: $data.currentPage == 1">
                            <a href="#" aria-label="Previous" v-on="click: goToPage($event, -1)">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li v-repeat="page: pageList" v-class="active: page == $root.currentPage"><a href="#" v-on="click: goToPage($event, page)" v-text="page"></a></li>
                        <li v-class="disabled: $data.currentPage == $data.totalPages">
                            <a href="#" aria-label="Next" v-on="click: goToPage($event, 0)">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="row text-center" v-if="$data.totalPages == 0">
                <div class="col-xs-12 empty-state">
                    <img src="{{ asset('image/placeholder-slim.jpg') }}"/>
                    <h4>
                        No submissions.
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection