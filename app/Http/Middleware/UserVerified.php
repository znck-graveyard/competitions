<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserVerified
{
    /**
     * @type \App\User
     */
    private $user;

    /**
     * UserVerified constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
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
        if ($this->user) {
            if (null != $this->user->verification_code) {
                flash()->error('Verify your email address. A mail has been sent to ' . $this->user->email . '.');
            }
        }

        return $next($request);
    }
}
