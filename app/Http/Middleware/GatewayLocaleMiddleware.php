<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

/**
 * Custom middleware responsible for capturing the selected language from the APP and replacing the language for the API.
 * TODO
 */
class GatewayLocaleMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request['locale'] != null) {
            app()->setLocale($request['locale']);
        }

        return $next($request);
    }
}
