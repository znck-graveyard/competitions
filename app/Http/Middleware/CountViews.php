<?php

namespace App\Http\Middleware;

use Closure;
use Throttle;

class CountViews
{
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

        $throttler = Throttle::get($request, 1, 10);

        /** @type \App\Contest|null $contest */
        $contest = $request->route('contest');

        if ($contest && $contest->public) {
            $contest->increment('page_view');
            $throttler->hit();
        }

        /** @type \App\Entry|null $entry */
        $entry = $request->route('uuid');

        if ($entry) {
            $entry->increment('views');
            $throttler->hit();
        }

        return $next($request);

    }
}
