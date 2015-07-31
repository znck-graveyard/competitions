<?php namespace App\View\Composer;

use App\Contest;
use Illuminate\Contracts\View\View;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class ContestInCategory
{
    protected $contests;

    public function __construct(Contest $contests)
    {
        $this->contests = $contests;
    }

    public function compose(View $view)
    {
        $categories = $this->getContestsInCategory();

        $view->with(compact('categories'));
    }

    protected function getContestsInCategory()
    {
        $self = $this;

        return \Cache::remember('home.contests', 0, function () use ($self) {
            return $self->collectContestsInCategories();
        });
    }

    protected function collectContestsInCategories()
    {
        $nestedQuery = $this->contests->getQuery();
        $nestedQuery->from('contests as a')->select([
            'a.*',
            \DB::raw('ROW_NUMBER() OVER (PARTITION BY a.contest_type ORDER BY a.created_at DESC) as rn')
        ])->where('public', '=', true);

        $rows = $this->contests
            ->from(\DB::raw("({$nestedQuery->toSql()}) as contests"))
            ->select(['contests.*', 'rn'])
            ->whereRaw("rn <= 4")->orderBy('contests.contest_type')
            ->mergeBindings($nestedQuery)->get();
        $contests = [];
        foreach ($rows as $row) {
            if (!array_key_exists($row->contest_type, $contests)) {
                $contests[$row->contest_type] = [];
            }
            $contests[$row->contest_type][] = $row;
        }

        return $contests;
    }
}