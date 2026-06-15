<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceLowercaseUrl
{
    /**
     * Path prefixes that must keep their original casing (admin, auth, API).
     *
     * @var list<string>
     */
    private const EXCLUDED_PREFIXES = [
        'argon',
        'api',
        'login',
        'register',
        'password',
        'logout',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $path = $request->getPathInfo();
        $lowercasePath = mb_strtolower($path, 'UTF-8');

        if ($path === $lowercasePath) {
            return $next($request);
        }

        $url = $request->getSchemeAndHttpHost() . $lowercasePath;

        if ($request->getQueryString()) {
            $url .= '?' . $request->getQueryString();
        }

        return redirect()->to($url, 301);
    }

    private function shouldSkip(Request $request): bool
    {
        $firstSegment = strtolower($request->segment(1) ?? '');

        return in_array($firstSegment, self::EXCLUDED_PREFIXES, true);
    }
}
