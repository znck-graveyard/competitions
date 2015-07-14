@forelse($categories as $type => $contests)
    <div class="panel panel-contests">
        <div class="panel-heading" style="background-color: {{ config('colors.'.str_slug($type), '#000') }}">
            <h3 class="panel-title text-uppercase">
                {{ $type }}

                <a class="pull-right text-capitalize"
                   style="font-weight: normal; font-size: 14px"
                   href="{{ route('contest.category', str_slug($type)) }}">
                    See All &gt;</i>
                </a>
            </h3>
        </div>
        <div class="panel-body">
            <div class="row categories">
                @foreach($contests as $index => $contest)
                    @include('contest.partial.thumbnail', compact('contest'))
                @endforeach
            </div>
        </div>
    </div>
@empty
    <div class="container text-center" style="margin-bottom: 15px">
        <div class="row">
            <div class="col-xs-12 empty-state">
                <img src="{{ asset('image/placeholder-slim.jpg') }}"/>
                <h4>
                    There are no contests as of now!<br/>Keep looking this space for more updates.
                </h4>
            </div>
        </div>
    </div>
@endforelse