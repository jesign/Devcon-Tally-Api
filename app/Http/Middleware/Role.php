<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $args = func_get_args ();
        $roles = array_splice($args, 2);

        if (!$request->user()->hasRole($roles)) {
            return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
