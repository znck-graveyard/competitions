<?php namespace App\View\Composer;

use App\Contest;
use App\Entry;
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
     * @type \App\Entry
     */
    protected $entries;

    /**
     * @param \App\Contest $contests
     * @param \App\Entry   $entries
     *
     * @internal param \App\Entry $entries
     */
    public function __construct(Contest $contests, Entry $entries)
    {
        $this->contests = $contests;
        $this->entries = $entries;
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
                'contests' => number_format($self->contests->wherePublic(true)->count()),
                'views'    => number_format($self->contests->wherePublic(true)->sum('page_view')),
                'entries'  => number_format($self->entries->count()),
                'prize'    => number_format($self->contests->wherePublic(true)->sum('prize')),
            ];
        });
    }
}