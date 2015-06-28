<div class="row text-center text-white">
    <div class="col-xs-6 col-sm-3">
        <div class="stat-number">{{ $contestsCount or '1,20,000' }}</div>
        <div class="stat-label text-uppercase">Contests</div>
    </div>

    <div class="hidden-xs col-sm-3">
        <div class="stat-number">{{ $contestsCount or '1,20,000,000,000' }}</div>
        <div class="stat-label text-uppercase">Views</div>
    </div>

    <div class="hidden-xs col-sm-3">
        <div class="stat-number">{{ $contestsCount or '1,00,20,000' }}</div>
        <div class="stat-label text-uppercase">Entries</div>
    </div>

    <div class="col-xs-6 col-sm-3">
        <div class="stat-number">{{ $contestsCount or '₹54,25,23,451' }}</div>
        <div class="stat-label text-uppercase">Prize Money</div>
    </div>
</div>