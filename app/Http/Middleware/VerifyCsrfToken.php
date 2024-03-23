<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    // protected $except = [
    //     //
    // ];

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN',
                $request->session()->token(),
                time() + 60 * 120,
                '/',
                null,
                true, // Set this to true for secure.
                true, // Set this to true for httponly.
                false,
                'strict'
            )
        );
        return $response;
    }
}
