<div id="pills" class="hidden-xs">
    <div class="container text-center">
        <ul class="nav navbar-nav">
            @foreach($pills as $pill => $name)
                <li><a href="{{ route('contest.category', str_slug($pill)) }}">{{ $name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>