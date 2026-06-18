<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    /**
     * Apply the visitor's chosen locale (stored in the `locale` cookie) for the
     * request, falling back to the app default when it's missing or unsupported.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie('locale');
        $available = config('app.available_locales');

        // Only override the app default (en) when the cookie holds a supported locale.
        if (is_string($locale) && is_array($available) && array_key_exists($locale, $available)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
