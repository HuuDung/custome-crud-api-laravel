<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    protected function unauthenticated($request, array $guards)
    {
        throw new HttpResponseException(responseMessageSuccess(trans('messages.auth.unauthorized'), Response::HTTP_UNAUTHORIZED));
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) $guards = [null];

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check() && $this->auth->guard($guard)->user()->token()->name == $guard)
                return $this->auth->shouldUse($guard);
        }

        $this->unauthenticated($request, $guards);
    }
}
