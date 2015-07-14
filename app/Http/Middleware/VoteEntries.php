<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use App\Entry;
use Closure;
use Log;
use App\Contest;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Request;

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
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $time=120;
        $client_ip=$request->getClientIp();
        $url='/'.$request->path();
        $throttler1=Throttle::get(Request::instance(), 1, $time);
        $throttler2 = Throttle::get(['ip'=>$client_ip,'route'=>$url], 1, $time);
        if (!($this->auth->guest())) {

            if($throttler1->check()){

                $throttler1->hit();
                return $next($request);
            }
            else
                flash('You have Already voted for this Entry. Try again after some time');


        }
        else{
            if($throttler2->check()){

                $throttler2->hit();
                return $next($request);
            }
            else {
                flash('You have Already voted for this Entry. Try again after some time');
            }

        }

        return redirect($url);

    }
}
