<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $routeName = $request->route()->getName();

        if (!$routeName) return redirect('/dashboard')->with('failed', 'No route name detected, please contact Administrator');
        if (!$user->role_id) return redirect('/dashboard')->with('failed', 'No role assigned, please contact Administrator');

        // Pisahkan berdasarkan titik, lalu ambil action dari bagian terakhir
        $routeParts = explode('.', $routeName);
        $action = array_pop($routeParts); // Ambil bagian terakhir sebagai action
        $baseName = str_replace('.', '_', implode('.', $routeParts)); // Gabungkan sisanya sebagai base permission
    
        // Mapping aksi ke permission
        $actionMap = [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'edit',
            'update' => 'edit',
            'destroy' => 'delete',
            'confirm' => 'confirm',
            'import' => 'import',
            'export-excel' => 'export-excel',
            'export-csv' => 'export-csv',
            'export-pdf' => 'export-pdf',
            'completion' => 'completion',
            'trashed' => 'view',
            'recover' => 'delete',
            'recoverAll' => 'delete',
        ];
    
        // Generate required permission
        $requiredPermission = isset($actionMap[$action]) ? "{$baseName}_{$actionMap[$action]}" : null;
    
        if ($requiredPermission && !$user->hasPermission($requiredPermission)) {
            return redirect('/dashboard')->with('failed', 'Unauthorized');
        }
        
        return $next($request);
    }
}
