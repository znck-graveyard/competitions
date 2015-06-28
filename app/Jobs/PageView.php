<?php namespace App\Jobs;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
use Illuminate\Database\Eloquent\Model;

/**
 * Class PageView
 *
 * @package App\Jobs
 */
abstract class PageView extends Job
{
    /**
     * @type \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->model->increment('page_view');
        $this->model->save();
    }
}