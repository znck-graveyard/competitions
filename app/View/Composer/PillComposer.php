<?php namespace App\View\Composer;

use App\Contest;
use Illuminate\Contracts\View\View;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class PillComposer
{
    protected $contest;

    function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function compose(View $view)
    {
        $view->with('pills', $this->getCachedPills());
    }

    private function getCachedPills()
    {
        return array_except(config('contest.types'), '');
    }
}