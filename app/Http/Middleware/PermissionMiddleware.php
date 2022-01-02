<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Route;
class PermissionMiddleware {
    public function handle($request, Closure $next) {
        $array = explode('\\', Route::getCurrentRoute()->getActionName());
        $permission = end($array);
        if (!$request->user()->can($permission)) {
            abort(403, 'This action is unauthorized.');
        }
        return $next($request);
    }
}