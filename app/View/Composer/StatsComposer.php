<?php namespace App\View\Composer;

use App\Contest;
use Illuminate\Contracts\View\View;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class StatsComposer
{
    /**
     * @type \App\Contest
     */
    protected $contests;

    /**
     * @param \App\Contest $contests
     *
     * @internal param \App\Entry $entries
     */
    public function __construct(Contest $contests)
    {
        $this->contests = $contests;
    }

    /**
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $stats = $this->getStats();

        $view->with(['stats' => $stats]);
    }

    /**
     * @return array
     */
    protected function getStats()
    {
        $self = $this;

        return \Cache::remember('stats.basic', 5, function () use ($self) {
            return (object)[
                'contests' => number_format($self->contests->count()),
                'views'    => number_format($self->contests->sum('page_view')),
                'entries'  => number_format($self->contests->entries()->count()),
                'prize'    => number_format($self->contests->sum('prize')),
            ];
        });
    }
}