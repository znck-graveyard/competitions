@if(count($trendingContests))
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-orange text-uppercase text-center">Trending</h2>
            </div>
        </div>
        <div class="slider-wrapper">
            <div id="trending-contest" class="slider">
                <!-- Wrapper for slides -->
                <ul class="items" role="listbox">
                    @foreach($trendingContests as $contest)
                        <li class="item">
                            <a href="{{ route('contest.show', $contest->slug) }}">
                                <div class="card overlay-caption trending"
                                     style="background-image: url('{{ $contest->image or asset('image/placeholder.jpg') }}')">
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
    </div>

    <script>
        //<![CDATA[
        $(document).ready(function () {
            var $trending = $('#trending-contest');
            var $items = $trending.find(' > .items');
            $trending.jcarousel();

            $items.height($trending.find('.item').height());
            $trending.height($items.height());

            $(window).resize(function () {
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
@endif