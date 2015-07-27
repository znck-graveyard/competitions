<?php

namespace App\Http\Middleware;

use Closure;

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
        /** @type \App\Contest|null $contest */
        $contest = $request->route('contest');

        if ($contest && $contest->public) {
            $contest->increment('page_view');
        }

        /** @type \App\Entry|null $entry */
        $entry = $request->route('entry');

        if ($entry) {
            $entry->increment('views');
        }

        return $next($request);

    }
}
