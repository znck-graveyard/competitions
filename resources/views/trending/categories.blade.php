@foreach($categories as $type => $contests)
    <div class="panel panel-contests">
        <div class="panel-heading" style="background-color: {{ config('colors.'.$type, '#000') }}">
            <h3 class="panel-title text-uppercase">{{ $type }}</h3>
        </div>
        <div class="panel-body">
            <div class="row categories">
                @foreach($contests as $index => $contest)
                    <div class="col-xs-6 col-sm-4 col-md-3 text-center">
                        <a href="{{ route('contest.show', $contest->slug) }}">
                            <div class="card overlay-caption"
                                 style="background-image: url({{ $contest->image or 'https://unsplash.it/248/?random&' . str_random(4) }})">
                                <div class="caption text-left">
                                    <div>{{ $contest->name }}</div>
                                    <div>
                                        <small><?php $c = $contest->entries()->count(); echo $c . ($c == 1 ? ' entry' : ' entries') ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach