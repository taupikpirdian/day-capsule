<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::controller(LogoutController::class)
        ->group(function() {
            Route::get('/logout', 'perform')->name('logout.perform');
        });

    Route::controller(DashboardController::class)
        ->group(function() {
            Route::group(['middleware' => ['auth']], function() {
                Route::get('/','index');
            });
        });

    Route::controller(PermissionController::class)
        ->group(function() {
            Route::group(['middleware' => ['auth']], function() {
                Route::get('/permissions','index');
            });
        });

    Route::group(['middleware' => ['roleCheck:admin']], function() {
        /**
         * role
         */
        Route::resource('roles', RoleController::class);
        /**
         * user
         */
        Route::resource('users', UserController::class);
        Route::post('users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
        /**
         * activity
         */
        Route::resource('activity', ActivityController::class);
    });
});

Route::get('file/{storage}/{uuid}/{filename}', function ($storage, $uuid, $filename) {
    $path = storage_path('app/public/' . $storage . '/' . $uuid . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('file.show');