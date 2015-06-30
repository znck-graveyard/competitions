<ul>
    @foreach ($trendingContests as $trendingContest)
        <li>
            <div style='background:url("{{ $trendingContest->image }}");'>
                {{ $trendingContest->type }}
                {{ $trendingContest->name }}

            </div>
        </li>
    @endforeach
</ul>