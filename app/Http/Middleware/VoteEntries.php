<?php

namespace App\Http\Middleware;

use App\Entry;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Throttle;

class VoteEntries
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     *
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $throttler = Throttle::get($request, 1, 1440);

        if ($throttler->check()) {
            $throttler->hit();

            return $next($request);
        }

        flash()->error('You have already voted for this entry.');

        return redirect()->back();
    }
}
