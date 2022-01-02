<?php
use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
//
//Route::get('redraw', [App\Http\SystemController::class, 'redraw']);
//Route::get('clear-cache', [App\Http\SystemController::class, 'clearcache']);
Route::post('login', [Controllers\AuthController::class, 'login']);
//
Route::group(['middleware' => ['auth:api']], function () {
    //
    Route::post('logout', [Controllers\AuthController::class, 'logout']);
    //
    Route::group(['middleware' => ['role']], function () {
        //
        Route::resource('users', Controllers\UsersController::class);
        Route::resource('categories', Controllers\CategoriesController::class);
        Route::resource('notifications', Controllers\NotificationsController::class);
        Route::get('list-permissions', [Controllers\PermissionsController::class, 'list']);
        Route::get('list-categories', [Controllers\CategoriesController::class, 'list']);
        //
    });
});
