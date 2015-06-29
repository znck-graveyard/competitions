<div class="row text-center text-white">
    <div class="col-xs-6 col-sm-3">
        <div class="stat-number">{{ $stats->contests }}</div>
        <div class="stat-label text-uppercase">Contests</div>
    </div>

    <div class="hidden-xs col-sm-3">
        <div class="stat-number">{{ $stats->views }}</div>
        <div class="stat-label text-uppercase">Views</div>
    </div>

    <div class="hidden-xs col-sm-3">
        <div class="stat-number">{{ $stats->entries }}</div>
        <div class="stat-label text-uppercase">Entries</div>
    </div>

    <div class="col-xs-6 col-sm-3">
        <div class="stat-number">₹{{ $stats->prize }}</div>
        <div class="stat-label text-uppercase">Prize Money</div>
    </div>
</div>