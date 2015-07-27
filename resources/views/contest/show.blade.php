@extends('app')

@section('title'){{ $contest->name }}@endsection

@section('head.scripts')
    @parent
    <script src="{{ asset('javascript/vue.min.js') }}"></script>
    <script src="{{ asset('javascript/vue-resource.min.js') }}"></script>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection

@section('meta')
    @parent
    <meta name="ws::contest" content="{{ $contest->slug }}"/>
    <meta name="ws::contest.entries" content="{{ route('contest.entry.index', $contest->slug) }}"/>
@endsection

@section('content')
    <br/>
    <div class="container contest-container">
        <div class="row">
            <div class="col-xs-12 col-md-9 col-margin-bottom">
                <div class="cover overlay overlay-gradient"
                    style="background-image: url('{{ route('contest.cover', [$contest->slug,1200,500]) }}')">
                    <h1 class="title">{{ $contest->name }}<br/> <small>{{ ucfirst($contest->contest_type) }}</small></h1>

                    <div class="btn btn-transparent-border deadline text-uppercase">{{ Carbon\Carbon::now()->gt($contest->end_date) ? 'Ended' : 'Ends' }} at <b>{{ $contest->end_date->format('h:iA M d, Y') }}</b></div>
                    @if($editable)
                        <a href="{{ route('contest.edit', $contest->slug) }}" class="btn btn-transparent-border submit text-uppercase">Edit Contest</a>
                    @elseif($publisher)
                        <a href="{{ route('contest.publish', [$contest->slug, $token]) }}" class="btn btn-transparent-border submit text-uppercase">{{ $contest->public ? 'Unpublish Contest' : 'Publish Contest' }}</a>
                    @else
                        <a href="{{ route('contest.entry.create', $contest->slug) }}" class="btn btn-transparent-border submit text-uppercase" @if(\Carbon\Carbon::now()->lt($contest->start_date))data-toggle="tooltip" title="Submission starts at {{ $contest->start_date->format('h:iA M d, Y') }}"@endif>Submit Entry</a>
                    @endif
                </div>
            </div>

            <div class="col-xs-12 col-md-3 col-margin-bottom col-md-no-padding">
                <div class="panel panel-contests">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="text-uppercase">In the front</span> | {{ $contest->entries()->count() }} Entries
                        </h3>
                    </div>
                    <div class="panel-body">
                        @foreach($top as $entry)
                            <div class="entry-card top">
                                <img src="{{ $entry->entryable->image or asset('image/placeholder.jpg') }}"/>
                                <div class="title">{{ ucfirst($entry->title) }}</div>
                                <div class="by">{{ ucfirst($entry->entryable->name) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-eq-height">
            <div class="col-xs-12 col-md-9 col-margin-bottom">
                <div class="panel panel-contests">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nab-tabs-contest" role="tablist">
                            <li role="presentation" class="active"><a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a></li>
                            <li role="presentation"><a href="#rules" aria-controls="rules" role="tab" data-toggle="tab">Rules &amp; Regulations</a></li>
                            @if($contest->manual_review_enabled)
                                <li role="presentation"><a href="#judges" aria-controls="judges" role="tab" data-toggle="tab">Judges</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="description">{!! $contest->description_html !!}</div>
                            <div role="tabpanel" class="tab-pane" id="rules">{!! $contest->rules_html !!}</div>
                            @if($contest->manual_review_enabled)
                                <div role="tabpanel" class="tab-pane" id="judges">-- YET --</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-3 col-margin-bottom col-md-no-padding">
                <div class="panel panel-contests">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Prizes
                        </h3>
                    </div>
                    <div class="panel-body">

                        <div class="prize-card">
                            <img src="{{ asset('image/icons/gold.png') }}"/>
                            <div class="prize">{{ $contest->prize_1 }}</div>
                        </div><div class="prize-card">
                            <img src="{{ asset('image/icons/silver.png') }}"/>
                            <div class="prize">{{ $contest->prize_2 }}</div>
                        </div>

                        <div class="prize-card">
                            <img src="{{ asset('image/icons/bronze.png') }}"/>
                            <div class="prize">{{ $contest->prize_3 }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-margin-bottom">
                <div class="panel panel-contests">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            All Entries
                        </h3>
                    </div>
                    <div class="panel-body" id="contest-entries">
                        <div class="row categories text-center">
                            <div class="col-xs-12 col-sm-6 col-md-3 text-center" v-repeat="entry: entries | paginate">
                                <a href="{{ route('contest.entry.show', [$contest->slug, '']) }}/@{{ entry.uuid }}" v-on="click: openEntry" title="@{{ entry.title }}">
                                    <div class="card entry overlay-caption"
                                         v-style="background-image: 'url(' + entry.image + '), url({{ asset('image/placeholder.jpg') }})'">
                                        <div class="caption text-left">
                                            <div class="profile">
                                                <img v-attr="src: entry.owner.image"/>
                                            </div>
                                            <div class="name" v-text="entry.owner.name"></div>
                                            <div class="stats">
                                                <small v-text="entry.views + (entry.views === 1 ? ' view' : ' views')"></small>
                                                <small v-text="entry.upvotes + (entry.upvotes === 1 ? ' upvote' : ' upvotes')"></small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
                                    <li v-repeat="page: pageList" v-class="active: page == $root.currentPage"><a href="#" v-on="click: goToPage($event, page)" v-text="page"></a></li>
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
    </div>
@endsection