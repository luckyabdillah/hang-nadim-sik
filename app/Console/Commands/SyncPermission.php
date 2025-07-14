<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class SyncPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permission {--pretend : Simulate the sync process without modifying database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all named admin routes into permissions table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes();
        $count = 0;

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

        $label = $this->option('pretend') ? '[DRY RUN]' : '[LIVE]';
        foreach ($routes as $route) {
            $uri = $route->uri();
            $routeName = $route->getName();

            // Ensure route has dashboard prefix and name
            if (!$routeName || !Str::startsWith($uri, 'dashboard') || Str::contains($uri, 'my')) continue;

            $routeParts = explode('.', $routeName);
            if (count($routeParts) < 2) continue;

            $action = array_pop($routeParts); // Get action
            $base = implode('.', $routeParts); // Merge the rest of route name

            $baseUnderscore = str_replace('.', '_', $base);
            $mappedAction = $actionMap[$action] ?? null;

            if (!$mappedAction) {
                $this->warn("Unknown action '{$action}' for route '{$routeName}', skipped.");
                continue;
            }

            $permissionName = "{$baseUnderscore}_{$mappedAction}";
            $group = Str::headline($routeParts[0]);

            // Get permission record
            $permission = Permission::where('name', $permissionName)->first();
            if (!$permission) {
                // Save the permission if no record and not in pretend mode
                if (!$this->option('pretend')) {
                    $permission = Permission::create([
                        'name' => $permissionName,
                        'group' => $group,
                    ]);
                }

                $this->info("{$label} {$permissionName} ({$group})");
                $count++;
            }
        }

        $this->info("{$label} Total synced permissions: {$count}");

        $superUserRole = Role::where('title', 'Super User')->first();
        if ($superUserRole) {
            $allPermissionIds = Permission::pluck('id');
            $superUserRole->permissions()->syncWithoutDetaching($allPermissionIds);
            $this->info("{$label} All permissions synced to 'Super User' role.");
        } else {
            $this->warn("{$label} Role 'Super User' not found. Skipping role-permission sync.");
        }
    }
}
