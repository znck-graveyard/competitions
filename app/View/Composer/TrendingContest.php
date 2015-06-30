<?php namespace App\View\Composer;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
use App\Contest;
use Cache;
use Illuminate\Contracts\View\View;

/**
 * Class TrendingContest
 *
 * @package View\Composer
 */
class TrendingContest
{
    /**
     * Eloquent for contests.
     *
     * @type \App\Contest
     */
    protected $contests;

    /**
     * @param \App\Contest $contests
     */
    public function __construct(Contest $contests)
    {
        $this->contests = $contests;
    }

    /**
     * Compose the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $trendingContests = $this->getTrendingContests();
        $view->with(compact('trendingContests'));
    }

    /**
     * Get trending contests from cache or database.
     *
     * @return array
     */
    protected function getTrendingContests()
    {
        $self = $this;

        return Cache::remember('trending.events', 60, function () use ($self) {
            return $self->calculatedTrendingContests();
        });
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function calculatedTrendingContests()
    {
        return $this->contests->leftJoin('contestants', 'contestants.contest_id', '=', 'contests.id')
            ->select('contests.*', \DB::raw('count(contestants.*) as aggregate'))
            ->groupBy('contests.id')
            ->orderBy('aggregate', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
    }
}