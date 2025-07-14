<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByUserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return $next($request);
        }

        $isExternal = $user->user_type == 'external';
        $path = $request->path();

        $resources = config('redirects.redirectable_resources', []);
        $redirectRoot = config('redirects.redirect_dashboard_root', true);

        // Root dashboard
        if ($redirectRoot) {
            if ($isExternal && $path === 'dashboard') {
                return redirect('/dashboard/my');
            }

            if (!$isExternal && $path === 'dashboard/my') {
                return redirect('/dashboard');
            }
        }

        // Resource redirect (dengan support sub-path)
        foreach ($resources as $resource) {
            // 1 Pattern: Eksternal akses internal path
            if (
                $isExternal &&
                preg_match("#^dashboard/{$resource}(/.*)?$#", $path, $matches)
            ) {
                $subPath = $matches[1] ?? '';
                return redirect("/dashboard/my/{$resource}{$subPath}");
            }

            // 2 Pattern: Internal akses eksternal path
            if (
                !$isExternal &&
                preg_match("#^dashboard/my/{$resource}(/.*)?$#", $path, $matches)
            ) {
                $subPath = $matches[1] ?? '';
                return redirect("/dashboard/{$resource}{$subPath}");
            }
        }

        return $next($request);
    }
}
