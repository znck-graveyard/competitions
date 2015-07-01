<div id="pills" class="hidden-xs">
    <div class="container text-center">
        <ul class="nav navbar-nav">
            @foreach($pills as $pill)
                <li><a href="{{ route('contest.category', $pill) }}">{{ ucfirst($pill) }}</a></li>
            @endforeach
        </ul>
    </div>
</div>