@extends('app')
@section('head.scripts')
    @parent
    <script src="{{ asset('javascript/vue.min.js') }}"></script>
    <script src="{{ asset('javascript/vue-resource.min.js') }}"></script>
@endsection
@section('meta')
    @parent

    <!-- TODO give name here and write apt vue.js code for it -->

    <meta name="ws::" content="{{ route('users.entries.userEntries', $user) }}"/>
@endsection
@section('content')
    <img src="{{ $user->attributes()->cover_image }}">
    <img src="{{ $user->attributes()->profile_pic }}" alt="image" class="thumbnail">
    <div>
        <h1>{{ $user->name }}</h1>

        <h3>{{ $user->attributes()->short_bio }}</h3>
        @if(isset( $user->attributes()->facebook_username ))
            <a href="{{ $user->attributes()->facebook_username  }}"><img src="../image/social/facebook.png"></a>
        @endif
        @if(isset( $user->attributes()->instagram_username ))
            <a href="{{ $user->attributes()->instagram_username  }}"><img src="../image/social/instagram.png"></a>
        @endif
        @if(isset( $user->attributes()->twitter_username  ))
            <a href="{{ $user->attributes()->twitter_username  }}"><img src="../image/social/twitter.png"></a>
        @endif
    </div>

    <div class="row">
        <div class="col-xs-12 col-margin-bottom">
            <div class="panel panel-contests">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Entries
                    </h3>
                </div>
                <div class="panel-body" id="">
                    <div class="row text-center">
                        <div class="col-xs-12 col-sm-6 col-md-3 text-center" v-repeat="entry: entries | paginate">



                            <!-- TODO Display all entries of user, Entries from function userEntries in homecontroller-->




                        </div>
                    </div>
                    <div class="row text-center">
                        <nav>
                            <ul class="pagination">
                                <li v-class="disabled: $data.currentPage == 1">
                                    <a href="#" aria-label="Previous" v-on="click: goToPage($event, -1)">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li v-repeat="page: pageList" v-class="active: page == $root.currentPage"><a href="#"
                                                                                                             v-on="click: goToPage($event, page)"
                                                                                                             v-text="page"></a>
                                </li>
                                <li v-class="disabled: $data.currentPage == $data.totalPages">
                                    <a href="#" aria-label="Next" v-on="click: goToPage($event, 0)">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection