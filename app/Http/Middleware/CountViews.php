<?php

namespace App\Http\Middleware;

use App\Entry;
use Closure;
use Log;
use App\Contest;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Request;

class CountViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $throttler = Throttle::get(Request::instance(), 1, 60);
        $uri = explode('/', $request->path());
        $slug = $uri[1];
        $contest = Contest::whereSlug($slug)->first();

        if ($throttler->check()) {
            if ($request->is('contest/'.$slug.'/entry/*')) {
                $uuid = $uri[3];
                $entry = Entry::whereUuid($uuid)->first();
                Log::info($entry->name);
                $entry->views += 1;
                $entry->save();

                $contest->page_view += 1;
                $contest->save();

                $throttler->hit();

                return $next($request);
            }

            if ($request->is('contest/*')) {

                $contest->page_view += 1;
                $contest->save();

                $throttler->hit();

                return $next($request);
            }
        }
        return $next($request);

    }
}
