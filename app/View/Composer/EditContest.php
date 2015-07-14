<?php namespace App\View\Composer;

use Illuminate\Contracts\View\View;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class EditContest
{
    public function compose(View $view)
    {
        $contestTypes = config('contest.types');
        $submissionTypes = config('contest.submission_types');

        $view->with(compact('contestTypes', 'submissionTypes'));
    }
}