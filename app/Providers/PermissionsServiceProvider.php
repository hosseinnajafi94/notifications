<?php
namespace App\Providers;
use App\Models\Permissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
class PermissionsServiceProvider extends ServiceProvider {
    public function register() {
        
    }
    public function boot() {
        try {
            Permissions::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            });
        }
        catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}