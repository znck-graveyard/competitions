<div class="slider-wrapper">
    <div id="trending-contest" class="slider">
        <!-- Wrapper for slides -->
        <ul class="items" role="listbox">
            @foreach ($trendingContests as $contest)
                <li class="item">
                    <a href="{{ route('contest.show', $contest->slug) }}">
                        <div class="card overlay-caption trending"
                             style="background-image: url('{{ $contest->image or 'https://unsplash.it/248/?random&' . str_random(4) }}')">
                            <div class="caption text-left">
                                <div>{{ $contest->name }}</div>
                            </div>
                            <div class="tag tag-left">{{ ucfirst($contest->contest_type) }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Controls -->
    <a class="left slider-control">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right slider-control">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<script>
    //<![CDATA[
    $(document).ready(function () {
        var $trending = $('#trending-contest');
        var $items = $trending.find(' > .items');
        $trending.jcarousel();

        $items.height($trending.find('.item').height());
        $trending.height($items.height());

        $(window).resize(function(){
            $items.height($trending.find('.item').height());
            $trending.height($items.height());
        });
        $('.slider-wrapper .left').jcarouselControl({
            // Options go here
            target: '-=2'
        });
        $('.slider-wrapper .right').jcarouselControl({
            // Options go here
            target: '+=2'
        });
    });
    //]]>
</script>