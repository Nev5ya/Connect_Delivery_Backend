<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @param $request
     * @param Closure $next
     * @param ...$guards
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        if ($jwt = $request->only('auth-token')) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt['auth-token']);

            $request->request->replace((array)$request->request->get('data'));
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
